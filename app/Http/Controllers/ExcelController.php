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
          'Verbal Grade Norms PR',
          'Verbal Grade Norms S',
          'Verbal Grade Norms CL',
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
          'Non Verbal Grade Norms PR',
          'Non Verbal Grade Norms S',
          'Non Verbal Grade Norms CL',
          'Total Non Verbal SAI',
          'Total Non Verbal PR',
          'Total Non Verbal S',
          'Total Non Verbal CL',

          'Total Score TS',
          'Total Score RS',
          'Total Score SS',
          'Total Grade Norms PR',
          'Total Grade Norms S',
          'Total Grade Norms CL',
          'Total Score SAI',
          'Total Score PR',
          'Total Score S',
          'Total Score CL');

      $number = 1;
      foreach($student_batch as $student){

        $student_batch_array[] = array(
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
          'Verbal Grade Norms PR' => "",
          'Verbal Grade Norms S' => "",
          'Verbal Grade Norms CL' => "",
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
          'Non Verbal Grade Norms PR' => "",
          'Non Verbal Grade Norms S' => "",
          'Non Verbal Grade Norms CL' => "",
          'Total Non Verbal SAI' => $student->nonverbal_sai,
          'Total Non Verbal PR' => $student->nonverbal_percentile,
          'Total Non Verbal S' => $student->nonverbal_stanine,
          'Total Non Verbal CL' => $student->nonverbal_classification,

          'Total Score TS' => 72,
          'Total Score RS' => $student->total_raw,
          'Total Score SS' => $student->total_scaled,
          'Total Grade Norms PR' => "",
          'Total Grade Norms S' => "",
          'Total Grade Norms CL' => "",
          'Total Score SAI' => $student->total_sai,
          'Total Score PR' => $student->total_percentile,
          'Total Score S' => $student->total_stanine,
          'Total Score CL' => $student->total_classification);
          $number++;
      }

      Excel::create("Student Result Batch ".$batch."", function($excel) use ($student_batch_array){
        $excel->setTitle('Student Results');
        $excel->sheet('Student Results', function($sheet) use ($student_batch_array){
          $sheet->fromArray($student_batch_array, null, 'B17', false, false);

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

          $sheet->setCellValue('M16', 'GRADE NORMS');
          $sheet->setCellValue('M17', 'PR');
          $sheet->setCellValue('N17', 'S');
          $sheet->setCellValue('O17', 'CL');

          $sheet->setCellValue('P16', 'AGE NORMS');
          $sheet->setCellValue('P17', 'SAI');
          $sheet->setCellValue('Q17', 'PR');
          $sheet->setCellValue('R17', 'S');
          $sheet->setCellValue('S17', 'CL');

          $sheet->cells('F15:G16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('H15:I16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
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
          $sheet->cells('F14:S14', function($cells) {
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
          $sheet->cells('P16:S16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('M17:O17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('P17:S17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('J15:S15', function($cells) {
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
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });

          $sheet->cells('P17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('Q17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('R17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('S17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });


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
          $sheet->mergeCells('A4:AT4');
          $sheet->mergeCells('A6:AT6');
          $sheet->mergeCells('A7:AT7');

          $sheet->mergeCells('D11:E11');

          $sheet->mergeCells('F14:S14');
          $sheet->mergeCells('F15:G15');
          $sheet->mergeCells('H15:I15');
          $sheet->mergeCells('J15:S15');
          $sheet->mergeCells('M16:O16');
          $sheet->mergeCells('P16:S16');
          $sheet->mergeCells('J16:J17');
          $sheet->mergeCells('K16:K17');
          $sheet->mergeCells('L16:L17');

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

          $sheet->setCellValue('T14', 'NON VERBAL');

          $sheet->setCellValue('T15', 'Figural Reasoning');
          $sheet->setCellValue('V15', 'Quantitative Reasoning');
          $sheet->setCellValue('T17', 'No. of Items');
          $sheet->setCellValue('U17', 'RS');
          $sheet->setCellValue('V17', 'No. of Items');
          $sheet->setCellValue('W17', 'RS');

          $sheet->setCellValue('X15', 'TOTAL NON VERBAL');
          $sheet->setCellValue('X16', 'No. of Items');
          $sheet->setCellValue('Y16', 'RS');
          $sheet->setCellValue('Z16', 'SS');
          $sheet->setCellValue('X17', '');
          $sheet->setCellValue('Y17', '');
          $sheet->setCellValue('Z17', '');

          $sheet->setCellValue('AA16', 'GRADE NORMS');
          $sheet->setCellValue('AA17', 'PR');
          $sheet->setCellValue('AB17', 'S');
          $sheet->setCellValue('AC17', 'CL');

          $sheet->setCellValue('AD16', 'AGE NORMS');
          $sheet->setCellValue('AD17', 'SAI');
          $sheet->setCellValue('AE17', 'PR');
          $sheet->setCellValue('AF17', 'S');
          $sheet->setCellValue('AG17', 'CL');

          $sheet->cells('T15:U16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('V15:W16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('T14:AG14', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('V17:W17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('T17:U17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('X15:AG15', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AA16:AC16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AD16:AG16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AA17:AC17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AD17:AG17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AA16:AC16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('X16:Z17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('T17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('U17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });
          $sheet->cells('V17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('W17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });
          $sheet->cells('X16:X17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('Y16:Y17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('Z16:Z17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });
          $sheet->cells('AA17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('AB17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('AC17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });
          $sheet->cells('AD17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('AE17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('AF17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('AG17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });

          $sheet->mergeCells('T14:AG14');
          $sheet->mergeCells('T15:U16');
          $sheet->mergeCells('V15:W16');
          $sheet->mergeCells('X15:AG15');
          $sheet->mergeCells('AA16:AC16');
          $sheet->mergeCells('AD16:AG16');
          $sheet->mergeCells('X16:X17');
          $sheet->mergeCells('Y16:Y17');
          $sheet->mergeCells('Z16:Z17');

          $sheet->cells('T14', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
            $cells->setFontWeight('bold');
          });
          $sheet->cells('T15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('V15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('T17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('U17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('V17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('W17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('X15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('X16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('Y16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('Z16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AA16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AD16', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AA17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AB17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AC17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AD17', function($cells){
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

          $sheet->setCellValue('AH14', 'NON VERBAL');

          $sheet->setCellValue('AH15', 'No. of Items');
          $sheet->setCellValue('AI15', 'RS');
          $sheet->setCellValue('AJ15', 'SS');

          $sheet->setCellValue('AK15', 'GRADE NORMS');
          $sheet->setCellValue('AK17', 'PR');
          $sheet->setCellValue('AL17', 'S');
          $sheet->setCellValue('AM17', 'CL');

          $sheet->setCellValue('AN15', 'AGE NORMS');
          $sheet->setCellValue('AN17', 'SAI');
          $sheet->setCellValue('AO17', 'PR');
          $sheet->setCellValue('AP17', 'S');
          $sheet->setCellValue('AQ17', 'CL');

          $sheet->setCellValue('AR14', 'Normal Curve Equivalent');
          $sheet->setCellValue('AR17', 'Age');
          $sheet->setCellValue('AS17', 'Grade');

          $sheet->cells('AH14:AQ14', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AH15:AJ17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AK15:AM16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AN15:AQ16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AK17:AM17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AN17:AQ17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AR14:AS16', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AR17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AS17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thick');
          });
          $sheet->cells('AH15:AH17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('AJ15:AJ17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });
          $sheet->cells('AI15:AI17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('AL17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('AM17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });
          $sheet->cells('AN17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thick');
          });
          $sheet->cells('AO17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('AP17', function($cells) {
            $cells->setBorder('thick', 'thin', 'thick', 'thin');
          });
          $sheet->cells('AQ17', function($cells) {
            $cells->setBorder('thick', 'thick', 'thick', 'thin');
          });

          $sheet->mergeCells('AH14:AQ14');
          $sheet->mergeCells('AH15:AH17');
          $sheet->mergeCells('AI15:AI17');
          $sheet->mergeCells('AJ15:AJ17');
          $sheet->mergeCells('AK15:AM16');
          $sheet->mergeCells('AN15:AQ16');
          $sheet->mergeCells('AR14:AS16');


          $sheet->cells('AL15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AN15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AH14', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
            $cells->setFontWeight('bold');
          });
          $sheet->cells('AH15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AI15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AJ15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AK15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AN15', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AR14', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AK17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AL17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AM17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AN17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AO17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AP17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AQ17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AR17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });
          $sheet->cells('AS17', function($cells){
            $cells->setAlignment('center');
            $cells->setVAlignment('center');
          });

        });
      })->download('xlsx');
    }

}
