<?php

namespace App\Models\Damage;

use Illuminate\Database\Eloquent\Model;

class DamageItem extends Model
{
    protected $table = "damage_items";

    public function item()
    {
        return $this->belongsTo('App\Models\Inventory\Item','item_id');
    }
}
