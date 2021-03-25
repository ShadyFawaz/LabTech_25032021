<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Result Tracking)</title>
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
}  

    table {
        font: 15px/15px Serif;
        border-collapse: collapse;
        width: auto;
        margin: auto;
     
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 5px;
  background-color: white;
}

</style>  
@include('MainMenu')

</head>
<body>
<!-- <center> <h1 > Result Tracking </h1> </center>  -->
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<center> <h4 > {{$users[0]->TestData->abbrev}} </h4> </center> 
<center> <h4 > {{$users[0]->PatientReg->patient_name}} - {{$users[0]->PatientReg->visit_no}}</h4> </center> 
@endif
<table  id="myTable" border = "1">
<tr class="header">
<th>Result</th>
<th>Modified By</th>
<th>Modification Time</th>
</tr>
@foreach ($users as $user)
<tr>
<td>{{ $user->result }}</td>
<td>{{ $user->Users->user_name }}</td>
<td>{{ $user->modify_time }}</td>
</tr>
@endforeach
</table>
</body>
</html>