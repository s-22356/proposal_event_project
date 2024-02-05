<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class ProposeUser extends Model
{
    use HasFactory;
    protected $table        =   'tbl_propose_user';
    public $timestamps      =   false;
    protected $connection = 'mysql';

    protected $fillable = [
        'p_uid ', 'p_user_token', 'p_user_phone', 'p_user_key', 'is_profile', 'is_active','created_at'
    ];
}
