<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function export_db(Request $request)
    {
        $now = date("Y-m-d_h-i");
        $db_name = env('DB_DATABASE');
        $filename = $db_name . "_exported_at_$now.sql";
        $dumpPath = database_path("dumps/$filename");
        \Spatie\DbDumper\Databases\MySql::create()
            ->setDbName($db_name)
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile($dumpPath);

        return \Response::download($dumpPath, $filename, [
            'Content-Type' => 'application/sql',
            // 'Content-Transfer-Encoding'=> 'binary',
            // 'Accept-Ranges'=> 'bytes'
        ]);
    }

    public function getTableColumns(Request $request, $table)
    {
        return \DB::getSchemaBuilder()->getColumnListing($table);
    }

    public function getTableColumnStats(Request $request, $table, $column)
    {
        return \DB::table($table)
            ->select($column, \DB::raw("count($column) as visits"))
            ->groupBy($column)->paginate();
    }
}
