<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Services\EmpresaService;

class EmpresaController extends Controller
{

    protected $empresaService;

    public function __construct(EmpresaService $empresaService)
    {
        $this->empresaService = $empresaService;
    }

    /**
     * @OA\Get(
     *     path="/api/empresas",
     *     tags={"Empresa"},
     *     summary="Retorna empresa",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function index()
    {
        $empresas = Empresa::with('pessoas', 'pessoas.vendas')->get();

        return $empresas;
    }

    /**
     * @OA\Post(
     *     path="/api/empresas",
     *     tags={"Empresa"},
     *     summary="Adiciona uma nova empresa",
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="nome", type="string", description="Nome da empresa"),
     *                 @OA\Property(property="cnpj_cpf", type="string", description="CNPJ da empresa"),
     *                 @OA\Property(property="cor_tema", type="string", description="Cor do tema da empresa"),
     *                 @OA\Property(property="data_cadastro", type="date", description="Data de cadastro da empresa"),
     *                 @OA\Property(property="data_encerramento", type="date", description="Data de encerramento da empresa"),
     *                 @OA\Property(property="situacao_empresa", type="integer", description="Situação da empresa"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response="201", description="Empresa adicionada com sucesso")
     * )
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj_cpf' => 'required|string|max:14',
            'cor_tema' => 'nullable|string|max:255',
            'data_cadastro' => 'required|date',
            'data_encerramento' => 'nullable|date',
            'situacao_empresa' => 'nullable|integer|max:255',
        ]);

        $empresa = $this->empresaService->adicionarEmpresa($dados);

        return response()->json($empresa, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/empresas/{id}",
     *     tags={"Empresa"},
     *     summary="Edita uma empresa existente",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da empresa a ser editada"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="nome", type="string", description="Nome da empresa"),
     *                 @OA\Property(property="cnpj_cpf", type="string", description="CNPJ da empresa"),
     *                 @OA\Property(property="cor_tema", type="string", description="Cor do tema da empresa"),
     *                 @OA\Property(property="data_cadastro", type="date", description="Data de cadastro da empresa"),
     *                 @OA\Property(property="data_encerramento", type="date", description="Data de encerramento da empresa"),
     *                 @OA\Property(property="situacao_empresa", type="integer", description="Situação da empresa"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="Empresa editada com sucesso")
     * )
     */
    public function update(Request $request, $id)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj_cpf' => 'required|string|max:14',
            'cor_tema' => 'nullable|string|max:255',
            'data_cadastro' => 'required|date',
            'data_encerramento' => 'nullable|date',
            'situacao_empresa' => 'nullable|integer|max:255',
        ]);

        $empresa = $this->empresaService->editarEmpresa($id, $dados);

        return response()->json($empresa, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/empresas/{id}",
     *     tags={"Empresa"},
     *     summary="Deleta uma empresa",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da empresa a ser deletada"
     *     ),
     *     @OA\Response(response="204", description="Empresa deletada com sucesso")
     * )
     */
    public function destroy($id)
    {
        $this->empresaService->deletarEmpresa($id);

        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/empresas/{id}",
     *     tags={"Empresa"},
     *     summary="Retorna detalhes de uma empresa específica",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da empresa a ser recuperada"
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function show($id)
    {
        // Lógica para exibir detalhes de uma empresa específica
        $empresa = Empresa::findOrFail($id);

        return response()->json($empresa, 200);
    }

}
