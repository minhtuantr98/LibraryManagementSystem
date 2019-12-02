<?php


namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use App\Book;
use App\Location;
use App\LibraryCard;
use App\BorrowedNote;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class BorrowController extends Controller
{
    public function index()
    {
        $notes = BorrowedNote::all();

        return view('admin.notes.index', compact('notes'));
    }

    public function cardlisting() 
    {
         return DB::table('library_card AS t')
           ->select('t.id AS value', 't.id AS text')
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
        $librarycard = LibraryCard::all();
        $books = Book::all();

        return view('admin.notes.create', compact('librarycard', 'books'));
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
