<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    protected  $table = "special_offers";

    public function item()
    {
        return $this->belongsTo('App\Models\Inventory\Item','sku_id');
    }
    public function freeItem()
    {
        return $this->belongsTo('App\Models\Inventory\Item','free_sku_id');
    }

    public function contact()
    {
        return $this->belongsTo('App\Models\Contact\Contact','company_id');
    }


}
