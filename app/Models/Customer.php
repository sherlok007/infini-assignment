<?php

namespace App\Models;
use App\Events\CustomerCreated;
use App\Events\CustomerUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'created' => CustomerCreated::class,
        'updated' => CustomerUpdated::class,
    ];

    protected $table = "customers";
    protected $fillable = ["first_name", "last_name", "mobile", "email_address", "status", "source"];

    public static function getCustomer() {
        $records = DB::table('customers')
            ->join('source', 'customers.source', '=', 'source.id')
            ->join('status', 'customers.status', '=', 'status.id')
            ->select('customers.*', 'source.name as srcname', 'status.name as stsname')->get();
        return $records;
    }
}
