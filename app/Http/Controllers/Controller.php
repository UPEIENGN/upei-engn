<?php

namespace App\Http\Controllers;

use App\FetchesCart;
use App\Models\Cart;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests;
    use FetchesCart;
}
