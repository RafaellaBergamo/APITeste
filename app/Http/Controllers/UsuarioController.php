<?php

namespace App\Http\Controllers;

use App\Helpers\EnderecosHelper;
use App\Helpers\UsuarioHelper;
use App\Http\Requests\CreateUserRequest;
use App\Models\Usuario as ModelsUsuario;
use App\Rules\ValidarCpf;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
    /**
     * Método responsável por cadastrar um usuário
     *
     * @param CreateUserRequest $request
     * 
     * @throws ValidationException
     * @throws Exception
     * 
     * @return JsonResponse
     */
    public function cadastrar(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $dadosValidados = $request->validate([
                'nome' => 'required|string|max:255',
                'cpf' => ['required', new ValidarCpf],
                'dataNascimento' => 'required|date_format:d/m/Y|before:today',
                'telefone' => 'required|regex:/^\d{10,11}$/',
                'cep' => 'required|digits:8',
                'email' => 'required|email',
                'complemento' => 'string|nullable',
                'numero' => 'integer'
            ]);

            $cep = $dadosValidados['cep'];

            $endereco = EnderecosHelper::buscarDadosEndereco($cep);

            if (empty($endereco)) {
                throw new Exception("CEP não encontrado");
            }

            $dadosValidados['rua'] = $endereco['logradouro'];
            $dadosValidados['bairro'] = $endereco['bairro'];
            $dadosValidados['cidade'] = $endereco['localidade'];
            $dadosValidados['estado'] = $endereco['uf'];

            $dadosValidados['dataNascimento'] = Carbon::createFromFormat('d/m/Y', $dadosValidados['dataNascimento'])->format('Y-m-d');

            $usuario = ModelsUsuario::create($dadosValidados);

            DB::commit();

            return response()->json(["message" => "Usuário cadastrado com sucesso!", "dados" => $usuario], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Método responsável por atualizar um usuário
     *
     * @param CreateUserRequest $request
     * 
     * @throws ValidationException
     * @throws Exception
     * 
     * @return JsonResponse
     */
    public function atualizar(Request $request, int $idUsuario): JsonResponse
    {
        try {
            DB::beginTransaction();

            $dadosValidados = $request->validate([
                'nome' => 'nullable|string|max:255',
                'cpf' => ['nullable', new ValidarCpf],
                'dataNascimento' => 'nullable|date_format:d/m/Y|before:today',
                'telefone' => 'nullable|regex:/^\d{10,11}$/',
                'cep' => 'nullable|digits:8',
                'email' => 'nullable|email',
                'complemento' => 'nullable|string',
                'numero' => 'nullable|integer'
            ]);

            $usuario = ModelsUsuario::findOrFail($idUsuario);

            foreach ($dadosValidados as $campo => $valor) {
                if (!empty($valor)) {
                    $usuario->$campo = $valor;
                }
            }

            if (!empty($dadosValidados['dataNascimento'])) {
                $dataFormatada = Carbon::createFromFormat('d/m/Y', $dadosValidados['dataNascimento'])->format('Y-m-d');
                $usuario->dataNascimento = $dataFormatada;
            }

            $usuario->save();

            DB::commit();

            return response()->json(["message" => "Usuário $usuario->id atualizado com sucesso!","dados" => $usuario], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => "Usuário não encontrado."], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Busca todos os usuários cadastrados
     *
     * @throws ModelNotFoundException
     * @throws Exception
     * 
     * @return JsonResponse
     */
    public function buscar(): JsonResponse
    {
        try {
            $dadosUsuarios = ModelsUsuario::all();

            return response()->json($dadosUsuarios);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => "Erro ao buscar usuários."], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Busca o usuário pelo id informado
     *
     * @param int $idUsuario
     * 
     * @throws ModelNotFoundException
     * @throws Exception
     * 
     * @return JsonResponse
     */
    public function buscarPorId(int $idUsuario): JsonResponse
    {
        try {
            $dadosUsuario = ModelsUsuario::findOrFail($idUsuario);

            return response()->json($dadosUsuario);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => "Usuário não encontrado."], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Método responsável por desativar usuário
     *
     * @param int $idUsuario
     * 
     * @return JsonResponse
     */
    public function desativar(int $idUsuario): JsonResponse
    {
        try {
            $usuario = ModelsUsuario::findOrFail($idUsuario);

            $usuario->update(['status' => UsuarioHelper::STATUS_INATIVO]);

            return response()->json(["message" => "Usuário $usuario->id desativado com sucesso!"]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => "Usuário não encontrado."], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Exporta a tela de usuários para pdf
     *
     * @return void
     */
    public function exportar()
    {
        $usuarios = ModelsUsuario::all();
        $pdf = Pdf::loadView('pdf.usuarios', ['usuarios' => $usuarios]);

        return $pdf->download('usuarios.pdf');
    }
}
