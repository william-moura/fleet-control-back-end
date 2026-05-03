<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = ['name', 'file_name', 'path', 'disk', 'mime_type', 'size', 'user_id'];

    public function mediable(): MorphTo
    {
        // Esse método permite acessar $media->mediable e obter o Produto ou Veículo dono do arquivo
        return $this->morphTo();
    }
}
