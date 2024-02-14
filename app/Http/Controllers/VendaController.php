<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Services\VendaService;

class VendaController extends Controller
{
    protected $vendaService;

    public function __construct(VendaService $vendaService)
    {
        $this->vendaService = $vendaService;
    }

    /**
     * @OA\Get(
     *     path="/api/vendas",
     *     tags={"Venda"},
     *     summary="Retorna vendas",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function index()
    {
        $vendas = $this->vendaService->listarVendas();

        return $vendas;
    }

    /**
     * @OA\Post(
     *     path="/api/vendas",
     *     tags={"Venda"},
     *     summary="Adiciona uma nova venda",
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="valor", type="float", description="Valor da venda"),
     *                 @OA\Property(property="forma_pagamento_id", type="integer", description="ID da forma de pagamento"),
     *                 @OA\Property(property="situacao_pagamento", type="integer", description="Situação de pagamento"),
     *                 @OA\Property(property="data_registro", type="date", description="Data de registro da venda"),
     *                 @OA\Property(property="pessoa_id", type="integer", description="ID da pessoa relacionada à venda"),
     *                 @OA\Property(property="empresa_id", type="integer", description="ID da empresa relacionada à venda"),
     *                 @OA\Property(property="desconto", type="integer", description="Desconto aplicado à venda"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response="201", description="Venda adicionada com sucesso")
     * )
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'valor' => 'required|numeric',
            'forma_pagamento_id' => 'required|integer',
            'situacao_pagamento' => 'required|integer',
            'data_registro' => 'required|date',
            'pessoa_id' => 'required|integer',
            'empresa_id' => 'required|integer',
            'desconto' => 'nullable|integer',
        ]);

        $venda = $this->vendaService->adicionarVenda($dados);

        return response()->json($venda, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/vendas/{id}",
     *     tags={"Venda"},
     *     summary="Edita uma venda existente",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da venda a ser editada"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="valor", type="float", description="Valor da venda"),
     *                 @OA\Property(property="forma_pagamento_id", type="integer", description="ID da forma de pagamento"),
     *                 @OA\Property(property="situacao_pagamento", type="integer", description="Situação de pagamento"),
     *                 @OA\Property(property="data_registro", type="date", description="Data de registro da venda"),
     *                 @OA\Property(property="pessoa_id", type="integer", description="ID da pessoa relacionada à venda"),
     *                 @OA\Property(property="empresa_id", type="integer", description="ID da empresa relacionada à venda"),
     *                 @OA\Property(property="desconto", type="integer", description="Desconto aplicado à venda"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="Venda editada com sucesso")
     * )
     */
    public function update(Request $request, $id)
    {
        $dados = $request->validate([
            'valor' => 'numeric',
            'forma_pagamento_id' => 'integer',
            'situacao_pagamento' => 'integer',
            'data_registro' => 'date',
            'pessoa_id' => 'integer',
            'empresa_id' => 'integer',
            'desconto' => 'integer',
        ]);

        $venda = $this->vendaService->editarVenda($id, $dados);

        return response()->json($venda, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/vendas/{id}",
     *     tags={"Venda"},
     *     summary="Deleta uma venda",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da venda a ser deletada"
     *     ),
     *     @OA\Response(response="204", description="Venda deletada com sucesso")
     * )
     */
    public function destroy($id)
    {
        $this->vendaService->deletarVenda($id);

        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/vendas/{id}",
     *     tags={"Venda"},
     *     summary="Retorna detalhes de uma venda específica",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da venda a ser recuperada"
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function show($id)
    {
        $venda = $this->vendaService->obterDetalhesVenda($id);

        return response()->json($venda, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/vendas/porPessoa/{idPessoa}",
     *     tags={"Venda"},
     *     summary="Retorna detalhes de uma venda específica por pessoa",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="idPessoa",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da Pessoa que tem venda"
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function listarVendasPorPessoa($idPessoa)
    {
        $venda = $this->vendaService->listarVendasPorPessoa($idPessoa);

        return response()->json($venda, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/vendas/porEmpresa/{idEmpresa}",
     *     tags={"Venda"},
     *     summary="Retorna detalhes de uma venda específica por Empresa",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="idEmpresa",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da Empresa que tem venda"
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function listarVendasPorEmpresa($idEmpresa)
    {
        $venda = $this->vendaService->listarVendasPorEmpresa($idEmpresa);

        return response()->json($venda, 200);
    }
}
