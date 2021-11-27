<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static $dir = '';
    public static $parent;
    public static $file_name;

    /**
     * Upload description
     *
     * @param  string $file
     * @param  string $dir
     * @return object
     **/
    public static function upload($file)
    {
        $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        return Self::putFile($file, $file_name, $extension);
    }

    /**
     * Put a file into local
     * @param  object $encoded
     * @param  string $dir
     * @return String local Path
     */
    public static function putFile($file, string $file_name = null, $extension)
    {
        $file_name = $file_name;
        $rand      = str_random(rand(10,50)).time ();
        $key       = sha1($rand);

        $file_path = date('Y/m/d'). '/' .$key. '/' .str_slug($file_name). '.' .$extension;
        $path = '/public/' . $file_path;
        $encoded = file_get_contents($file);

        Storage::disk('local')->put($path, $encoded, 'public');
        return [
            'size'      => strlen($encoded),
            'mime_type' => $file->getMimeType(),
            'file_name' => $file_name,
            'path'      => $file_path,
        ];
    }

    /**
     * Delete file from local
     * @param  string $path
     * @return Boolean
     */
    public static function delete(string $path)
    {
        if (Storage::exists($path)) {
            return Storage::delete($path);
        }

        return false;
    }

    /**
     * Set Directory
     * @param Self
     */
    public static function setDir(string $dir)
    {
        Self::$dir = $dir;
        return;
    }
}
