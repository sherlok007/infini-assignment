<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerHistory extends Model
{
    use HasFactory;

    protected $table = "customer_history";
    protected $fillable = ["first_name", "last_name", "mobile", "email_address", "status", "source"];
}
