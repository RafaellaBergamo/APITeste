<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Usuario;

class ValidarCpf implements Rule
{
    public function passes($attribute, $cpf)
    {
        $cpfApenasNumeros = preg_replace('/[^0-9]/', '', $cpf);

        return self::cpfValido($cpfApenasNumeros);
    }

    public function message()
    {
        return 'O CPF informado não é válido ou está em uso.';
    }

    /**
     * Valida se o CPF enviado é válido
     * 
     * @param string $cpf
     * 
     * @return bool
     */
    static function cpfValido(string $cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) !== 11) {
            return false;
        }

        $novePrimeirosDigitos = substr($cpf, 0, 9);

        $primeiroDigitoVerificador = self::calcularDigitoVerificadorCpf($novePrimeirosDigitos, 10);
        $segundoDigitoVerificador = self::calcularDigitoVerificadorCpf($novePrimeirosDigitos . $primeiroDigitoVerificador, 11);

        return ($primeiroDigitoVerificador == $cpf[9] && $segundoDigitoVerificador == $cpf[10]);
    }

    /**
     * Método responsável por calcular o dígito verificador do cpf
     *
     * @param string $base
     * @param int $posicao
     * 
     * @return int
     */
    static function calcularDigitoVerificadorCpf(string $base, int $posicao): int
    {
        $soma = 0;

        for ($i = 0; $i < strlen($base); $i++) {
            $soma += $base[$i] * $posicao--;
        }

        $resto = $soma % 11;

        if ($resto < 2) {
            return 0;
        } else {
            return 11 - $resto;
        }
    }
}
