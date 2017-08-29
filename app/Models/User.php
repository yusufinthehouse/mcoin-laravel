<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB,
    Exception;

class User extends Model {
    
    /**
     *  Initiate model User
     */
    protected $table = "users";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ['email', 'password', 'full_name', 'birth_date', 'photo'];
    
}
