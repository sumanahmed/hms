<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Auth;

class WardBed extends Command
{

    protected $signature = 'ward:bed';

    protected $description = 'Ward Bed Charge add';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        
    }
}
