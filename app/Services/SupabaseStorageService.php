<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class SupabaseStorageService implements StorageServiceInterface
{
    protected string $url;
    protected string $key;
    protected string $bucket;

    public function __construct()
    {
        $this->url    = config('services.supabase.url');
        $this->key    = config('services.supabase.key');
        $this->bucket = config('services.supabase.bucket');
    }

    public function upload(UploadedFile $file, string $prefix = ''): string
    {
        $fileName = $prefix . uniqid() . '.' . $file->getClientOriginalExtension();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->key,
            'apikey'        => $this->key,
            'Content-Type'  => $file->getMimeType(),
        ])->send('PUT', "{$this->url}/storage/v1/object/{$this->bucket}/{$fileName}", [
            'body' => file_get_contents($file->getRealPath())
        ]);

        if ($response->failed()) {
            throw new \Exception("Gagal upload file ke storage.");
        }

        return "{$this->url}/storage/v1/object/public/{$this->bucket}/$fileName";
    }

    public function delete(string $fileUrl): void
    {
        if (!$fileUrl) return;

        // Ambil path relatif dari URL Supabase
        $parsed = parse_url($fileUrl, PHP_URL_PATH);
        $relativePath = ltrim(str_replace('/storage/v1/object/public/', '', $parsed), '/');

        Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->key,
            'apikey'        => $this->key,
        ])->delete("{$this->url}/storage/v1/object/{$relativePath}");
    }
}
