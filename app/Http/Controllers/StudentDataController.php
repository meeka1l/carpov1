<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function downloadStudentData()
    {
        $tableName = 'students';

        if (!Schema::hasTable($tableName)) {
            return redirect()->route('admin.dashboard')->with('error', 'No student data available.');
        }

        $students = DB::table($tableName)->get();

        $response = new StreamedResponse(function () use ($students) {
            $handle = fopen('php://output', 'w');
            // Add the header of the CSV file
            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Address', 'Created At', 'Updated At']);

            // Add the rows
            foreach ($students as $student) {
                fputcsv($handle, [
                    $student->id,
                    $student->name,
                    $student->email,
                    $student->phone,
                    $student->address,
                    $student->created_at,
                    $student->updated_at,
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="students.csv"');

        return $response;
    }
}
