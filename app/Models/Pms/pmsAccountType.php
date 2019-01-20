<?php

namespace App\Models\Pms;

use Illuminate\Database\Eloquent\Model;

class pmsAccountType extends Model
{
    protected $table = 'pms_account_type';

    public function pmsAccountSubType()
    {
        return $this->hasMany('App\Models\Pms\pmsAccountSubType');
    }
}
