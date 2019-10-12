<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    # Verifica se o album existe e pertence ao usuario
    static function checkAlbumUser($user_id, $album_id) {
        return Photo::where('user_id', $user_id)->where('album_id', $album_id)->count();
    }
}
