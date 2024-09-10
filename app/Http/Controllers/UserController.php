<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function view_current_user_profile(Request $request)
    {
        return Inertia::render('Views/Profile');
    }
}
