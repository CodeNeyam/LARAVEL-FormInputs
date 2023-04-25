<?php

namespace App\Http\Controllers;

use App\Models\FormData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use DateTime;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class FormDataController extends Controller
{
    // Store method to store all the data from the form
    public function store(Request $request) {
        $validatedData = $request->validate([
            'text' => 'required',
            'email' => 'required|email',
            'number' => 'required|integer',
            'select' => 'required',
            'img' => 'required|image',
            'file' => 'required|file',
            'url' => 'required|url',
            'checkboxes' => 'nullable|array',
            'radio' => 'required',
            'date' => 'required|date'
        ]);

        $imgPath = $request->img->store('images', 'public');
        $filePath = $request->file->store('files', 'public');

        $formData = FormData::create([
            'text' => $validatedData['text'],
            'email' => $validatedData['email'],
            'number' => $validatedData['number'],
            'select' => $validatedData['select'],
            'img' => $imgPath,
            'file' => $filePath,
            'url' => $validatedData['url'],
            'checkboxes' => implode(',', $validatedData['checkboxes']),
            'radio' => $validatedData['radio'],
            'date' => $validatedData['date']
        ]);
        // After storing the form data in the database
        return redirect()->back()->with('success', 'Data stored successfully')->with('formData', $formData->id)->with('submit_case', true);

    }
    

    // -------------------------------------------------------------------------DATA AS CSV FILE--------------------------------------------------------------

//     // Download method to download the data I inserted as an CSV file
//     public function download($id)
//     {
//     $formData = FormData::findOrFail($id);

//     // Prepare the data for download as a CSV file
//     $headers = array(
//         "Content-type" => "text/csv",
//         "Content-Disposition" => "attachment; filename=data.csv",
//         "Pragma" => "no-cache",
//         "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
//         "Expires" => "0"
//     );
    
//     $callback = function() use ($formData) {
//         $file = fopen('php://output', 'w');
//         fputcsv($file, array_keys($formData->toArray())); // Column headers
//         fputcsv($file, $formData->toArray()); // Data
//         fclose($file);
//     };

//     return response()->stream($callback, 200, $headers);
//     }
    
//     // Download all my data from the database as an CSV file
//     public function downloadAll()
// {
//     $allFormData = FormData::all();

//     // Prepare the data for download as a CSV file
//     $headers = array(
//         "Content-type" => "text/csv",
//         "Content-Disposition" => "attachment; filename=all_data.csv",
//         "Pragma" => "no-cache",
//         "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
//         "Expires" => "0"
//     );

//     $callback = function() use ($allFormData) {
//         $file = fopen('php://output', 'w');

//         // Write the column headers
//         if (!$allFormData->isEmpty()) {
//             fputcsv($file, array_keys($allFormData->first()->toArray()));
//         }

//         // Write the data
//         foreach ($allFormData as $formData) {
//             fputcsv($file, $formData->toArray());
//         }

//         fclose($file);
//     };

//     return response()->stream($callback, 200, $headers);
// }

// // Import the data from CSV 
// public function import(Request $request) {
//     $validatedData = $request->validate([
//         'csv' => 'required|file|mimes:csv,txt|max:2048',
//     ]);

//     $csvPath = $request->file('csv')->getRealPath();
//     $csvFile = fopen($csvPath, 'r');

//     // Skip the header row
//     fgetcsv($csvFile);

//     // Read and store the data in the database
//     while (($row = fgetcsv($csvFile)) !== false) {
//           // Try multiple date formats
//           $date = DateTime::createFromFormat('d/m/Y', $row[10]) ?: DateTime::createFromFormat('Y-m-d', $row[10]);
//         // If the date is still not valid, return an error message
//         if (!$date) {
//             return redirect()->back()->with('error', 'Invalid date format in the CSV file.');
//         }
//         $formattedDate = $date->format('Y-m-d');

//         /*
//         This code tries to parse the date using both 'd/m/Y' and 'Y-m-d' formats. If neither of these formats work,
//         the function will return an error message. This should resolve the issue with importing the CSV file after saving it with the changed
//         */

//         FormData::create([
//             'id' => $row[0],
//             'text' => $row[1],
//             'email' => $row[2],
//             'number' => $row[3],
//             'select' => $row[4],
//             'img' => $row[5],
//             'file' => $row[6],
//             'url' => $row[7],
//             'checkboxes' => implode(',', array_map('trim', explode(',', $row[8]))),
//             'radio' => $row[9], 
//             'date' => $formattedDate
//         ]);
//     }
//     fclose($csvFile);

//     return redirect()->back()->with('success', 'CSV data imported successfully');
// }



// ---------------------------------------------------------------------------------DATA AS XLSX FILE---------------------------------------------------------------------------------------------

 // Download method to download the data as an XLSX file
 public function download($id)
 {
     $formData = FormData::findOrFail($id);
 
     $spreadsheet = new Spreadsheet();
     $worksheet = $spreadsheet->getActiveSheet();
 
     // Column headers
     $columnIndex = 1;
     foreach (array_keys($formData->toArray()) as $header) {
         $worksheet->setCellValueByColumnAndRow($columnIndex, 1, $header);
         $columnIndex++;
     }
 
     // Data
     $columnIndex = 1;
     foreach ($formData->toArray() as $value) {
         $worksheet->setCellValueByColumnAndRow($columnIndex, 2, $value);
         $columnIndex++;
     }
 
     $writer = new Xlsx($spreadsheet);
 
     $fileName = 'data.xlsx';
     $tempPath = storage_path('app/' . $fileName);
 
     $writer->save($tempPath);
 
     $headers = [
         'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
         'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
     ];
 
     return response()->download($tempPath, $fileName, $headers)->deleteFileAfterSend(true);
 }
 
 // Download all my data from the database as an XLSX file

 public function downloadAll()
 {
     $allFormData = FormData::all();
 
     $spreadsheet = new Spreadsheet();
     $worksheet = $spreadsheet->getActiveSheet();
 
     // Write the column headers
     if (!$allFormData->isEmpty()) {
         $columnIndex = 1;
         foreach (array_keys($allFormData->first()->toArray()) as $header) {
             $worksheet->setCellValueByColumnAndRow($columnIndex, 1, $header);
             $columnIndex++;
         }
     }
 
     // Write the data
     $rowIndex = 2;
     foreach ($allFormData as $formData) {
         $columnIndex = 1;
         foreach ($formData->toArray() as $key => $value) {
             if ($key === 'checkboxes' && is_null($value)) {
                 $value = '';
             }
             $worksheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
             $columnIndex++;
         }
         $rowIndex++;
     }
 
     $writer = new Xlsx($spreadsheet);
 
     $fileName = 'all_data.xlsx';
     $tempPath = storage_path('app/' . $fileName);
 
     $writer->save($tempPath);
 
     $headers = [
         'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
         'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
     ];
 
     return response()->download($tempPath, $fileName, $headers)->deleteFileAfterSend(true);
 }
 

//  Method to import the XLSX file 
public function import(Request $request)
{
    $validatedData = $request->validate([
        'file' => 'required|file|mimes:xlsx|max:2048',
    ]);

    $path = $request->file('file')->getRealPath();
    $spreadsheet = IOFactory::load($path);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    // Skip the header row
    array_shift($rows);

    // Read and store the data in the database
    foreach ($rows as $row) {
        // Try multiple date formats
        $date = DateTime::createFromFormat('d/m/Y', $row[10]) ?: DateTime::createFromFormat('Y-m-d', $row[10]);
        // If the date is still not valid, return an error message
        if (!$date) {
            return redirect()->back()->with('error', 'Invalid date format in the XLSX file.');
        }
        $formattedDate = $date->format('Y-m-d');

        FormData::create([
            'id' => $row[0],
            'text' => $row[1],
            'email' => $row[2],
            'number' => $row[3],
            'select' => $row[4],
            'img' => $row[5],
            'file' => $row[6],
            'url' => $row[7],
            'checkboxes' => implode(',', array_map('trim', explode(',', $row[8]))),
            'radio' => $row[9], 
            'date' => $formattedDate
        ]);
    }
    return redirect()->back()->with('success', 'XLSX data imported successfully');
    }
}
