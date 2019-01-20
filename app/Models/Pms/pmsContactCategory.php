<?php

namespace App\Models\Pms;

use Illuminate\Database\Eloquent\Model;

class pmsContactCategory extends Model
{
    protected $table = 'pms_contact_category';

    public function pmsContact()
    {
        return $this->hasMany('App\Models\Pms\pmsContact');
    }
}
