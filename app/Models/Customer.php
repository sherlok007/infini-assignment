<?php

namespace App\Models;
use App\Events\CustomerCreated;
use App\Events\CustomerUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'created' => CustomerCreated::class,
        'updated' => CustomerUpdated::class,
    ];

    protected $table = "customers";
    protected $fillable = ["first_name", "last_name", "mobile", "email_address", "status", "source"];
}
