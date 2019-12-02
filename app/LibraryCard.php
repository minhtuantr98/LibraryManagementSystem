<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class LibraryCard extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reader_id', 'admin_id', 'date_create', 'date_end'
    ];

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'library_card';
}
