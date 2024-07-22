<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;

class StudentDataController extends Controller
{
    public function uploadStudentData(Request $request)
    {
        $request->validate([
            'student_data' => 'required|mimes:csv,txt',
        ]);

        $path = $request->file('student_data')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);

        $tableName = 'students';

        // Drop the table if it exists
        if (Schema::hasTable($tableName)) {
            Schema::drop($tableName);
        }

        // Create the table
        Schema::create($tableName, function (Blueprint $table) use ($header) {
            $table->id();
            $columns = [];
            foreach ($header as $column) {
                $column = strtolower($column); // Ensure column names are lowercase
                if (!in_array($column, $columns) && $column !== 'id' && $column !== 'created_at' && $column !== 'updated_at') { // Avoid conflict with 'id' column and duplicates
                    $table->string($column)->nullable();
                    $columns[] = $column;
                }
            }
            $table->timestamps();
        });

        // Insert the data
        foreach ($data as $row) {
            // Ensure the row has the same number of columns as the header
            if (count($row) === count($header)) {
                $rowData = array_combine($header, $row);
                // Remove the 'ID', 'created_at', and 'updated_at' columns to avoid conflict
                unset($rowData['ID']);
                unset($rowData['created_at']);
                unset($rowData['updated_at']);
                DB::table($tableName)->insert($rowData);
            } else {
                // Handle the mismatch case, e.g., log the error or skip the row
                Log::warning("Row does not match header columns", ['row' => $row]);
                continue;
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Student data uploaded successfully.');
    }
}
