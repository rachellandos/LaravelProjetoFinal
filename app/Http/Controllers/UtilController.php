<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilController extends Controller
{
    public function loadWelcome () {
    return view('welcome');
}

// public function helloMessage (string $message) {
//     return '<h1>Hello '.$message.'.</h1>';
// }

public function loadHomepage () {

    return view('home');
}

// public function loadAllUsers(){
//     return view('users.allusers');
// }

// public function loadAddUsers(){
//     return view('users.addusers');
// }

public function loadFallback(){
    return view('utils.fallback');
}

}
