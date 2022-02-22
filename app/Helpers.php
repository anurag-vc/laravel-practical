<?php 

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;

if (!function_exists('includeRouteFiles')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function includeRouteFiles($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $ex) {
            Log::error($ex);
        }
    }
}

if (!function_exists('deleteFile')) {
    /**
     * @param string $destinationPath
     * @param string $oldFileName
     *
     * @return bool
     */
    function deleteFile(string $destinationPath, $oldFileName = ''): bool
    {
        try {
            Storage::disk('public')->delete($destinationPath . $oldFileName); 
        
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return true;
    }
}

if (!function_exists('uploadImage')) {
    /**
     * @param $request
     * @param string $inputName
     * @param string $uploadPath
     * @param string $oldFileName
     *
     * @return array
     */
    function uploadImage($request, string $inputName, string $uploadPath, $oldFileName = ''): array
    {
        try {
            $image = $request->file($inputName);
            $fileName = rand(1, 1000) . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = $uploadPath;
            
            if (!empty($oldFileName)) {
                deleteFile($destinationPath, $oldFileName);
            }
            $resizeImage = Image::make($image->getPathname())->stream();
            Storage::disk('public')->put($destinationPath . '/' . $fileName, $resizeImage);
        
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return [
            'image_name' => $fileName,
            'uploaded_path' => $destinationPath,
        ];
    }
}