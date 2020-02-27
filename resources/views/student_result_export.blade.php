<!DOCTYPE html>
<html>
<head>
	<link href="./css/pdf.css" rel="stylesheet" />
      <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body class="body">



            

            <div class="row-sm mt-4 picture-anchor">
            <img style="width: 100%; height: 100%;" src="./img/pdf/PDF_Export.png">
            <div class="text-2">{{$student_details->student_name}}</div>
            <div class="text-3">{{$student_details->grade}}-{{$student_details->section}}</div>
            <div class="text-4">Xavier School San Juan</div>
            <div class="text-5"></div>
            <div class="text-6">{{$student_details->exam_date}}</div>
            <div class="text-7">{{$student_details->birthday}}</div>
            <div class="text-8">{{$student_details->age_year}}.{{$student_details->age_month}} Years old</div>
            <div class="text-9">{{$student_details->verbal_raw}}</div>
            <div class="text-10">{{$student_details->nonverbal_raw}}</div>
            <div class="text-11">{{$student_details->total_raw}}</div>
            <div class="text-12">{{$student_details->verbal_scaled}}</div>
            <div class="text-13">{{$student_details->nonverbal_scaled}}</div>
            <div class="text-14">{{$student_details->total_scaled}}</div>
            <div class="text-15">{{$student_details->verbal_sai}}</div>
            <div class="text-16">{{$student_details->nonverbal_sai}}</div>
            <div class="text-17">{{$student_details->total_sai}}</div>
            <div class="text-18">{{$student_details->verbal_percentile}}</div>
            <div class="text-19">{{$student_details->nonverbal_percentile}}</div>
            <div class="text-20">{{$student_details->total_percentile}}</div>
            <div class="text-21">{{$student_details->verbal_stanine}}</div>
            <div class="text-22">{{$student_details->nonverbal_stanine}}</div>
            <div class="text-23">{{$student_details->total_stanine}}</div>
            <div class="text-24">{{$student_details->verbal_classification}}</div>
            <div class="text-25">{{$student_details->nonverbal_classification}}</div>
            <div class="text-26">{{$student_details->total_classification}}</div>
            
            <div class="text-27">{{$student_details->verbal_comprehension}}</div>
            <div class="text-28">{{$student_details->verbal_reasoning}}</div>
            <div class="text-29">{{$student_details->figural_reasoning}}</div>
            <div class="text-30">{{$student_details->quantitative_reasoning}}</div>

            
        </div>

</body>
</html>