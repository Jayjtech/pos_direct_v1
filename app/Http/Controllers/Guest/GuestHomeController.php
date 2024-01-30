<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestHomeController extends Controller
{
    public function home(){
        return view('guest.home');
    }

    public function contactForm(){
        return view('guest.contact_form');
    }
}