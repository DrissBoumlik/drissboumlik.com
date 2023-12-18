<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileManagerController extends Controller
{
    public function index(Request $request, $path = 'storage')
    {
        $data = new \stdClass();
        $data->title = 'Media Manager | Admin Panel';

        $data->path = substr($path, strrpos($path, '/') + 1, strlen($path));
        $data->previous_path = null;
        $data->breadcrumb = array_reduce(explode('/', $path), function($acc, $segment) {
            $acc['href'] .= "/$segment";
            $href = $acc['href'];
            $acc['breadcrumb'] .= "<li class='breadcrumb-item capitalize-first-letter'><a href='/admin/media-manager$href'>$segment</a></li>";
            return $acc;
        }, ['href' => '', 'breadcrumb' => '']);
        if (str_contains($path, '/')) {
            $data->previous_path = substr($path, 0, strrpos($path, '/'));
        }
        $dirs = array_map(function ($dir) {
            $path_splitted = explode(DIRECTORY_SEPARATOR, $dir);
            return (object) ['path' => $dir, 'name' => $path_splitted[count($path_splitted) - 1]];
        }, File::directories($path));
        $data->content = [
            'directories' => $dirs,
            'files' => File::files($path),
        ];
        return view('admin.pages.file-manager', ['data' => $data]);
    }

    public function createDirectories(Request $request)
    {
        ['directoriesNames' => $directoriesNames, 'currentPath' => $currentPath] = $request->all();
        if ($directoriesNames && is_array($directoriesNames) && $count = count($directoriesNames)) {
            foreach ($directoriesNames as $directoryName) {
                File::makeDirectory("$currentPath/$directoryName");
            }
            return ['msg' => "Directories created : $count"];
        }
    }

    public function emptyDirectory(Request $request, $path)
    {
        try {
            if (File::cleanDirectory($path)) {
                return ['msg' => 'Trash Emptied successfully'];
            }
            return response()->json(['msg' => 'Issue with the process or Directory not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }
    public function deleteFile(Request $request, $path, $name)
    {
        try {
            File::ensureDirectoryExists('storage/trash/');
            if (File::isDirectory($path)) {
                File::copyDirectory($path, "storage/trash/$name");
                File::deleteDirectory($path);
            } elseif (File::isFile($path)) {
                File::copy($path, "storage/trash/$name");
                File::delete($path);
            }
            return ['msg' => 'Deleted successfully'];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }
}
