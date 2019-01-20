<?php

namespace App\Models\Pms;

use Illuminate\Database\Eloquent\Model;

class pmsIncome extends Model
{
    protected $table = 'pms_income';


    public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User','updated_by');
    }

    public function pmsContact()
    {
        return $this->belongsTo('App\Models\Pms\pmsContact','pms_contact_id');
    }

    public function pmsAccount()
    {
        return $this->belongsTo('App\Models\Pms\pmsAccount','pms_account_id');
    }

    public function receiveThrough()
    {
        return $this->belongsTo('App\Models\Pms\pmsAccount','receive_through_id');
    }
}
