<?php

namespace App\Services\Academic;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * All personal files (photos, ID, proof of address ...) are stored on the PRIVATE "local" disk
 * (storage/app/private) and are only ever served through authenticated admin routes.
 */
class SecureFileStore
{
    private const DISK = 'local';

    /** @return array{path:string, original_name:string, mime_type:string, size:int} */
    public function store(UploadedFile $file, string $directory): array
    {
        // random file name – never trust the client's file name on disk
        $name = Str::uuid() . '.' . strtolower($file->guessExtension() ?: $file->getClientOriginalExtension());
        $path = $file->storeAs($directory, $name, self::DISK);

        return [
            'path'          => $path,
            'original_name' => Str::limit(basename($file->getClientOriginalName()), 200, ''),
            'mime_type'     => $file->getMimeType() ?: 'application/octet-stream',
            'size'          => $file->getSize(),
        ];
    }

    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk(self::DISK)->delete($path);
        }
    }

    public function exists(?string $path): bool
    {
        return $path && Storage::disk(self::DISK)->exists($path);
    }

    /** inline = show in browser (images / pdf), otherwise force download */
    public function respond(string $path, ?string $downloadName = null, bool $inline = false): StreamedResponse
    {
        abort_unless($this->exists($path), 404);

        $disk = Storage::disk(self::DISK);
        $headers = [
            'Cache-Control'          => 'private, max-age=3600',
            'X-Content-Type-Options' => 'nosniff',
        ];

        return $inline
            ? $disk->response($path, $downloadName, $headers)
            : $disk->download($path, $downloadName, $headers);
    }
}
