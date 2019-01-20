<?php

namespace App\Models\MoneyOut;

use Illuminate\Database\Eloquent\Model;

class BillFreeReceiveEntry extends Model
{
    protected  $table = "bill_free_receive_entry";

    public function bill()
    {
        return $this->belongsTo('App\Models\MoneyOut\Bill', 'bill_id');
    }
}
