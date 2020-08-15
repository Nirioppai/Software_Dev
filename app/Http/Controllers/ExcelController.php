<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use DB;
use Excel;

class ExcelController extends Controller
{
    function exportExcel($batch)
    {
      $student_batch = DB::table('student_batch')->where('batch',  $batch)->orderBy('student_name', 'asc')->get()->toArray();
      $count_students = count($student_batch);
      $student_batch_array[] = array(
          'Section',
          'No.',
          'Name',
          'Birthday',
          'Age',

          'Verbal Comprehension TS',
          'Verbal Comprehension RS',
          'Verbal Reasoning TS',
          'Verbal Reasoning RS',
          'Total Verbal TS',
          'Total Verbal RS',
          'Total Verbal SS',
          'Total Verbal SAI',
          'Total Verbal PR',
          'Total Verbal S',
          'Total Verbal CL',

          'Figural Reasoning TS',
          'Figural Reasoning RS',
          'Quantitative Reasoning TS',
          'Quantitative Reasoning RS',
          'Total Non Verbal TS',
          'Total Non Verbal RS',
          'Total Non Verbal SS',
          'Total Non Verbal SAI',
          'Total Non Verbal PR',
          'Total Non Verbal S',
          'Total Non Verbal CL',

          'Total Score TS',
          'Total Score RS',
          'Total Score SS',
          'Total Score SAI',
          'Total Score PR',
          'Total Score S',
          'Total Score CL');

      $number = 1;
      foreach($student_batch as $student){

        $student_batch_array[] = array(
          'Section' => $student->section,
          'No.' => $number,
          'Name' => $student->student_name,
          'Birthday' => $student->birthday_short,
          'Age' => "".$student->age_year.".".$student->age_month."",

          'Verbal Comprehension TS' => 12,
          'Verbal Comprehension RS' => $student->verbal_comprehension,
          'Verbal Reasoning TS' => 24,
          'Verbal Reasoning RS' => $student->verbal_reasoning,
          'Total Verbal TS' => 36,
          'Total Verbal RS' => $student->verbal_raw,
          'Total Verbal SS' => $student->verbal_scaled,
          'Total Verbal SAI' => $student->verbal_sai,
          'Total Verbal PR' => $student->verbal_percentile,
          'Total Verbal S' => $student->verbal_stanine,
          'Total Verbal CL' => $student->verbal_classification,

          'Figural Reasoning TS' => 18,
          'Figural Reasoning RS' => $student->figural_reasoning,
          'Quantitative Reasoning TS' => 18,
          'Quantitative Reasoning RS' => $student->quantitative_reasoning,
          'Total Non Verbal TS' => 36,
          'Total Non Verbal RS' => $student->nonverbal_raw,
          'Total Non Verbal SS' => $student->nonverbal_scaled,
          'Total Non Verbal SAI' => $student->nonverbal_sai,
          'Total Non Verbal PR' => $student->nonverbal_percentile,
          'Total Non Verbal S' => $student->nonverbal_stanine,
          'Total Non Verbal CL' => $student->nonverbal_classification,

          'Total Score TS' => 72,
          'Total Score RS' => $student->total_raw,
          'Total Score SS' => $student->total_scaled,
          'Total Score SAI' => $student->total_sai,
          'Total Score PR' => $student->total_percentile,
          'Total Score S' => $student->total_stanine,
          'Total Score CL' => $student->total_classification);
          $number++;
      }

      Excel::create("Student Result Batch ".$batch."", function($excel) use ($student_batch_array){
        $excel->setTitle('Student Results');
        $excel->sheet('Student Results', function($sheet) use ($student_batch_array){
          $sheet->fromArray($student_batch_array, null, 'A17', false, false);

          // TEXTS TITLE - VERBAL

          $sheet->setCellValue('A6', 'OTIS-LENNON SCHOOL ABILITY TEST 8th Ed. Level D');
          $sheet->setCellValue('A7', 'Masterlist Report (Batch)');
          $sheet->setCellValue('C9', 'GRADE:');
          $sheet->setCellValue('C10', 'SCHOOL:');
          $sheet->setCellValue('D10', 'Xavier School');
          $sheet->setCellValue('C11', 'TEST DATE:');
          $sheet->setCellValue('C12', 'TOTAL NO. OF STUDENTS');

          $sheet->setCellValue('B14', 'No.');
          $sheet->setCellValue('C14', 'NAME');
          $sheet->setCellValue('D14', 'BIRTHDAY');
          $sheet->setCellValue('E14', 'AGE');

          $sheet->setCellValue('F14', 'VERBAL');

          $sheet->setCellValue('F15', 'Verbal Comprehension');
          $sheet->setCellValue('H15', 'Verbal Reasoning');
          $sheet->setCellValue('F17', 'No. of Items');
          $sheet->setCellValue('G17', 'RS');
          $sheet->setCellValue('H17', 'No. of Items');
          $sheet->setCellValue('I17', 'RS');

          $sheet->setCellValue('J15', 'TOTAL VERBAL');
          $sheet->setCellValue('J16', 'No. of Items');
          $sheet->setCellValue('K16', 'RS');
          $sheet->setCellValue('L16', 'SS');
          $sheet->setCellValue('J17', '');
          $sheet->setCellValue('K17', '');
          $sheet->setCellValue('L17', '');

          $sheet->setCellValue('M16', 'AGE NORMS');
          $sheet->setCellValue('M17', 'SAI');
          $sheet->setCellValue('N17', 'PR');
          $sheet->setCellValue('O17', 'S');
          $sheet->setCellValue('P17', 'CL');

          // CELL BORDERS TITLE - VERBAL

          $sheet->cells('B14:B17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thin', 'thick');
          });
          $sheet->cells('C14:C17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thin', 'thick');
          });
          $sheet->cells('D14:D17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('E14:E17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('F15:G16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('H15:I16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('F14:P14', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('F17:G17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('H17:I17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('J16:L17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('M16:O16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('M17:P17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('J15:P15', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('F17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('G17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('H17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('I17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('J16:J17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('K16:K17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('L16:L17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });

          $sheet->cells('M17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('N17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('O17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('P17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });

          // CELL MERGE TITLE - VERBAL

          $sheet->mergeCells('B14:B17');
          $sheet->mergeCells('C14:C17');
          $sheet->mergeCells('D14:D17');
          $sheet->mergeCells('E14:E17');

          $sheet->mergeCells('F15:G16');
          $sheet->mergeCells('H15:I16');

          $sheet->mergeCells('I1:AH1');
          $sheet->mergeCells('I2:AH2');
          $sheet->mergeCells('I3:AH3');
          $sheet->mergeCells('I1:AH1');
          $sheet->mergeCells('A4:AH4');
          $sheet->mergeCells('A6:AH6');
          $sheet->mergeCells('A7:AH7');

          $sheet->mergeCells('D11:E11');

          $sheet->mergeCells('F14:P14');
          $sheet->mergeCells('F15:G15');
          $sheet->mergeCells('H15:I15');
          $sheet->mergeCells('J15:P15');
          $sheet->mergeCells('M16:P16');
          $sheet->mergeCells('J16:J17');
          $sheet->mergeCells('K16:K17');
          $sheet->mergeCells('L16:L17');

          // TEXT STYLING TITLE - VERBAL

          $sheet->cells('A6', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
            $cells->setFontWeight('bold');
          });
          $sheet->cells('A7', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });

          $sheet->cells('C9', function($cells){
            $cells->setFontWeight('bold');
          });
          $sheet->cells('C10', function($cells){
            $cells->setFontWeight('bold');
          });
          $sheet->cells('C11', function($cells){
            $cells->setFontWeight('bold');
          });
          $sheet->cells('C12', function($cells){
            $cells->setFontWeight('bold');
          });
          $sheet->cells('D9', function($cells){
            $cells->setFontWeight('bold');
          });
          $sheet->cells('D10', function($cells){
            $cells->setFontWeight('bold');
          });
          $sheet->cells('D11', function($cells){
            $cells->setFontWeight('bold');
          });
          $sheet->cells('D12', function($cells){
            $cells->setFontWeight('bold');
          });

          $sheet->cells('B14', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('C14', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
            $cells->setFontWeight('bold');
          });
          $sheet->cells('D14', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
            $cells->setFontWeight('bold');
          });
          $sheet->cells('E14', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
            $cells->setFontWeight('bold');
          });

          $sheet->cells('F14', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
            $cells->setFontWeight('bold');
          });
          $sheet->cells('F15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('H15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('J15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('F17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('G17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('H17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('I17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('J16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('K16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('L16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('M17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('N17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('O17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('P17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('Q17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('R17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('S17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('M16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('P16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });

          // TEXTS NON VERBAL

          $sheet->setCellValue('Q14', 'NON VERBAL');

          $sheet->setCellValue('Q15', 'Figural Reasoning');
          $sheet->setCellValue('S15', 'Quantitative Reasoning');
          $sheet->setCellValue('Q17', 'No. of Items');
          $sheet->setCellValue('R17', 'RS');
          $sheet->setCellValue('S17', 'No. of Items');
          $sheet->setCellValue('T17', 'RS');

          $sheet->setCellValue('U15', 'TOTAL NON VERBAL');
          $sheet->setCellValue('U16', 'No. of Items');
          $sheet->setCellValue('V16', 'RS');
          $sheet->setCellValue('W16', 'SS');
          $sheet->setCellValue('U17', '');
          $sheet->setCellValue('V17', '');
          $sheet->setCellValue('W17', '');

          $sheet->setCellValue('X16', 'AGE NORMS');
          $sheet->setCellValue('X17', 'SAI');
          $sheet->setCellValue('Y17', 'PR');
          $sheet->setCellValue('Z17', 'S');
          $sheet->setCellValue('AA17', 'CL');

          // BORDERS NON VERBAL

          $sheet->cells('Q14:AA14', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('Q15:R16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('S15:T16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('U15:AA15', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('X16:AA16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('X17:AA17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('U16:W17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('Q17:R17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('S17:T17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('Q17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('R17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('S17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('T17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('U16:U17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('V16:V17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('W16:W17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });
          $sheet->cells('X17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('Y17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('Z17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('AA17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });

          // MERGE NON VERBAL

          $sheet->mergeCells('Q14:AA14');
          $sheet->mergeCells('Q15:R16');
          $sheet->mergeCells('S15:T16');
          $sheet->mergeCells('U15:AA15');
          $sheet->mergeCells('U16:U17');
          $sheet->mergeCells('V16:V17');
          $sheet->mergeCells('W16:W17');
          $sheet->mergeCells('X16:AA16');

          // TEXT STYLING NON VERBAL

          $sheet->cells('Q14', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
            $cells->setFontWeight('bold');
          });
          $sheet->cells('Q15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('S15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('Q17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('R17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('S17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('T17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('U15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('U16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('V16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('W16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AA16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('X16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('X17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('Y17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('Z17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AA17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });

          // TEXTS TOTAL

          $sheet->setCellValue('AB14', 'TOTAL');

          $sheet->setCellValue('AB15', 'No. of Items');
          $sheet->setCellValue('AC15', 'RS');
          $sheet->setCellValue('AD15', 'SS');

          $sheet->setCellValue('AE15', 'AGE NORMS');
          $sheet->setCellValue('AE17', 'SAI');
          $sheet->setCellValue('AF17', 'PR');
          $sheet->setCellValue('AG17', 'S');
          $sheet->setCellValue('AH17', 'CL');

          // BORDERS TOTAL

          $sheet->cells('AB14:AH14', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AE15:AH16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AB15:AD17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AE17:AH17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AB16:AB17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('AC16:AC17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('AD16:AD17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });
          $sheet->cells('AE17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('AF17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('AG17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('AH17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });
          $sheet->cells('AB15:AB17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('AC15:AC17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('AD15:AD17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });

          // MERGE TOTAL

          $sheet->mergeCells('AB14:AH14');
          $sheet->mergeCells('AB15:AB17');
          $sheet->mergeCells('AC15:AC17');
          $sheet->mergeCells('AD15:AD17');
          $sheet->mergeCells('AE15:AH16');

          // TEXT STYLING TOTAL

          $sheet->cells('AB14', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
            $cells->setFontWeight('bold');
          });
          $sheet->cells('AH15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AB15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AC15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AD15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AE15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });

          $sheet->cells('AE17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AF17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AG17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AH17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });

        });
      })->download('xlsx');
    }

}
