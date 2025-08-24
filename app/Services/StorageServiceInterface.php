<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

interface StorageServiceInterface
{
    public function upload(UploadedFile $file, string $prefix = ''): string;
    public function delete(string $url): void;
}
