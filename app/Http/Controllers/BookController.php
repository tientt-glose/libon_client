<?php

namespace App\Http\Controllers;

use App\Libraries\LibOnApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    protected $libOnApi;

    public function __construct(LibOnApi $libOnApi)
    {
        $this->libOnApi = $libOnApi;
    }

    public function detail(Request $request)
    {
        $params = [
            'id' =>  $request->id
        ];
        $data = $this->libOnApi->getBookDetail($params);
        $book = $data->result;

        $data = $this->libOnApi->getBookComment($params);
        $comment = $data->result;
        $cmCount = count($comment);

        return view('books.detail', compact('book', 'comment', 'cmCount'));
    }

    public function storeComment($bookId, Request $request)
    {
        try {
            $params = $request->all();

            $validatorArray = [
                'content' => 'required',
                'user_id'  => 'required',
            ];
            $messages = [
                'content.required' => 'Thiếu nội dung bình luận',
                'user_id.required'  => 'Thiếu thông tin người bình luận',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $sendData = [
                'user_id' => $params['user_id'],
                'book_id' => $bookId,
                'content' => $params['content'],
            ];

            $result = $this->libOnApi->createComment($sendData);

            if (!empty($result->success)) {
                return redirect()->back()->with(['success' => 'Bình luận thành công']);
            } else {
                return redirect()->back()->withErrors('Bình luận không thành công');
            }
        } catch (\Throwable $th) {
            Log::error('[Comment Add Client]' . $th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }
}
