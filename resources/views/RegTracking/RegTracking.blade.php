<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Result Tracking)</title>
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
}  

#table-wrapper  {
  position:relative !important;
  line-height:10px;

}
#table-scroll {
  height:150px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:50% !important;
  font-size:12px;
  font-weight:bold;
  margin:auto;
  line-height:24px;
}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  /* font-weight:bold; */
}
#table-wrapper table thead th .text {
  position:absolute !important;   
  top:-20px !important;
  z-index:2 !important;
  height:20px !important;
  width:35% !important;
  border:1px solid red !important;
}
#table-wrapper table  th {
  top:0;
  position: sticky;
}
#myInput {
  width: 50%;
  font-size: 14px;
  padding: 10px 15px 10px 20px;
  border: 1px solid #ddd;
  margin-bottom: 10px;
}

</style>  
</head>
@include('MainMenu')
<body>
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<center> <h4 > {{$users[0]->PatientReg->patient_name}} - {{$users[0]->PatientReg->visit_no}}</h4> </center> 
@endif
<center> <h1 > {{__('title.reg_tracking')}} </h1> </center>   

<div id="table-wrapper">
  <div id="table-scroll">
  <table id="myTable">
        <thead>
            <tr>
<th>Modified By</th>
<th>Status</th>
<th>Modification Time</th>
</tr>
</thead>
  <tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->Users->user_name }}</td>
<td>{{ $user->status }}</td>
<td>{{ $user->mod_date }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
<center> <h1 > {{__('title.testreg_tracking')}} </h1> </center>   
<div id="table-wrapper">
  <div id="table-scroll">
  <table id="myTable">
        <thead>
            <tr>
<th>Test Name</th>
<th>Registered By</th>
<th>Registration Date</th>

</tr>
</thead>
  <tbody>
@foreach ($testsreg as $testreg)
<tr>
@if($testreg->megatest_id)
<td>{{ $testreg->MegaTests->test_name }}</td>
@elseif($testreg->grouptest_id)
<td>{{ $testreg->GroupTests->test_name }}</td>
@elseif($testreg->test_id)
<td>{{ $testreg->TestData->abbrev }}</td>
@endif

<td>{{ $testreg->Users->user_name }}</td>
<td>{{ $testreg->registered }}</td>

</tr>
@endforeach
</tbody>
</table>
</div>
</div>

</body>
</html>