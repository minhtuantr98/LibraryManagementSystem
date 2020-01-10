<?php
namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Charts;
use App\Charts\ReportChart;
use App\Book;
use App\BookDetail;
use App\Location;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Exceptions\ModelCouldNotDeletedException;

class ReportController extends Controller
{
    public function index() 
    {
        $usersChart = new ReportChart;
        $bookcount = DB::table('books')->select('title')->get()->count();
        $books = DB::table('books')->select('title')->get();
        $borrow = DB::table('borrowed_note_detail')
            ->join('book_detail', 'book_detail.id', '=', 'borrowed_note_detail.book_detail_id')
            ->join('books', 'books.id', '=', 'book_detail.book_id')
            ->select('books.title',  DB::raw('count(*) as total'))
            ->groupBy('books.title')
            ->get();
        $borrowcount = DB::table('borrowed_note_detail')
            ->join('book_detail', 'book_detail.id', '=', 'borrowed_note_detail.book_detail_id')
            ->join('books', 'books.id', '=', 'book_detail.book_id')
            ->select('books.title',  DB::raw('count(*) as total'))
            ->groupBy('books.title')
            ->get()
            ->count();
        for($i = 0; $i < $borrowcount ; $i++) {
                $data[$i] = $borrow[$i]->total;
            }
        for($i = 0; $i < $bookcount ; $i++) {
            $label[$i] = $books[$i]->title;
        }

        $usersChart->labels($label);
        $usersChart->dataset('Total borrow', 'line', $data);
        return view('admin.report.index', [ 'usersChart' => $usersChart ] );
    }
}
