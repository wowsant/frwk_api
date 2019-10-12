<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ExceptionApiController;

class CommentController extends Controller
{
    public function __construct(Comment $comment) {
        $this->objeto = $comment;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
                if (Comment::checkPostExist($request->get('cod_post')) > 0) {

                    $this->objeto->body    = $request->get('body');
                    $this->objeto->user_id = auth()->user()->id;
                    $this->objeto->post_id = $request->get('cod_post');

                    $this->objeto->save();

                    return ExceptionApiController::success(
                        '201',
                        array('description' =>  $request->get('body')),
                        'Comentario realizado com sucesso.'
                    );
                } else {
                    return ExceptionApiController::error(
                        '406',
                        'Não exite o post informado.'
                    );
                }
            } else {
                return ExceptionApiController::error(
                    '406',
                    'Não foi defindo o corpo do comentario.'
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
        $data = Comment::getCommentsPost($id);

        if(count($data) > 0) {
            return response()->json($data);
            return ExceptionApiController::success(
                '200',
                array('description' =>  $data),
                'Comentarios vinculados ao post.'
            );
        } else {
            return ExceptionApiController::error(
                '404',
                array('description' => ''),
                'Ops... Não existe comentarios vinculados.'
            );
        }
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
        $data = Comment::where('user_id', auth()->user()->id)
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
            if(!Comment::where('id', $id)->delete()) {

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
