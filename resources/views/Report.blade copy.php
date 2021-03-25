<!DOCTPE html>
<html>
<head>
<title>LabTech Software</title>

<link rel="stylesheet" type="text/css" href="{{asset('/css/Report.css')}}"> 

</head>
<body >
<br>
<br>
<br>
<br>
<br>
<br>
<hr>
<!-- <div class="print-header"> -->
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
  {{$patient->title_id? $patient->Titles->title." / ":"" }} {{$patient->patient_name}}
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
  <center><h1 style="font-family:serif;font-size:23" >{{$groupName}}</h1></center>
  <center><b style="font-family:serif;font-size:18">{{$subgroupName}}</b></center>


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
  <tr>
  </tr>
<!-- </div> -->
  @if(count($Results) != count($Results,COUNT_RECURSIVE))
  @foreach($Results as $profile => $testresults)
  @if(is_string($profile))
 <tr class="sectionTr">
    <td class="sectionTd profile col1" colspan="5">
      <span>{{$profile}}</span>
    </td>
  </tr>
  @endif
  @if(is_countable($testresults) && count($testresults) != count($testresults,COUNT_RECURSIVE))
  
    @foreach($testresults as $test_header => $results)
    @if(is_string($test_header))
    <tr class="sectionTr">
    <td class="sectionTd test-header col1" >{{$test_header}}</td>
    <td class="col2"></td>
    <td class="col3"></td>
    <td class="col4"></td>
    <td class="col5"></td>
    </tr>
    @endif
    @foreach($results as $result)
    <tr class="bordernone">
      <td class="col1">{{$result['TestData']->report_name}}</td>
      <td class="col2" >{{$result['result']}}</td>
      <td class="col4">{{$result['flag']}}</td>
      <td class="col3">{{$result['unit']}}</td>
    
      @if($result['nn_normal'])
      <td class="col5">{!! $result->nn_normal !!}</td>
      @elseif($result['low'] && $result['high'])
      <td class="col5">{{$result['low']}}   -   {{$result['high']}}</td>
      @else
      <td class="col5"></td>
      @endif
    </tr>
    @endforeach
    @endforeach  
  @elseif(is_object($testresults))
  <tr class="bordernone">
    <td class="col1">{{$testresults->TestData->report_name}}</td>
    <td class="col2" >{{$testresults['result']}}</td>
    <td class="col4">{{$testresults['flag']}}</td>
    <td class="col3">{{$testresults['unit']}}</td>
  
    @if($testresults['nn_normal'])
    <td class="col5">{!! $testresults->nn_normal !!}</td>
    @elseif($testresults['low'] && $testresults['high'])
    <td class="col5">{{$testresults['low']}}   -   {{$testresults['high']}}</td>
    @else
    <td class="col5"></td>
    @endif
  </tr>
  @else
  @if(is_countable($testresults))
  @foreach($testresults as $testresult)
    <tr class="bordernone">
    <td class="col1">{{$testresult['TestData']->report_name}}</td>
    <td class="col2" >{{$testresult['result']}}</td>
    <td class="col4">{{$testresult['flag']}}</td>
    <td class="col3">{{$testresult['unit']}}</td>
  
    @if($testresult['nn_normal'])
    <td class="col5">{!! $testresult->nn_normal !!}</td>
    @elseif($testresult['low'] && $testresult['high'])
    <td class="col5">{{$testresult['low']}}   -   {{$testresult['high']}}</td>
    @else
    <td class="col5"></td>
    @endif
  </tr>
  @endforeach
  @endif 
  @endif
  @endforeach
  @else
  @foreach($Results as $testresult)
    <tr class="bordernone">
    <td class="col1">{{$testresult['TestData']->report_name}}</td>
    <td class="col2" >{{$testresult['result']}}</td>
    <td class="col4">{{$testresult['flag']}}</td>
    <td class="col3">{{$testresult['unit']}}</td>
  
    @if($testresult['nn_normal'])
    <td class="col5">{!! $testresult->nn_normal !!}</td>
    @elseif($testresult['low'] && $testresult['high'])
    <td class="col5">{{$testresult['low']}}   -   {{$testresult['high']}}</td>
    @else
    <td class="col5"></td>
    @endif
  </tr>
  @endforeach 
  @endif

</table>
<div style="padding-top: 20px">
@foreach($cultureMap as $key => $cultures)
<h4>Organism: {{$cultures['organism_name']}}</h4> 
@if(is_countable($cultures['sensitivities']) && count($cultures['sensitivities']) != count($cultures['sensitivities'],COUNT_RECURSIVE))
<div class="senstivity">
  @foreach($cultures['sensitivities'] as $sensitive => $antibiotics)
  <span>{{$sensitive}}</span>
    <ul>
      @foreach($antibiotics['antibiotics'] as $antibiotic)
      <li>{{$antibiotic}}</li>
      @endforeach
    </ul>
  @endforeach
</div>
@endif
@endforeach
</div>

<div class="footer" >
 <!-- <p> Doctor Sig. </p> -->
</div>
</body>
</from>