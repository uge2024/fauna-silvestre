<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Spatie\Permission\Models\Role; // Esto no es necesario aquí, pero puedes necesitarlo
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
