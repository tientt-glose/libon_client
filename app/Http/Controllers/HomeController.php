<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Libraries\LibOnApi;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->libonApi = new LibOnApi();
    }

    public function index()
    {
        $data = $this->libonApi->getProductAll();
        $books = $data->result->book;
        $ITs = $data->result->IT;
        $theories = $data->result->theory;
        // dd($data);
        return view('home.index', compact('books', 'ITs', 'theories'));
    }
}
