<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{
    /**
     * Pegar todos os registros
     */
    public function getAll()
    {
        $usuario = User::orderBy('nome_usuario', 'ASC')->get();
        $message = $usuario->count() > 0 ? 'Listagem de Usuários obtida com sucesso!' : 'Nenhum Usuário cadastrado.';

        return $this->sendSuccess(UserResource::collection($usuario), $message);
    }

    /**
     * Gravar novo registro
     */
    public function newUsuario(Request $request)
    {
        $regras = [
            'nome_completo'     => 'required',
            'email_usuario'     => 'required|unique:usuario',
            'senha_usuario'     => 'required',
        ];
        $mensagens = [
            'nome_completo.required'    => 'O campo Nome é obrigatório!',
            'email_usuario.required'    => 'O campo E-mail é obrigatório!',
            'email_usuario.unique'      => 'O E-mail informado já está em uso!',
            'senha_usuario.required'    => 'O campo Senha é obrigatório!',
        ];

        $validator = Validator::make($request->all(), $regras, $mensagens);
        if($validator->fails()){
            $returnValidator = [];
            $arValidator = json_decode($validator->errors()->toJson());
            foreach($arValidator as $k_valid => $v_valid ){
                $returnValidator[] = [
                    'campo'     => $k_valid,
                    'mensagem'  => $v_valid[0],
                ];
            }
            return $this->sendError('Preenchimento inválido dos campos', $returnValidator, 400);
        }

        $input                  = $request->all();
        $input['nome_usuario']  = gerar_codigo('usuario');
        $input['senha_usuario'] = Hash::make($request->senha_usuario);
        $usuario                = User::create($input);

        return $this->sendSuccess(new UserResource($usuario), 'Usuário cadastrado com sucesso!');
    }

    /**
     * Pegar registro especifico
     */
    public function getUsuario(Request $request)
    {
        $usuario = User::find($request->id);

        if(is_null($usuario)){
            return $this->sendError('404', 'Registro não encontrado', 404);
        }

        return $this->sendSuccess(new UserResource($usuario), 'Informações do Usuário obtidas com sucesso!');
    }

    /**
     * Atualizar registro
     */
    public function updateUsuario(Request $request)
    {
        $regras = [
            'nome_completo'     => 'required',
            'email_usuario'     => [
                'required',
                Rule::unique('usuario')->where(function ($query) use ($request) {
                    return $query
                        ->whereEmailUsuario($request->email_usuario)
                        ->whereNotIn('id', [$request->id]);
                }),
            ],
        ];
        $mensagens = [
            'nome_completo.required'     => 'O campo Nome é obrigatório!',
            'email_usuario.required'     => 'O campo E-mail é obrigatório!',
            'email_usuario.unique'       => 'O E-mail informado já está em uso!',
        ];

        $validator = Validator::make($request->all(), $regras, $mensagens);
        if($validator->fails()){
            $returnValidator = [];
            $arValidator = json_decode($validator->errors()->toJson());
            foreach($arValidator as $k_valid => $v_valid ){
                $returnValidator[] = [
                    'campo'     => $k_valid,
                    'mensagem'  => $v_valid[0],
                ];
            }
            return $this->sendError('Preenchimento inválido dos campos', $returnValidator, 400);
        }

        $usuario = User::find($request->id);
        if(is_null($usuario)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $input = $request->all();
            $usuario->nome_completo    = $input['nome_completo'];
            $usuario->email_usuario    = $input['email_usuario'];
            $usuario->save();

            return $this->sendSuccess(new UserResource($usuario), 'Informações do Usuário atualizadas com sucesso!');
        }
    }

    /**
     * Excluir registro
     */
    public function deleteUsuario(Request $request)
    {
        if(!$request->id){
            return $this->sendError('400', 'Informações insuficientes para esta ação.', 400);
        }

        $usuario = User::find($request->id);
        if(is_null($usuario)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $usuario->delete();
            return $this->sendSuccess([], 'Registro do Usuário excluído com sucesso!');
        }
    }

    /**
     * Pegar infos do Usuário
     */
    public function getUsuarioCompleto(Request $request)
    {
        $usuario = User::find($request->id);
        if(is_null($usuario)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $modalID      = "mVerUsuario";
            $modalHeader  = "Informações do Usuário";

            $returnHTML = view('components.modalUsuarioCompleto')->with('modalInfo', [$modalID, $modalHeader, $usuario])->render();
            return response()->json(array('success' => true, 'html' => $returnHTML), 200);
        }
    }

    /**
     * Alterar senha do Usuário
     */
    public function updateUsuarioPassword(Request $request)
    {
        $regras = [
            'senha_usuario'  => 'required',
        ];
        $mensagens = [
            'senha_usuario.required'  => 'O campo Senha é obrigatório!',
        ];

        $validator = Validator::make($request->all(), $regras, $mensagens);
        if($validator->fails()){
            $returnValidator = [];
            $arValidator = json_decode($validator->errors()->toJson());
            foreach($arValidator as $k_valid => $v_valid ){
                $returnValidator[] = [
                    'campo'     => $k_valid,
                    'mensagem'  => $v_valid[0],
                ];
            }
            return $this->sendError('Preenchimento inválido dos campos', $returnValidator, 400);
        }

        $usuario = User::find($request->id);
        if(is_null($usuario)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $input = $request->all();
            $usuario->senha_usuario = Hash::make($request->senha_usuario);
            $usuario->save();

            return $this->sendSuccess(new UserResource($usuario), 'Senha do Usuário atualizada com sucesso!');
        }
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $regras = [
            'email_usuario' => 'required|email:rfc,dns',
            'senha_usuario' => 'required',
        ];
        $mensagens = [
            'email_usuario.required' => 'O campo E-mail é obrigatório!',
            'email_usuario.email'    => 'O e-mail informado não é válido!',
            'senha_usuario.required' => 'O campo Senha é obrigatório!',
        ];

        $validator = Validator::make($request->all(), $regras, $mensagens);

        if($validator->fails()){
            $returnValidator = [];
            $arValidator = json_decode($validator->errors()->toJson());
            foreach($arValidator as $k_valid => $v_valid ){
                $returnValidator[] = [
                    'campo'     => $k_valid,
                    'mensagem'  => $v_valid[0],
                ];
            }
            return response()->json(['Preenchimento inválido', 'data' => $returnValidator], 400);
        }

        # Valida se o usuário existe
        $checkUser = User::where("email_usuario", $request->email_usuario)->first();
        if(is_null($checkUser)){
            return response()->json(['failed', 'data' => 'Usuário e/ou Senha incorreto.'], 401);
        }
        else{
            # Valida email e senha
            if(Auth::attempt(['email_usuario' => $request->email_usuario, 'password' => $request->senha_usuario])){
                $user = Auth::user();
                return response()->json(route('painel'), 200);
            }
            else{
                return response()->json(['failed', 'data' => 'Usuário e/ou Senha incorreto'], 401);
            } 
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        session()->flush();
        auth()->guard('web')->logout();
        return redirect()->route('index');
    }
}
