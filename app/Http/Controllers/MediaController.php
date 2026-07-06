<?php

namespace App\Http\Controllers;

use App\DTOs\PhotoResponseDTO;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        return response()->json(PhotoResponseDTO::fromEntity($media));
    }
    public function destroy(int$id)
    {
        $media = Media::find($id);
        Storage::disk('public')->delete($media->path);
        $media->delete();
        return response()->json(null, 204);
    }
}
