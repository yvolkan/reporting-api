<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'birthday', 'gender'];

    /**
     * Get the client card.
     */
    public function card()
    {
        return $this->hasMany(ClientCard::class, 'client_id', 'id');
    }

    /**
     * Get the client billing address.
     */
    public function address()
    {
        return $this->hasMany(ClientAddress::class, 'client_id', 'id');
    }
}
