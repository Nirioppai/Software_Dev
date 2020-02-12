<!DOCTYPE html>
<html>
<head>
      <link href="./css/pdf.css" rel="stylesheet" />
      <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body class="body">


            <th style="border: 1px solid; padding:5px;" width="1%">Name</th>
          <th style="border: 1px solid; padding:5px;" width="1%">Address</th>
          <th style="border: 1px solid; padding:5px;" width="1%">City</th>
          <th style="border: 1px solid; padding:5px;" width="1%">City</th>


          @foreach($batch_results as $student)

            <tr>
            <td style="border: 1px solid; padding:5px;">{{$student->id}}</td>
            <td style="border: 1px solid; padding:5px;">{{$student->name}}</td>
            </tr>
            
      

            @endforeach
            


</body>
</html>