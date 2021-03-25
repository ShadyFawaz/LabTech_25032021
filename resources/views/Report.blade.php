<!DOCTPE html>
<html>
<head>
<title>Report</title>

<link rel="stylesheet" type="text/css" href="{{asset('/css/Report.css')}}"> 

</head>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<hr>
<div class="Header">
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
@if ($patient->age_y > 0)
{{ $patient->age_y }} / Years
@elseif ( $patient->age_y == 0 && $patient->age_m > 0 )
{{ $patient->age_m }} / Months
@elseif ( $patient->age_y == 0 && $patient->age_m == 0 && $patient->age_d > 0 )
{{ $patient->age_d }} / Days
@endif
</div>
<div class="col-sm-6">
Reporting Date
</div>
<div class="col-sm-6">
{{Carbon\Carbon::now()->format('Y-m-d g:i A')}}
</div>
</div>

</head>
<br>
<hr>
<body  >
<div class="header">
  <center><h1 style="font-family:serif;font-size:20;padding-top:10px;" >{{$groupName}}</h1></center>
  @if($meganame)
  <center><b style="font-family:serif;font-size:16">{{$meganame}}</b></center>
  @endif
 
</div>
</div>
    <br>
    <br>
    <br>
    <br>
    <br>
  <br>
  @if($meganame)
<br>
  @endif
    <div>
<table class="printTable">
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
      @if($result['flag'])
      <td class="col2" ><mark>{{$result['result']}}</mark></td>
      @else
      <td class="col2">{{$result['result']}}</td>
      @endif
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

    @if($testresults['flag'])
      <td class="col2" ><mark>{{$testresults['result']}}</mark></td>
      @else
      <td class="col2">{{$testresults['result']}}</td>
      @endif

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
    @if($testresult['flag'])
      <td class="col2" ><mark>{{$testresult['result']}}</mark></td>
      @else
      <td class="col2">{{$testresult['result']}}</td>
      @endif
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
    @if($testresult['flag'])
      <td class="col2"  ><mark>{{$testresult['result']}}<mark></td>
      @else
      <td class="col2">{{$testresult['result']}}</td>
      @endif

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

@if($CommentCheck)
<table style="float:left;">
<th style="float:left;">Comment</th>
@foreach ($ResultComment as $result)
<tr>
<td>{!! nl2br(e($result->result_comment)) !!}</td>
</tr>
@endforeach

@endif
</table>
</div>
<div class="Footer" >Doctor Sig.</div>

 <!-- <p> Doctor Sig. </p>
</div>
</body>
<script type="text/javascript">
// window.print();
// setTimeout(window.close, 10);

// window.onafterprint = window.close;
// window.print();
</script>
</form>