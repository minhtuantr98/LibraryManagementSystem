<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
class BorrowedNoteDetail extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_detail_id', 'borrowed_note_id', 'indemnification_money', 'date_pay_real', 
    ];

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'borrowed_note_detail';
    protected $primaryKey = ['borrowed_note_id', 'book_detail_id'];
    public $timestamps = false;
    public $incrementing = false;

    protected function setKeysForSaveQuery(Builder $query)
    {
        return $query->where('borrowed_note_id', $this->getAttribute('borrowed_note_id'))
                     ->where('book_detail_id', $this->getAttribute('book_detail_id'));
    }
}
