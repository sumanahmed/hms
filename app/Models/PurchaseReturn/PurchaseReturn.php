<?php

namespace App\Models\PurchaseReturn;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    protected  $table = "purchase_return";

    public function customer()
    {
        return $this->belongsTo('App\Models\Contact\Contact', 'company_id');
    }
}
