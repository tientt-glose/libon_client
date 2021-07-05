<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $books = null;
    public $totalQuantity = 0;
    // protected $userID = null;

    public function __construct($cart)
    {
        if ($cart) {
            $this->books = $cart->books;
            $this->totalQuantity = $cart->totalQuantity;
            // $this->userID = $cart->userID;
        }
    }

    public function addCart($book, $bookId)
    {
        // dd($book, $bookId, );
        if ($this->books) {
            if (!array_key_exists($bookId, $this->books)) {
                $this->books[$bookId] = $book;
            }
        } else {
            $this->books[$bookId] = $book;
        }

        if ($this->books) {
            $this->totalQuantity = count($this->books);
        }
    }

    public function deleteCart($bookId)
    {
        if ($this->books[$bookId]) {
            unset($this->books[$bookId]);
            $this->totalQuantity = count($this->books);
        }
    }
}
