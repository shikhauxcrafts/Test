<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageConversionService
{
    /**
     * Convert uploaded image to WebP format
     *
     * @param UploadedFile $file
     * @param string $path Storage path for the converted image
     * @param int $quality WebP quality (0-100)
     * @return string|null Returns the path to the converted file or null on failure
     */
    public function convertToWebp(UploadedFile $file, string $path = 'images', string $disk = 'public', int $quality = 75)
    {
        try {
            // Get image info
            $imageInfo = getimagesize($file->getPathname());
            if (!$imageInfo) {
                return null;
            }

            // Create image resource based on file type
            $image = match ($imageInfo['mime']) {
                'image/jpeg', 'image/jpg' => imagecreatefromjpeg($file->getPathname()),
                'image/png' => imagecreatefrompng($file->getPathname()),
                'image/gif' => imagecreatefromgif($file->getPathname()),
                default => null
            };

            if (!$image) {
                return null;
            }

            // Handle transparency for PNG images
            if ($imageInfo['mime'] === 'image/png') {
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }

            // Generate unique filename
            $filename = Str::ulid() . '.webp';
            $fullPath = $path . '/' . $filename;

            // Create temporary file for WebP conversion
            $tempFile = tempnam(sys_get_temp_dir(), 'webp');
            imagewebp($image, $tempFile, $quality);

            // Store the converted file
            $isGood = Storage::disk($disk)->put(
                $fullPath,
                file_get_contents($tempFile)
            );
            if($isGood) {
                // Clean up
                unlink($tempFile);
                imagedestroy($image);

                return $fullPath;
            } else {
                throw new \Exception('Failed to store WebP file.');
            }
        } catch (\Exception $e) {
            \Log::error('WebP conversion failed: ' . $e->getMessage());
            throw new \Exception('WebP Conversion Failed.');
        }
    }
}
