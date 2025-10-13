<?php

namespace ErfanMasboogh\Laran\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StorageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'SID' => $this->SID,
            'fileType' => $this->fileType,
            'fileName' => $this->fileName,
            'fileExtension' => $this->fileExtension,
            'fileSize' => $this->fileSize,
        ];
    }

}
