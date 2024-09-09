<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class EnderecosHelper
{
    /**
     * Retorna os dados do endereço informado
     *
     * @param string $cep
     * 
     * @return array
     */
    public static function buscarDadosEndereco(string $cep): array
    {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }
}
