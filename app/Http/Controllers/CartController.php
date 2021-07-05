<?php

namespace App\Http\Controllers;

use App\Cart;
use stdClass;
use App\Libraries\LibOnApi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    const PICKUP = 1; //tu den lay
    const SHIPPING = 2; //ship

    public function __construct()
    {
        $this->libonApi = new LibOnApi();
    }

    public function borrowBook(Request $request)
    {
        try {
            $params = $request->all();

            $validatorArray = [
                'books' => 'required',
                'user_id'  => 'required',
                'delivery' => 'integer',
                'address' => Rule::requiredIf($params['delivery'] == $this::SHIPPING)
            ];
            $messages = [
                'books.required' => 'Thiếu thông tin sách',
                'user_id.required'  => 'Thiếu thông tin người mượn',
                'delivery.integer' => 'Thiếu dữ liệu hình thức lấy sách',
                'address.required' => 'Thiếu địa chỉ nhận sách'
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            // dd($params['books']);

            $errors = '';
            foreach ($params['books'] as $key => $book) {
                $result = $this->libonApi->checkPending(['book_id' => $key]);
                if ($result->success && $result->isPending) {
                    $errors .= $book . ' đang trong hàng đợi; ';
                }

                $result = $this->libonApi->checkBorrowable(['book_id' => $key]);
                if ($result->success && !$result->isBorrowable) {
                    $errors .= $book . ' đang không thể mượn; ';
                }
            }

            // dd($errors);
            if ($errors) {
                return redirect()->back()->withInput()->withErrors($errors);
            }

            $sendData = [
                'user_id' => $params['user_id'],
                'books' => $params['books'],
                'delivery' => $params['delivery'],
                'address' => array_key_exists('address', $params) ? $params['address'] : null
            ];

            $result = $this->libonApi->createBorrowOrder($sendData);

            if (!empty($result->success)) {
                $request->session()->forget('cart');
                return view('cart.done', compact('result'));
                // return redirect()->route('cart.borrow_book_done', $result->orderId)->with(['success' => 'Mượn sách thành công']);
            } else {
                return redirect()->route('cart.show')->withErrors('Mượn sách không thành công');
            }
        } catch (\Throwable $th) {
            Log::error('[Order Add Client]' . $th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function addBookToCart(Request $request)
    {
        try {
            $result = new stdClass();
            $params = $request->all();

            $validatorArray = [
                'book_name' => 'required',
                'book_id' => 'required',
                'pic' => 'required',
            ];
            $messages = [
                'book_name.required' => 'Thiếu tên sách',
                'book_id.required' => 'Thiếu mã sách',
                'pic.required' => 'Thiếu link ảnh của sách',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                $result->result = 0;
                $result->detail = $validator->errors();
                $result->message = 'Thêm lỗi, thiếu thông tin. Vui lòng thử lại';
                return \response()->json($result);
            }

            $book = [
                'book_name' => $params['book_name'],
                'pic' => $params['pic']
            ];

            $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
            $newCart = new Cart($oldCart);

            $newCart->addCart($book, $params['book_id']);

            $request->session()->put('cart', $newCart);

            $result->result = 1;
            $result->html = view('layouts.cart', compact('newCart'))->render();
            // dd($result->html);
            $result->message = 'Thêm vào giỏ sách thành công';
            $result->quantity = $newCart->totalQuantity;
            return \response()->json($result);
        } catch (\Throwable $th) {
            $result->detail = $th->getMessage();
            $result->message = 'Lỗi thêm giỏ. Vui lòng thử lại';
            $result->result = 0;
            return \response()->json($result);
        }
    }

    public function deleteBookInCart(Request $request)
    {
        try {
            $result = new stdClass();
            $params = $request->all();

            $validatorArray = [
                'book_id' => 'required',
                // 'delivery' => 'integer',
                // 'address' => Rule::requiredIf($params['delivery'] == $this::SHIPPING)
            ];
            $messages = [
                'book_id.required' => 'Thiếu mã sách',
                // 'delivery.integer' => 'Thiếu dữ liệu hình thức lấy sách',
                // 'address.required' => 'Thiếu địa chỉ nhận sách'
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                $result->result = 0;
                $result->detail = $validator->errors();
                $result->message = 'Xóa lỗi, thiếu thông tin. Vui lòng thử lại';
                return \response()->json($result);
            }

            $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
            $newCart = new Cart($oldCart);

            $newCart->deleteCart($params['book_id']);

            // $deliInfo = array(
            //     'delivery' => $params['delivery'],
            //     'address' => array_key_exists('address', $params) ? $params['address'] : null
            // );

            // dd($params, $deliInfo);

            if ($newCart->totalQuantity > 0) {
                $request->session()->put('cart', $newCart);
                $result->html = view('layouts.cart', compact('newCart'))->render();
                $result->table = view('layouts.cart-table', compact('newCart'))->render();
                $result->quantity = $newCart->totalQuantity;
            } else {
                $request->session()->forget('cart', $newCart);
                $result->html = view('layouts.cart-empty')->render();
                $result->table = view('layouts.cart-table-empty')->render();
                $result->quantity = $newCart->totalQuantity;
            }

            $result->result = 1;
            // dd($result->html);
            $result->message = 'Xóa sách khỏi giỏ sách thành công';
            return \response()->json($result);
        } catch (\Throwable $th) {
            $result->detail = $th->getMessage();
            $result->message = 'Lỗi xóa giỏ. Vui lòng thử lại';
            $result->result = 0;
            return \response()->json($result);
        }
    }

    public function show()
    {
        return view('cart.show');
    }
}
