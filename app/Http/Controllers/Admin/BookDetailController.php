<?php

namespace App\Http\Controllers\Admin;

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

class BookDetailController extends Controller
{
    public function index($id)
    {   
        $bookdetail = BookDetail::where('book_id', '=', $id)->paginate(5);
        $book = Book::find($id);

        return view('admin.bookdetail.index', compact('book', 'bookdetail'));
    }

    public function edit($id)
    {
        $bookdetail = BookDetail::findOrFail($id);

        return view('admin.bookdetail.edit', compact('bookdetail'));
    }

    public function update(Request $request, $id)
    {
        $idBook = BookDetail::find($id)->book_id;
        BookDetail::findOrFail($id)
        ->fill([
            'isAvailable' => $request->available,
        ])
        ->save();

        return redirect("admin/bookdetail/list/$idBook")->with('message', 'EDITED SUCCESS!');
    }

    public function create($id)
    {        
        BookDetail::Create([
            'book_id' => $id,
            'isAvailable' => 1,
        ]);      
             
            return redirect()->back()->with('message', 'CREATED SUCCESS!');
    }    
    

    public function destroy($id)
    {
        if( BookDetail::where('id', $id)->where('isAvailable', 0)->first() )
	{
		return redirect()->back()->with([ 'error' => 'This book has already been borrowed']);
    }
        BookDetail::find($id)->delete();

        return redirect()->back()->with('message', 'DELETED SUCCESS!');
    }
}
