<?php

namespace App\Models\Pms;

use Illuminate\Database\Eloquent\Model;

class pmsExpensePayments extends Model
{
    protected $table = 'pms_expenses_payments';


    public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function pmsAdvancePayment()
    {
        return $this->belongsTo('App\Models\Pms\pmsAdvancePayment','pms_advance_payment_id');
    }
}
