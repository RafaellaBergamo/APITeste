<?php

namespace App\Helpers;

use App\Models\Usuario;

class UsuarioHelper
{
    const STATUS_ATIVO = 1;
    const STATUS_INATIVO = 0;

    /**
     * Verifica se há algum usuário com o mesmo cpf
     *
     * @param string $cpf
     * 
     * @return bool
     */
    static function cpfEmuso(string $cpf): bool
    {
        return Usuario::where('cpf', $cpf)->exists();
    }
}
