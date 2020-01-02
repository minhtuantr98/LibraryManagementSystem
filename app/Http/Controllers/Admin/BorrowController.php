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
            ->select('borrowed_note.id', 'readers.name', 'borrowed_note.is_payed')
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
        $borrownote = DB::table('borrowed_note_detail')
        ->join('book_detail', 'borrowed_note_detail.book_detail_id', '=', 'book_detail.id')
        ->join('books', 'books.id', '=', 'book_detail.book_id')
        ->select('borrowed_note_detail.book_detail_id' , 'borrowed_note_detail.indemnification_money', 'books.title')
        ->where('borrowed_note_detail.borrowed_note_id', '=', $id)->get();
        
        if( BorrowedNoteDetail::where('borrowed_note_id', '=', $id)->where('indemnification_money', '=', -1)->first() == null) {
            $canPay = 1;
        } else {
            $canPay = 2;
        }

        return view('admin.notes.pay', compact('borrownote', 'id', 'canPay'));
    }

    public function update(Request $request, $id)
    {
        
        BorrowedNote::findOrFail($id)
        ->fill([
            'is_payed' => 1,
            'date_pay' => Carbon::now()
        ])
        ->save();

        return redirect('admin/borrow')->with('message', 'PAYED SUCCESS!');
    }

    public function payBook(Request $request, $idNote, $idBook)
    {
        $this->validate($request, [
            'indemnification_money' => 'required',
        ]);
        if( $request->indemnification_money == -1 )
            {
                $money = 0;
            }
        else {
            $money = $request->indemnification_money;
        }
        BorrowedNoteDetail::where([['book_detail_id','=',$idBook],['borrowed_note_id','=', $idNote]])->first()
        ->fill([
            'indemnification_money' => $money,
            'date_pay_real' => Carbon::now(),
        ])
        ->save();

        // BookDetail::findorFail($idBook)
        // ->fill([
        //     'isAvailable' => 1,
        // ])
        // ->save();
 
        return redirect()->back();
    }

    public function payDetail($id) 
    {
        $payDetail = DB::table('borrowed_note')
            ->join('borrowed_note_detail', 'borrowed_note.id', '=', 'borrowed_note_detail.borrowed_note_id')
            ->join('book_detail', 'borrowed_note_detail.book_detail_id', '=', 'book_detail.id')
            ->join('books', 'books.id', '=', 'book_detail.book_id')
            ->select('book_detail.id', 'books.title', 'borrowed_note_detail.date_pay_real', 'borrowed_note_detail.indemnification_money')
            ->where('borrowed_note.id', $id)
            ->get();

        return view('admin.notes.paydetail', compact('payDetail'));
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
                    'book_detail_id' => BookDetail::where('book_id', $books[$i])->where('isAvailable', 1)->orderBy('id', 'desc')->first()->id,
                    'borrowed_note_id' => BorrowedNote::orderBy('id', 'desc')->first()->id,
                    'indemnification_money' => -1,
                    'date_pay_real' => Carbon::now()->addMonth(6),
                ]);
                // BookDetail::where('book_id', $books[$i])->where('isAvailable', 1)->orderBy('id', 'desc')->first()
                //     ->fill([
                //         'isAvailable' => 0,
                //         ])
                //     ->save();
            }

            return (['message' => 'Success']);
    }

}
