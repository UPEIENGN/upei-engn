<?php

namespace App\Http\Controllers;

use App\Models\Society;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('admin/Dashboard', [
            'society' => Society::first(),
        ]);
    }
}
