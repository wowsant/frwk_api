<?php

namespace App\Http\Controllers\Api;

use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\ExceptionApiController;


class PhotoController extends Controller
{
    public function __construct(Photo $photo) {
        $this->objeto = $photo;
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
            if(Photo::checkAlbumUser(auth()->user()->id, $request->get('cod_album')) > 0) {

                if ($request->hasFile('image') && $request->file('image')->isValid()) {

                    # O nome do arquivo que será gravado na storage, utilizando hash para nome unico
                    $name_storage = Hash::make($request->file('image')->getClientOriginalName()) . '.' . $request->file('image')->getClientOriginalExtension();

                    if ($request->file('image')->storeAs('images', $name_storage)) {

                        $this->objeto->album_id            = $request->get('cod_album');
                        $this->objeto->name                = $request->get('name_image');
                        $this->objeto->label               = $request->get('description');
                        $this->objeto->name_image_storage  = $name_storage;
                        $this->objeto->mime_type           = $request->file('image')->getMimeType();
                        $this->objeto->name_original       = $request->file('image')->getClientOriginalName();
                        $this->objeto->user_id             = auth()->user()->id;
                        $this->objeto->save();

                        return ExceptionApiController::success(
                            '201',
                            array('description' =>  $request->get('name_image')),
                            'Postagem realizada com sucesso.'
                        );
                    }
                    return ExceptionApiController::error(
                        '500',
                        array('description' =>  'Não foi posivel realizar processo.'),
                        'Não foi posivel realizar processo..'
                    );
                } else {
                    return ExceptionApiController::error(
                        '404',
                        array('description' => 'Imagem não enviada'),
                        'Ops... Imagem não enviada.'
                    );
                }
            } else {
                return ExceptionApiController::error(
                    '401',
                    array('description' =>  'Album não existe ou não pertence ao usuario.'),
                    'Não foi posivel realizar processo..'
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
        //
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
            if(!Photo::where('id', $id)->delete()) {

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
