<?php

namespace App\Http\Controllers;

class ControladorWebTakeaway extends Controller
{
    public function index()
    {
            return view("web.takeaway");
    }
}
