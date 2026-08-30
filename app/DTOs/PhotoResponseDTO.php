<?php

namespace App\DTOs;

use App\Models\Media;

class PhotoResponseDTO
{
    public function __construct(
        public string $id,        
        public string $mimeType,
        public string $size,
        public string $name,
        public string $fileName,
        public string $path,
        public string $disk,        
    ) {}
    public static function fromEntity(Media $media): self
    {
        return new self(
            id: $media->id,            
            mimeType: $media->mime_type,
            size: $media->size,
            name: $media->name,
            fileName: $media->file_name,
            path: asset('storage/' . $media->path),
            disk: $media->disk
        );
    }
}