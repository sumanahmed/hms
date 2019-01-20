<?php

namespace App\Modules\Test\Http\Controllers;

use App\Models\TestCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;

class TestApiController extends Controller
{
    public function getTestCategory(){
        $tests = TestCategory::selectRaw("name as text, id as value")->get();
        dd($tests);
        return response()->json([
            'tests'          =>  $tests
        ], 201);

    }
}
