<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Exceptions\ModelCouldNotDeletedException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Book extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'admin_id', 'slug', 'number_of_page', 'price', 'total', 'author', 'image', 'publishing_company', 'location_id', 'category_id', 'isDeleted'
    ];

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

    public function delete()
    {   
        if (DB::table('borrowed_note_detail')
        ->join('book_detail', 'borrowed_note_detail.book_detail_id' , '=', 'book_detail.id')
        ->join('books', 'book_detail.book_id' , '=', 'books.id')
        ->where('books.id' , $this->id)
        ->count() > 0 ){
            throw new ModelCouldNotDeletedException();
        }
    
        return parent::delete();
    }
}
