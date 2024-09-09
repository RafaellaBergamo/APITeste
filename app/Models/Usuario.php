<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'dataNascimento',
        'telefone',
        'cep',
        'email',
        'complemento',
        'numero',
        'rua',
        'endereco',
        'bairro',
        'estado',
        'cidade',
        'status'
    ];
}
