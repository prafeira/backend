<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Services\PessoaService;
use Illuminate\Support\Facades\Hash;

class PessoaController extends Controller
{
    protected $pessoaService;

    public function __construct(PessoaService $pessoaService)
    {
        $this->pessoaService = $pessoaService;
    }

    /**
     * @OA\Get(
     *     path="/api/pessoas",
     *     tags={"Pessoa"},
     *     summary="Retorna pessoas",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function index()
    {
        $pessoas = Pessoa::with('funcao', 'vendas')->get();

        return $pessoas;
    }

    /**
     * @OA\Post(
     *     path="/api/pessoas",
     *     tags={"Pessoa"},
     *     summary="Adiciona uma nova pessoa",
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="nome", type="string", description="Nome da pessoa"),
     *                 @OA\Property(property="cpf", type="string", description="CPF da pessoa"),
     *                 @OA\Property(property="funcao_id", type="integer", description="ID da função"),
     *                 @OA\Property(property="comissao", type="float", description="Comissão da pessoa"),
     *                 @OA\Property(property="telefone", type="string", description="Telefone da pessoa"),
     *                 @OA\Property(property="data_admissao", type="date", description="Data de admissão da pessoa"),
     *                 @OA\Property(property="data_desligamento", type="date", description="Data de desligamento da pessoa"),
     *                 @OA\Property(property="empresa_id", type="integer", description="ID da empresa"),
     *                 @OA\Property(property="email", type="string", description="E-mail da pessoa"),
     *                 @OA\Property(property="password", type="string", description="Senha da pessoa"),
     *                 @OA\Property(property="name", type="string", description="Nome da pessoa"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response="201", description="Pessoa adicionada com sucesso")
     * )
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'funcao_id' => 'required|integer',
            'comissao' => 'required|numeric',
            'telefone' => 'nullable|string|max:255',
            'data_admissao' => 'required|date',
            'data_desligamento' => 'nullable|date',
            'empresa_id' => 'required|integer',
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:pessoa',
            'password' => 'required|string|min:8', // Defina os requisitos da senha conforme necessário
        ]);

        // Adicione a senha criptografada aos dados antes de criar a pessoa
        $dados['password'] = Hash::make($dados['password']);

        $pessoa = $this->pessoaService->adicionarPessoa($dados);

        return response()->json($pessoa, 201);
    }


    /**
     * @OA\Put(
     *     path="/api/pessoas/{id}",
     *     tags={"Pessoa"},
     *     summary="Edita uma pessoa existente",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da pessoa a ser editada"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="nome", type="string", description="Nome da pessoa"),
     *                 @OA\Property(property="cpf", type="string", description="CPF da pessoa"),
     *                 @OA\Property(property="funcao_id", type="integer", description="ID da função"),
     *                 @OA\Property(property="comissao", type="float", description="Comissão da pessoa"),
     *                 @OA\Property(property="telefone", type="string", description="Telefone da pessoa"),
     *                 @OA\Property(property="data_admissao", type="date", description="Data de admissão da pessoa"),
     *                 @OA\Property(property="data_desligamento", type="date", description="Data de desligamento da pessoa"),
     *                 @OA\Property(property="empresa_id", type="integer", description="ID da empresa"),
     *                 @OA\Property(property="name", type="string", description="Nome da pessoa"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="Pessoa editada com sucesso")
     * )
     */
    public function update(Request $request, $id)
    {
        $dados = $request->validate([
            'nome' => 'string|max:255',
            'cpf' => 'string|max:14',
            'funcao_id' => 'integer',
            'comissao' => 'numeric',
            'telefone' => 'nullable|string|max:255',
            'data_admissao' => 'date',
            'name' => 'string|max:50',
            'data_desligamento' => 'nullable|date',
            'empresa_id' => 'integer',
        ]);

        $pessoa = $this->pessoaService->editarPessoa($id, $dados);

        return response()->json($pessoa, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/pessoas/{id}",
     *     tags={"Pessoa"},
     *     summary="Deleta uma pessoa",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da pessoa a ser deletada"
     *     ),
     *     @OA\Response(response="204", description="Pessoa deletada com sucesso")
     * )
     */
    public function destroy($id)
    {
        $this->pessoaService->deletarPessoa($id);

        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/pessoas/{id}",
     *     tags={"Pessoa"},
     *     summary="Retorna detalhes de uma pessoa específica",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da pessoa a ser recuperada"
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function show($id)
    {
        $pessoa = Pessoa::findOrFail($id);

        return response()->json($pessoa, 200);
    }
}
