<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function export_db(Request $request)
    {
        $dumpPath = database_path('dumps/dump.sql');
        \Spatie\DbDumper\Databases\MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile($dumpPath);

        return \Response::download($dumpPath, "dump.sql", [
            'Content-Type' => 'application/sql',
            // 'Content-Transfer-Encoding'=> 'binary',
            // 'Accept-Ranges'=> 'bytes'
        ]);
    }
}
