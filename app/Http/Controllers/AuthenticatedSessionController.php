<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Http\Controllers\AuthenticatedSessionController as BaseAuthenticatedSessionController;
use App\Models\Pessoa;

class AuthenticatedSessionController extends Controller
{

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Autenticacao"},
     *     summary="Fazer login",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados de login",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="luispalo@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Pessoa::where('email', $request->email)->first();

            $token = $user->createToken('auth-token')->plainTextToken;
    
            return response()->json(['token' => $token], 200);
        }
    
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Autenticacao"},
     *     summary="Fazer logout",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Token de autenticação (Bearer)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function destroy(Request $request)
    {

        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();
            return response()->json(['message' => 'User logged out successfully']);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

    /**
     * Retorna o token de acesso do usuário autenticado.
     *
     * @OA\Get(
     *     path="/api/token",
     *     tags={"Autenticacao"},
     *     summary="Obter token de acesso",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response="200",
     *         description="Token de acesso retornado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", description="Token de acesso"),
     *         )
     *     ),
     *     @OA\Response(response="401", description="Não autorizado")
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getToken(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['access_token' => $token]);
    }
}