<?php

namespace App\Models\Damage;

use Illuminate\Database\Eloquent\Model;

class DamageAdjustmentEntry extends Model
{
    protected $table = "damage_adjustment_entries";

    public function item()
    {
        return $this->belongsTo('App\Models\Inventory\Item','item_id');
    }
}
