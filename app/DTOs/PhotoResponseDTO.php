<?php

namespace App\DTOs;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;

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
        $tenantId = tenancy()->tenant->id;
        $urlPhoto = asset('storage/tenant' . $tenantId . '/app/public/' . $media->path);       
        return new self(
            id: $media->id,            
            mimeType: $media->mime_type,
            size: $media->size,
            name: $media->name,
            fileName: $media->file_name,
            path: 'https://sysmanager.tech/storage/tenant' . $tenantId . '/app/public/' . $media->path,
            disk: $media->disk
        );
    }
}