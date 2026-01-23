<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessProofController extends Controller
{

    public function business_proof()
    {
        return view('business_proof');
    }

    public function salaried_proof()
    {
        return view('salaried_proof');
    }

}
