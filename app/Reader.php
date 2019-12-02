<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Reader extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'date_of_birth', 'sex', 'address', 'telephone', 'class', 'CMTND'
    ];

       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'readers';
}
