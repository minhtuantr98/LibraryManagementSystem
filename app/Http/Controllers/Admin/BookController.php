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

class BookController extends Controller
{
    public function index()
    {   
        if(!isset($_GET['title'])) {
            $_GET['title'] ='';
        }

        $books = Book::where('title', 'LIKE', '%'.$_GET['title'].'%')->paginate(5);

        return view('admin.books.index', compact('books'));
    }

    public function listing() 
    {
        return DB::table('books AS t')
           ->select('t.id AS value', 't.title AS text')
           ->get();
    }

    public function edit($id)
    {
        $categories = Category::all();
        $location = Location::all();
        $book = Book::findOrFail($id);

        return view('admin.books.edit', compact('categories', 'location', 'book'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|unique:books,title,'.Book::find($id)->id.'',
            'pages' => 'required|digits_between:2,5',
            'price' => 'required',
            'total' => 'required|digits_between:2,5',
            'company' => 'required',
        ]);
        
        if ($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();
            $request->file->storeAs('public/upload', $filename);
            Book::findOrFail($id)
            ->fill([
                'image' => $filename,
                ])
            ->save();
            }

        Book::findOrFail($id)
        ->fill([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'number_of_page' => $request->pages,
            'price' => $request->price,
            'total' => $request->total,
            'author' => $request->author,
            'publishing_company' => $request->company,
            'location_id' => $request->location,
            'category_id' => $request->category,
        ])
        ->save();

        return redirect('admin/book')->with('message', 'EDITED SUCCESS!');
    }

    public function create()
    {
        $location = Location::all();
        $categories = Category::all();

        return view('admin.books.create', compact('location', 'categories'));
    }

    public function store(Request $request)
    {        
        $this->validate($request, [
            'title' => 'required|unique:books',
            'pages' => 'required|digits_between:2,5',
            'price' => 'required',
            'total' => 'required|digits_between:2,5',
            'company' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        if ($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();
            $request->file->storeAs('public/upload', $filename);
            Book::Create([
                'admin_id' => Auth::user()->id,
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'number_of_page' => $request->pages,
                'price' => $request->price,
                'total' => $request->total,
                'author' => $request->author,
                'image' => $filename,
                'publishing_company' => $request->company,
                'location_id' => $request->location,
                'category_id' => $request->category,
            ]);
            for($i = 0 ; $i < $request->total; $i++) {
                BookDetail::Create([
                    'book_id' => Book::orderBy('id', 'desc')->first()->id,
                    'isAvailable' => 1,
                ]);
            }
            return redirect('admin/book')->with('message', 'CREATED SUCCESS!');
        }    
    }

    public function destroy($id)
    {
        // try {
        //     User::where('id', $id)->firstOrFail()->delete();
        // } catch (ModelCouldNotDeletedException $exception) {
        //     return (['error' => 'U cant delete it']);
        // }
        Book::where('id', $id)->firstOrFail()->delete();

        return redirect()->back()->with('message', 'DELETED SUCCESS!');;
    }
}
