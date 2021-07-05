<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Libraries\LibOnApi;

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
        return view('books.detail', compact('book'));
    }
}
