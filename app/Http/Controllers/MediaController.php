<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $request->hasFile('file');
        $file = $request->file('file');
        $path = $file->store('uploads', 'public');
        $media = Media::create([
            'name' => $file->getClientOriginalName(),
            'file_name' => basename($path),
            'path' => $path,
            'disk' => 'public',
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'user_id' => auth()->id(),
        ]);
        return response()->json(['path' => $path, 'media' => $media]);
    }
}
