<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileManagerController extends Controller
{

    const TRASH = 'storage/trash';

    public function index(Request $request)
    {
        $data = adminPageSetup('File Manager | Admin Panel');
        return view('admin.pages.file-manager', ['data' => $data]);
    }

    public function getFiles(Request $request, $path = 'storage')
    {
        $data = new \stdClass();
        $data->path = substr($path, strrpos($path, '/') + 1, strlen($path));
        $data->previous_path = null;
        $data->current_path = $path;
        $data->breadcrumb = array_reduce(explode('/', $path), function($acc, $segment) {
            $acc['href'] .= "$segment/";
            $href = $acc['href'];
            $acc['breadcrumb'] .= "<li class='breadcrumb-item capitalize-first-letter'><a href='#' class='file-link' data-href='$href'>$segment</a></li>";
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

    public function renameFile(Request $request)
    {
        try {
            $old_name = trim($request->get('old_name'));
            $new_name = trim($request->get('new_name'));
            if (!$new_name || !$old_name) {
                throw new \Exception("Names should not be empty!!");
            }
            if (strtolower($old_name) === 'trash') {
                throw new \Exception("You cannot rename the Trash !");
            }
            $path = trim($request->get('path'));
            File::move("$path/$old_name", "$path/$new_name");
            return ['message' => 'Renamed successfully !'];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function copyFile(Request $request)
    {
        try {
            $src_path = $request->get('src-path');
            if ($src_path === self::TRASH) {
                throw new \Exception("You cannot copy/move the Trash !");
            }
            $operation = $request->get('operation');
            $file_name = $request->get('file_name');
            $dest_path = $request->get('dest-path');
            $dest_path = $dest_path ? "storage/$dest_path" : "storage";
            $msg = 'Not file or directory !!';
            File::ensureDirectoryExists($dest_path);
            $dest_path = "$dest_path/$file_name";
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
            return ['message' => $msg];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function createDirectories(Request $request)
    {
        try {
            ['directoriesNames' => $directoriesNames, 'currentPath' => $currentPath] = $request->all();
            if (!$currentPath) {
                $currentPath = "storage";
            }
            $count = count($directoriesNames);
            if ($directoriesNames && is_array($directoriesNames) && $count) {
                foreach ($directoriesNames as $directoryName) {
                    File::makeDirectory("$currentPath/$directoryName");
                }
            }
            return [
                'message' => "Directories created : $count",
                'class' => 'alert-info',
                'icon' => '<i class="fa fa-fw fa-circle-check"></i>'
            ];
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'class' => 'alert-danger',
                'icon' => '<i class="fa fa-fw fa-times-circle"></i>'
            ], 404);
        }
    }


    public function uploadFile(Request $request)
    {
        try {
            $path = $request->get('path');
            if ($path === self::TRASH) {
                throw new \Exception("You're uploading to the Trash !");
            }
            $files = $request->file('files');
            $path = str_replace('storage', '', $path);
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $file->storeAs($path, $filename, 'public');
            }
            return ['message' => 'Uploaded successfully'];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
    public function emptyDirectory(Request $request, $path)
    {
        try {
            if (File::cleanDirectory($path)) {
                return ['message' => 'Trash Emptied successfully'];
            }
            return response()->json(['message' => 'Issue with the process or Directory not found'], 404);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
    public function deleteFile(Request $request, $path, $name)
    {
        try {
            if (self::TRASH === $path) {
                throw new \Exception("You can't delete the Trash !");
            }
            File::ensureDirectoryExists(self::TRASH . "/");
            if (File::isDirectory($path)) {
                File::copyDirectory($path, self::TRASH . "/$name");
                File::deleteDirectory($path);
                $msg = 'Directory deleted successfully';
            } elseif (File::isFile($path)) {
                File::copy($path, self::TRASH . "/$name");
                File::delete($path);
                $msg = 'File deleted successfully';
            }
            return ['message' => $msg];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
