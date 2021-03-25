<!DOCTPE html>
<html>
<head>
<title>Results Printing Trial</title>

<link rel="stylesheet" type="text/css" href="{{asset('/css/Report.css')}}"> 

</head>
<body>
<br>
<br>
<br>
<br>
<br>
<br>
<hr>
<div class="col-sm-6">
<div class="col-sm-6">
Patient ID
</div>
<div class="col-sm-6">
{{$patient->patient_id}}
</div>
<div class="col-sm-6">
Visit Number
</div>
<div class="col-sm-6">
{{$patient->visit_no}}
</div>
<div class="col-sm-6">
Patient Name
</div>
<div class="col-sm-6">
  {{$patient->title_id? $patient->title." / ":"" }} {{$patient->patient_name}}
</div>
<div class="col-sm-6">
Refered By
</div>
<div class="col-sm-6">
{{$patient->doctor_id? $patient->doctor_name: ""}}
</div>
</div>

<div class="col-sm-6">
<div class="col-sm-6">
Request Date
</div>
<div class="col-sm-6">
{{Carbon\Carbon::parse($patient->req_date)->format('Y-m-d g:i A')}}
</div>
<div class="col-sm-6">
Gender
</div>
<div class="col-sm-6">
{{$patient->gender}}
</div>
<div class="col-sm-6">
Age
</div>
<div class="col-sm-6">
{{$patient->ag}} / {{$patient->age}}
</div>
<div class="col-sm-6">
Reporting Date
</div>
<div class="col-sm-6">
{{Carbon\Carbon::now()->format('Y-m-d g:i A')}}
</div>
</div>
<hr>
<div class="header">
  <center><h1 style="font-family:serif;font-size:23" >{{$Results[0]->group_name}}</h1></center>
  <center><b style="font-family:serif;font-size:18">{{$Results[0]->subgroup_name}}</b></center>


</div>

<!-- <div class="passcodeGrid">
      <div class="passcodeCell"></div>
    </div> -->

<table class="printTable">
  <!-- <tr class="titleTr">
    <td class="titleTd" colspan=2>Change body {font-size} to adjust scale</td>
    <td class="titleTd col4" colspan=2>Reporting Period</td>
  </tr>
  <tr class="subtitleTr">
    <td class="titleTd col1" colspan=2>Homer Simpson Jr.</td>
    <td class="titleTd col4" colspan=2>February 2015 - April 2016</td>
  </tr> -->

  <tr></tr>

  <tr class="headingTr">
    <td class="headingTd col1">Test Name</td>
    <td class="headingTd col2">Result</td>
    <td class="headingTd col4"></td>
    <td class="headingTd col3">Unit</td>
   
    <td class="headingTd col5">Reference Range</td>
    
  </tr>

  
  @foreach($Results as $testresult)
  <tr class="bordernone">
    <td class="col1">{{$testresult->report_name}}</td>
    <td class="col2" >{{$testresult->result}}</td>
    <td class="col4">{{$testresult->flag}}</td>
    <td class="col3">{{$testresult->unit}}</td>
  
    @if($testresult->nn_normal )
    <td class="col5">{!! $testresult->nn_normal !!}</td>
    @elseif($testresult->low && $testresult->high)
    <td class="col5">{{$testresult->low}}   -   {{$testresult->high}}</td>
    @else
    <td class="col5"></td>
    @endif
  </tr>
  @endforeach

  
</table>


<div class="footer">
  
</div>
</body>
</from>