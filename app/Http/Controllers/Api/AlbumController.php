<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Album;
use App\Http\Controllers\Api\ExceptionApiController;

class AlbumController extends Controller
{
    public function __construct(Album $album) {
        $this->objeto = $album;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Album::getAlbums($request->get('number_per_page'));
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
            if (!empty($request->get('name'))) {
                if (Album::checkDuplicityUser(auth()->user()->id, $request->get('name')) > 0) {
                    return ExceptionApiController::error(
                        '406',
                        array('description' =>  $request->get('name')),
                        'Ops... Album já cafastrado.'
                    );
                } else {

                    $this->objeto->name    = $request->get('name');
                    $this->objeto->user_id = auth()->user()->id;
                    $this->objeto->save();

                    return ExceptionApiController::success(
                        '201',
                        array('description' =>  $request->get('name')),
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
        $data = Album::getPhotoAlbum($id);

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
                'Ops... Não existe fotos para exibit.'
            );
        }    }

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
        $data = Album::where('user_id', auth()->user()->id)
            ->where('id', $id)
        ->update(['name' => $request->get('name')]);

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
                    array('description' =>  $request->get('name')),
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
        //
    }
}
