<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class FileUploadService
{
    private $disk = 'private';
    private $expirationMinutes = 60;

    public function generateSignedUrl($path): string
    {
        return URL::temporarySignedRoute(
            'documents.download',
            now()->addMinutes($this->expirationMinutes),
            ['path' => $path]
        );
    }

    public function storeFile($file, $caseId, $filename): string
    {
        $path = "documents/{$caseId}/" . uniqid() . '_' . $filename;
        
        Storage::disk($this->disk)->put(
            $path,
            file_get_contents($file),
            'private'
        );

        return $path;
    }

    public function getSignedDownloadUrl($documentId): string
    {
        $document = \App\Models\Documents::find($documentId);
        
        if (!$document) {
            throw new \Exception('Document not found');
        }

        return Storage::disk($this->disk)->temporaryUrl(
            $document->file_path,
            now()->addMinutes($this->expirationMinutes)
        );
    }

    public function deleteFile($filePath): bool
    {
        return Storage::disk($this->disk)->delete($filePath);
    }

    public function isValidSignature($path, $signature): bool
    {
        $computed = hash_hmac('sha256', $path, config('app.key'));
        return hash_equals($computed, $signature);
    }
}
