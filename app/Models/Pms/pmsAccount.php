<?php

namespace App\Models\Pms;

use Illuminate\Database\Eloquent\Model;

class pmsAccount extends Model
{
    protected $table = 'pms_account';

    public function pmsAccountSubType()
    {
        return $this->belongsTo('App\Models\Pms\pmsAccountSubType');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User','updated_by');
    }

    public function pmsAdvancePaymentPayThrough(){
        return $this->hasMany('App\Models\Pms\pmsAdvancePayment','pay_through_id');
    }

    public function pmsAdvancePaymentPmsAccount(){
        return $this->hasMany('App\Models\Pms\pmsAdvancePayment','pms_account_id');
    }

    public function pmsexpenses()
    {
        return $this->hasMany('App\Models\Pms\pmsexpenses','pms_account_id');
    }

    public function pmsIncomeAccount()
    {
        return $this->hasMany('App\Models\Pms\pmsIncome','pms_account_id');
    }

    public function pmsIncomeReceiveThrough()
    {
        return $this->hasMany('App\Models\Pms\pmsIncome','receive_through_id');
    }
}
