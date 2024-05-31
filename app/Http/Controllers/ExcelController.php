<?php

namespace App\Http\Controllers;

use App\Exports\ServiceCenterExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ProductTimeline;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    public function ExportServiceCenterByComp(Request $request)
    {
        $month = $request->month;
        $id = $request->project_id;
        $year = $request->year;
        try {
            return Excel::download(new ServiceCenterExport($month, $id, $year), 'สรุปภาพรวมเข้ารับบริการ.xlsx');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error downloading file: ' . $e->getMessage()], 400);
        }
    }
}

