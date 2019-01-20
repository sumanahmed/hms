<?php

namespace App\Models\Pms;

use Illuminate\Database\Eloquent\Model;

class pmsHoliday extends Model
{
   protected $table = 'pms_holiday';

   public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User','updated_by');
    }
}
