<?php

namespace App\Http\Controllers;

use App\Libraries\LibOnApi;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $libOnApi;

    public function __construct(LibOnApi $libOnApi)
    {
        $this->libOnApi = $libOnApi;
    }

    public function index(Request $request)
    {
        $params = [
            'user_id' =>  $request->session()->has('userId') ? $request->session()->get('userId') : null
        ];

        $data = $this->libOnApi->getOrderList($params);

        if (!empty($data->orders)) {
            return view('orders.index', compact('data'));
        } else {
            return redirect()->back()->withErrors('lấy dữ liệu không thành công');
        }
    }
}
