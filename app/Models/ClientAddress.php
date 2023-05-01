<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'client_id', 'title', 'first_name', 'last_name', 'company', 'addres1', 'address2', 'city', 'post_code', 'state', 'country', 'phone', 'fax'];
}
