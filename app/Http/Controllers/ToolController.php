<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function getPixel(Request $request)
    {
        return redirect('/assets/img/mixte/pixel.png');
    }

    public function export_db(Request $request)
    {
        $tables = $request->get('tables');
        $dontCreateTables = $request->has('dontCreateTables');
        $now = date("Y-m-d_h-i");
        $db_name = env('DB_DATABASE');
        $filename = $db_name . "_exported_at_$now.sql";
        $dumpPath = database_path("dumps/$filename");
        $dumpDB = \Spatie\DbDumper\Databases\MySql::create();
        if (env('APP_ENV') === 'local') {
            $dumpDB = $dumpDB->setDumpBinaryPath('C:\xampp-8.1\mysql\bin');
        }
        $dumpDB = $dumpDB
            ->setDbName($db_name)
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'));
        if ($dontCreateTables) {
            $dumpDB = $dumpDB->doNotCreateTables();
        }
        if ($tables) {
            $tables = explode(' ', $request->get('tables'));
            $dumpDB = $dumpDB->includeTables($tables);
        }
        $dumpDB->dumpToFile($dumpPath);

        return \Response::download($dumpPath, $filename, [
            'Content-Type' => 'application/sql',
            // 'Content-Transfer-Encoding'=> 'binary',
            // 'Accept-Ranges'=> 'bytes'
        ]);
    }

    public function exportDbConfig(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Export DB | Admin Panel';
        $data->tables = collect(\DB::getSchemaBuilder()->getTables())->map(function ($table) {
            $table['count'] = \DB::table($table['name'])->count();
            return (object) $table;
        });
        return view('admin.pages.export-db-config', ['data' => $data]);
    }

}
