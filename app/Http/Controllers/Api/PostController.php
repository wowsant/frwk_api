<?php

namespace App\Http\Controllers\Api;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ExceptionApiController;

class PostController extends Controller
{
    public function __construct(Post $post) {
        $this->objeto = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('class') == 'me') {
            # Retorna as publicações do usuario logado
            $data = Post::getPostUser($request->get('number_per_page'));
        } else {
            # Retorna todos as publicações
            $data = Post::getAllPostUser(auth()->user()->id, $request->get('number_per_page'));
        }
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if (!empty($request->get('body'))) {
                if (Post::checkDuplicityUser(auth()->user()->id, $request->get('body')) > 0) {
                    return ExceptionApiController::error(
                        '406',
                        array('description' =>  $request->get('body')),
                        'Ops... você já realizou está postagem.'
                    );
                } else {

                    $this->objeto->body    = $request->get('body');
                    $this->objeto->user_id = auth()->user()->id;
                    $this->objeto->save();

                    return ExceptionApiController::success(
                        '201',
                        array('description' =>  $request->get('body')),
                        'Postagem realizada com sucesso.'
                    );
                }
            } else {
                return ExceptionApiController::error(
                    '406',
                    'Não foi defindo o corpo da postgem.'
                );
            }
        } catch (\Exeption $e) {
            return response()->json(['msg' => 'Ops... Erro ao gravar informação'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Post::where('user_id', auth()->user()->id)
            ->where('id', $id)
        ->update(['body' => $request->get('body')]);

        try {
            if(!$data) {

                return ExceptionApiController::error(
                    '500',
                    array('description' =>  $id),
                    'Edição não realizada.'
                );
            } else {

                return ExceptionApiController::success(
                    '200',
                    array('description' =>  $request->get('body')),
                    'Edição realizada com sucesso.'
                );
            }
        } catch (\Exeption $e) {
            return response()->json(['msg' => 'Ops... Erro ao editar informação'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if(!Post::where('id', $id)->delete()) {

                return ExceptionApiController::error(
                    '500',
                    array('description' =>  $id),
                    'Ops... não foi prossivel realizar exclusão.'
                );
            } else {

                return ExceptionApiController::success(
                    '200',
                    array('description' =>  $id),
                    'Exclusão realizada com sucesso.'
                );
            }
        } catch (\Exeption $e) {
            return response()->json(['msg' => 'Ops... Erro ao gravar informação'], 500);
        }
    }
}