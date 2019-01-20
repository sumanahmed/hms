<?php

namespace App\Models\MoneyOut;

use Illuminate\Database\Eloquent\Model;

class BillFreeEntry extends Model
{
    protected  $table = "bill_free_entry";

    public function item()
    {
        return $this->belongsTo('App\Models\Inventory\Item','product_id');
    }



}
