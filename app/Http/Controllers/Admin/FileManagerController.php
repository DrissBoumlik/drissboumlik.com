<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileManagerController extends Controller
{
    public function index(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Media Manager | Admin Panel';
        return view('admin.pages.file-manager', ['data' => $data]);
    }

    public function getMedias(Request $request, $path = 'storage')
    {
        $data = new \stdClass();
        $data->path = substr($path, strrpos($path, '/') + 1, strlen($path));
        $data->previous_path = null;
        $data->current_path = $path;
        $data->breadcrumb = array_reduce(explode('/', $path), function($acc, $segment) {
            $acc['href'] .= "$segment/";
            $href = $acc['href'];
            $acc['breadcrumb'] .= "<li class='breadcrumb-item capitalize-first-letter'><a href='#' class='media-link' data-href='$href'>$segment</a></li>";
            return $acc;
        }, ['href' => '', 'breadcrumb' => '']);
        if (str_contains($path, '/')) {
            $data->previous_path = substr($path, 0, strrpos($path, '/'));
        }
        $dirs = array_map(function ($dir) {
            $path_splitted = explode(DIRECTORY_SEPARATOR, $dir);
            return (object) ['path' => $dir, 'name' => $path_splitted[count($path_splitted) - 1]];
        }, File::directories($path));
        $files = array_map(function($file) {
            $file->_pathname = $file->getPathname();
            $file->_filename = $file->getFilename();
            $file->_mimeType = File::mimeType($file);
            return $file;
        }, File::files($path));
        $data->content = [
            'directories' => $dirs,
            'files' => $files,
        ];
        return ['data' => $data];
    }

    public function copyMedia(Request $request)
    {

        try {
            $operation = $request->get('operation');
            $media_name = $request->get('media_name');
            $src_path = $request->get('src-path');
            $dest_path = $request->get('dest-path');
            $dest_path = $dest_path ? "storage/$dest_path" : "storage";
            $msg = 'Not file or directory !!';
            File::ensureDirectoryExists($dest_path);
            $dest_path = "$dest_path/$media_name";
            if ($src_path === $dest_path) {
                throw new \Exception("You copy/move to the same path !");
            }
            if (File::isDirectory($src_path)) {
                File::copyDirectory($src_path, $dest_path);
                $msg = 'Directory copied';
                if ($operation === 'move') {
                    File::deleteDirectory($src_path);
                    $msg = 'Directory moved';
                }
                $msg .= ' successfully';
            } elseif (File::isFile($src_path)) {
                File::copy($src_path, $dest_path);
                $msg = 'File copied';
                if ($operation === 'move') {
                    File::delete($src_path);
                    $msg = 'File moved';
                }
                $msg .= ' successfully';
            }
            return ['msg' => $msg];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }

    public function createDirectories(Request $request)
    {
        try {
            ['directoriesNames' => $directoriesNames, 'currentPath' => $currentPath] = $request->all();
            if (!$currentPath) {
                $currentPath = "storage";
            }
            if ($directoriesNames && is_array($directoriesNames) && $count = count($directoriesNames)) {
                foreach ($directoriesNames as $directoryName) {
                    File::makeDirectory("$currentPath/$directoryName");
                }
                return ['msg' => "Directories created : $count"];
            }
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }


    public function uploadMedia(Request $request)
    {
        try {
            $path = $request->get('path');
            if ($path === 'storage/trash') {
                throw new \Exception("You're uploading to the Trash <i class='fa-solid fa-trash'></i>");
            }
            $files = $request->file('files');
            $path = str_replace('storage/', '', $path);
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $file->storeAs($path, $filename, 'public');
            }
            return ['msg' => 'Uploaded successfully'];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }
    public function emptyDirectory(Request $request, $path)
    {
        try {
            if (File::cleanDirectory($path)) {
                return ['msg' => 'Trash Emptied successfully'];
            }
            return response()->json(['msg' => 'Issue with the process or Directory not found'], 404);
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }
    public function deleteFile(Request $request, $path, $name)
    {
        try {
            $trash = 'storage/trash';
            if ($trash === $path) {
                throw new \Exception("You can't delete the trash");
            }
            File::ensureDirectoryExists("$trash/");
            if (File::isDirectory($path)) {
                File::copyDirectory($path, "$trash/$name");
                File::deleteDirectory($path);
                $msg = 'Directory deleted successfully';
            } elseif (File::isFile($path)) {
                File::copy($path, "$trash/$name");
                File::delete($path);
                $msg = 'File deleted successfully';
            }
            return ['msg' => $msg];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }
}
