<?php

namespace App\Models\Pms;

use Illuminate\Database\Eloquent\Model;

class pmsSites extends Model
{
    protected $table = 'pms_sites

public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User','created_by');
    }
}
