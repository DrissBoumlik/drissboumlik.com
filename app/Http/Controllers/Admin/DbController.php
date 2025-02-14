<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\DbDumper\Databases\MySql;
use Illuminate\Support\Facades\Response;
use Spatie\Sitemap\SitemapGenerator;

class DbController extends Controller
{

    public function export_db(Request $request, MySql $dumpDB)
    {
        try {
            $tables = $request->get('tables');
            $dontCreateTables = $request->has('dont-create-tables');
            $dontExportData = $request->has('dont-export-data');
            $now = date("Y-m-d_h-i");
            $db_name = env('DB_DATABASE');
            $filename = $db_name . "_exported_at_$now.sql";
            $dumpPath = database_path("dumps/$filename");
//            $dumpDB = \Spatie\DBDumper\Databases\MySql::create();
            $dumpDB = $dumpDB
                ->setDbName($db_name)
                ->setUserName(env('DB_USERNAME'))
                ->setPassword(env('DB_PASSWORD'));
            if ($dontCreateTables) {
                $dumpDB = $dumpDB->doNotCreateTables();
            }
            if ($dontExportData) {
                $dumpDB = $dumpDB->doNotDumpData();
            }
            if ($tables) {
                $tables = explode(' ', $request->get('tables'));
                $dumpDB = $dumpDB->includeTables($tables);
            }
            $dumpDB->dumpToFile($dumpPath);
            return Response::download($dumpPath, $filename, [
                'Content-Type' => 'application/sql',
                // 'Content-Transfer-Encoding'=> 'binary',
                // 'Accept-Ranges'=> 'bytes'
            ]);
        } catch (\Throwable $e) {
            return back()->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
    }

    public function exportDbConfig(Request $request)
    {
        $data = adminPageSetup('Export DB | Admin Panel');
        $data->tables = DB::table('information_schema.tables')
            ->select('table_name', 'table_rows')
            ->where('table_schema', DB::getDatabaseName())
            ->get()
            ->map(function ($table) {
                return (object) [
                    'name' => $table->table_name,
                    'count' => $table->table_rows
                ];
            });
        return view('admin.pages.export-db-config', ['data' => $data]);
    }

    public function getTableColumns(Request $request, $table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }

    public function getTableColumnStats(Request $request)
    {
        $table = $request->get('table');
        $column = $request->get('column');
        $year = $request->get('year');
        $perPage = $request->get('perPage') ?? 20;
        if ($year) {
            return DB::table($table)
                ->select($column, DB::raw("month(updated_at) as month"), DB::raw("count($column) as visits"))
                ->whereYear('updated_at', $year)
                ->orderby('visits', 'desc')
                ->groupBy($column, 'month')->paginate($perPage);
        }

        return DB::table($table)
            ->select($column, DB::raw("count($column) as visits"))
            ->orderby('visits', 'desc')
            ->groupBy($column)->paginate($perPage);
    }
}
