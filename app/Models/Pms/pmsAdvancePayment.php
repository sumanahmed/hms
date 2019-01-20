<?php

namespace App\Models\Pms;

use Illuminate\Database\Eloquent\Model;

class pmsAdvancePayment extends Model
{
    protected $table = 'pms_advance_payment';

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

    public function payThrough()
    {
        return $this->belongsTo('App\Models\Pms\pmsAccount','pay_through_id');
    }

    public function pmsAccount()
    {
        return $this->belongsTo('App\Models\Pms\pmsAccount','pms_account_id');
    }

    public function pmsExpensePayment()
    {
        return $this->hasMany('App\Models\Pms\pmsExpensePayments','pms_advance_payment_id');
    }

    public function pmsPayslipsPayment()
    {
        return $this->hasMany('App\Models\Pms\PmsPayslipsPayment','pms_advance_payment_id');
    }
}
