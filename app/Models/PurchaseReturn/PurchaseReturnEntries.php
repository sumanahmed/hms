<?php

namespace App\Models\PurchaseReturn;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnEntries extends Model
{
    protected $table = "purchase_return_entries";

    public function item()
    {
        return $this->belongsTo('App\Models\Inventory\Item','product_id');
    }
    public function customer()
    {
        return $this->belongsTo('App\Models\Contact\Contact', 'company_id');
    }
}
