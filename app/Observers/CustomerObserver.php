<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\CustomerHistory;
use PDOException;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        if ($customer->id) {
            try {
                $customer_history = new CustomerHistory();
                $customer_history->first_name = $customer->first_name;
                $customer_history->last_name = $customer->last_name;
                $customer_history->mobile = $customer->mobile;
                $customer_history->email_address = $customer->email_address;
                $customer_history->profile_pic = $customer->profile_pic;
                $customer_history->status = $customer->status;
                $customer_history->source = $customer->source;
                $customer_history->save();
            } catch(PDOException $e) {
                return $e->getMessage();
            }

        }
    }

    /**
     * Handle the Customer "updated" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function updated(Customer $customer)
    {
        $customer_history = CustomerHistory::find($customer->id);
        $customer_history->first_name = $customer->first_name;
        $customer_history->last_name = $customer->last_name;
        $customer_history->mobile = $customer->mobile;
        $customer_history->email_address = $customer->email_address;
        $customer_history->profile_pic = $customer->profile_pic;
        $customer_history->status = $customer->status;
        $customer_history->source = $customer->source;
        $customer_history->save();
    }

    /**
     * Handle the Customer "deleted" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function deleted(Customer $customer)
    {
        //
    }

    /**
     * Handle the Customer "restored" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function restored(Customer $customer)
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function forceDeleted(Customer $customer)
    {
        //
    }
}
