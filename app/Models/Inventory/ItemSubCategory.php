<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class ItemSubCategory extends Model
{
    protected $table = 'item_sub_category';

    protected $fillable = [
        'id',
        'item_sub_category_name',
        'item_sub_category_description',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User','updated_by');
    }

}
