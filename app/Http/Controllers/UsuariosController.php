<?php

namespace App\Http\Controllers;

use App\Http\Helpers\EnderecosHelper;
use App\Http\Requests\CreateUserRequest;
use App\Models\Usuario;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UsuariosController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
}
