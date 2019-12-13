<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Book;
use App\BookDetail;
use App\Location;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function index()
    {   
        if(!isset($_GET['title'])) {
            $_GET['title'] ='';
        }

        return Book::where('title', 'LIKE', '%'.$_GET['title'].'%')->get();
    }

    public function detail($id) {
        return $book = Book::findOrFail($id);
    }

    public function getImage($slug) {
        return view('API.image', compact('slug'));
    }
}
