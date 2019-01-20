<?php

namespace App\Models\Pms;

use Illuminate\Database\Eloquent\Model;

class pmsContact extends Model
{
    protected $table = 'pms_contact';


    public function pmsContactCategory()
    {
        return $this->belongsTo('App\Models\Pms\pmsContactCategory');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User','updated_by');
    }

    public function pmsAdvancePayment()
    {
    	return $this->hasMany('App\Models\Pms\pmsAdvancePayment','pms_contact_id');
    }

    public function pmsexpenses()
    {
        return $this->hasMany('App\Models\Pms\pmsexpenses','pms_contact_id');
    }

    public function pmsIncome()
    {
        return $this->hasMany('App\Models\Pms\pmsIncome','pms_contact_id');
    }
}
