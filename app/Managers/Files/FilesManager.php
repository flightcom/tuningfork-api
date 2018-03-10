<?php

namespace Managers\Files;

use Models\File;
use JWTAuth;
use Storage;
use Config;

/**
 * This is a general file manager able to store and update any types of files.
 * Configuration to the storage is required depending on whether local or s3
 * storage is used (follow the Laravel documentation).
 *
 * You can define paths for different type of uploads in the configuration
 * 'config/file-storage.php' file
 *
 * Class FilesManager
 * @package Managers\Files
 */
class FilesManager
{
    /*
    |--------------------------------------------------------------------------
    | FilesManager
    |--------------------------------------------------------------------------
    |
    | The FilesManager is simply the business logic between the controller and
    | the model.
    |
    */

    /**
     * @return mixed
     */
    public function query()
    {
        return File::paginate();
    }

    /**
     * The file sent can be a regular file or a base64 file. In the
     * case of a base64 file, the file will be decoded and then stored
     *
     * @param $file
     * @param string $entity the type of file for folder selection
     * @return static
     * @throws \Exception
     */
    public function store($file, string $entity)
    {
        switch ($entity) {
            case 'posts':
                $folder = Config::get('file-storage.post_files_folder');
                break;

            case 'avatars':
                $folder = Config::get('file-storage.avatar_files_folder');
                break;

            default:
                $folder = Config::get('file-storage.misc_files_folder');
                break;
        }

        // Since base64 files are strings, this should be a safe check
        $storeFile = is_string($file) ? base64_decode($file) : $file;

        try {
            // Storage creates a unique filename for us already
            $storedFile = Storage::disk(env('PUBLIC_STORAGE'))->put(
                $folder,
                $storeFile
            );

            return File::create([
                'local_filename'    => $storedFile,
                'local_path'        => Storage::url($storedFile),
                'entity'            => $entity
            ]);
        } catch (\Exception $e) {
            \Log::error('Error storing file');
            throw $e;
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return File::find($id);
    }

    /**
     * The file itself cannot be modified. The file should be deleted
     * if it changed instead. What can be modified is the crop values.
     *
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        $file = File::findOrFail($id);

        $trim = array_filter($data, function($value) { return !empty(trim($value)); });

        $file->fill([
            'width' => $trim['width'],
            'height' => $trim['height'],
            'crop_x' => $trim['crop_x'],
            'crop_y' => $trim['crop_y']
        ]);

        return $file->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return File::destroy($id);
    }
}
