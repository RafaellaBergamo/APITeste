<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidarCep implements Rule
{
    public function passes($attribute, $cep)
    {
        return preg_match("/^\d{8}$/", $cep);
    }

    public function message()
    {
        return 'O CEP informado é inválido.';
    }
}
