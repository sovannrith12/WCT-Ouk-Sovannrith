<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController; // Alias the base Laravel Controller

abstract class Controller extends BaseController // Extend Laravel's core Controller
{
    use AuthorizesRequests, ValidatesRequests; // Include common traits
}