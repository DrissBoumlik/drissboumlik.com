<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function export_db(Request $request)
    {
        $tables = $request->get('tables');
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
        if ($tables) {
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

    public function getTableColumns(Request $request, $table)
    {
        return \DB::getSchemaBuilder()->getColumnListing($table);
    }

    public function getTableColumnStats(Request $request)
    {
        $table = $request->get('table');
        $column = $request->get('column');
        $year = $request->get('year');
        if ($year) {
            return \DB::table($table)
                ->select($column, \DB::raw("month(updated_at) as month"), \DB::raw("count($column) as visits"))
                ->whereYear('updated_at', $year)
                ->orderby('visits', 'desc')
                ->groupBy($column, 'month')->paginate(20);
        }

        return \DB::table($table)
            ->select($column, \DB::raw("count($column) as visits"))
            ->orderby('visits', 'desc')
            ->groupBy($column)->paginate(10);
    }
}
