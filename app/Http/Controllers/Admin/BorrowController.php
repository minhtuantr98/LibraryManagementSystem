<?php


namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use App\Book;
use App\Location;
use Carbon\Carbon;
use App\BookDetail;
use App\LibraryCard;
use App\BorrowedNote;
use App\BorrowedNoteDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class BorrowController extends Controller
{
    public function index()
    {
        $notes = DB::table('borrowed_note')
            ->join('library_card', 'borrowed_note.library_card_id', '=', 'library_card.id')
            ->join('readers', 'readers.id', '=', 'library_card.reader_id')
            ->select('borrowed_note.id', 'readers.name')
            ->orderBy('id', 'asc')
            ->get();

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
        $borrownote = DB::table('borrowred_note');

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
        return view('admin.notes.create');
    }

    public function store(Request $request)
    {        
            $books = $request->books;

            BorrowedNote::Create([
                'library_card_id' => $request->reader ,
                'date_create' => Carbon::now(),
                'date_pay' => Carbon::now()->addMonth(6),
                'is_payed' => 0,
                'total' => $request->total
            ]);
            
            for($i = 0 ; $i < $request->total; $i++) {
                BorrowedNoteDetail::Create([
                    'book_detail_id' => BookDetail::where('book_id', $books[$i])->where('isAvailable', 1)->first()->id,
                    'borrowed_note_id' => BorrowedNote::orderBy('id', 'desc')->first()->id,
                    'indemnification_money' => 0,
                    'date_pay_real' => Carbon::now()->addMonth(6),
                ]);
            }

            return (['message' => 'Success']);
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
