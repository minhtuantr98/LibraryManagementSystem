<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Book extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'admin_id', 'slug', 'number_of_page', 'price', 'total', 'author', 'image', 'publishing_company', 'location_id', 'category_id'
    ];

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';
}
