<?php

namespace App\Models\Pms;

use Illuminate\Database\Eloquent\Model;

class pmsAccountSubType extends Model
{
    protected $table = 'pms_account_sub_type';

    public function pmsAccountType()
    {
        return $this->belongsTo('App\Models\Pms\pmsAccountType');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function pmsAccount()
    {
        return $this->hasMany('App\Models\Pms\pmsAccount');
    }
}
