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

        $data->previous_path = null;
        if (str_contains($path, '/')) {
            $data->previous_path = substr($path, 0, strrpos($path, '/'));
        }
        $dirs = array_map(function ($dir) {
            return (object) ['path' => $dir, 'name' => explode('\\', $dir)[1]];
        }, File::directories($path));
        $data->content = [
            'directories' => $dirs,
            'files' => File::files($path),
        ];
        return view('admin.pages.file-manager', ['data' => $data]);
    }

    public function deleteFile(Request $request, $path)
    {
        try {
            if (File::isDirectory($path)) {
                File::deleteDirectory($path);
            } elseif (File::isFile($path)) {
                File::delete($path);
            }
            return ['msg' => 'Deleted successfully'];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }
}
