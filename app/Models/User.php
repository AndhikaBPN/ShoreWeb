<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users'; // Specify the name of the table in the database

    protected $primaryKey = 'id'; // Specify the primary key column name

    protected $fillable = [ // Specify the columns that are fillable (can be mass-assigned)
        'nama',
        'username',
        'password',
    ];

    public $timestamps = false;
}
