<!DOCTPE html>
<html>
<head>
<title>Complete Blood Count</title>

<link rel="stylesheet" type="text/css" href="{{asset('/css/Report.css')}}"> 
<style>
    .difftable {
        font: 12px/12px  Serif;
        border: none;
        width: auto;
        /* font-weight:bold; */

}
td, th {
  text-align: left;
  padding: 3px;
  margin: 3px;

  font:normal 15px/15px  Serif;
  width: auto;
  /* font-weight:bold; */
  border: none;

}
tr:nth-child(even) {
  background-color: white;
  /* font-weight:bold; */
  border: none;

}
</style>
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
</div>
<br>
<br>
    <br>
<br>
</head>
<hr>
<body >
<div class="Header">
<center><h1 style="font-family:serif;font-size:20;padding-top:10px;" >{{$groupName}}</h1></center>
  @if($meganame)
  <center><b style="font-family:serif;font-size:16">{{$meganame}}</b></center>
  @endif
  </div>
</div>
<br>
<br>
 <br>   
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
    @foreach($CBC as $result)
    <tr >
      <td class="col1">{{$result->TestData->report_name}}</td>
      @if($result['flag'])
      <td class="col2"  ><mark>{{$result['result']}}</mark></td>
      @else
      <td class="col2">{{$result['result']}}</td>
      @endif
      <td class="col4">{{$result->flag}}</td>
      <td class="col3">{{$result->unit}}</td>
    
      @if($result->nn_normal)
      <td class="col5">{!! $result->nn_normal !!}</td>
      @elseif($result->low && $result->high)
      <td class="col5">{{$result->low}}   -   {{$result->high}}</td>
      @else
      <td class="col5"></td>
      @endif
    </tr>
    @endforeach
    </table>
    </div>
    <div>
    </div>
    <br>
    <b style="font-size:18px;background-color:lightgrey;width:200%">Differential Leucocytic Count</b>

</div>
<div>
</div>
    <table class="difftable" style="float: left"  id="myTable" border = "1">
<tr >
<th style="width:50%;font-size:13px;font-weight:bold;background-color:lightgrey;">Test Name</th>
<th style="font-size:13px;font-weight:bold;background-color:lightgrey;">Relative</th>
<th style="width:8%;font-weight:bold"></th>
<th style="font-weight:bold"></th>
<th style="font-size:13px;font-weight:bold;width:25%;background-color:lightgrey;">Ref.Range</th>
</tr>
<tr>
@foreach ($Relative as $rel)
<td>{{ $rel->TestData->report_name }}</td>
@if($rel->flag)
<td style="text-align:center;font-weight:bold;"><mark>{{ $rel->result }}</mark></td>
@else
<td style="text-align:center;font-weight:bold;">{{ $rel->result }}</td>
@endif
<td>{{ $rel->flag }}</td>
<td style="text-align:center;font-size:10px;">{{ $rel->unit }}</td>
@if($rel->nn_normal)
      <td class="col5" style="font-size:10px;">{!! $rel->nn_normal !!}</td>
      @elseif($rel->low && $rel->high)
      <td class="col5" style="font-size:10px;">{{$rel->low}}   -   {{$rel->high}}</td>
      @else
      <td class="col5"></td>
      @endif
    </tr>
</td>
</tr>
@endforeach


</table>
<table  class="difftable" style="float: left"  id="PatientTable" border = "1">
<tr >
<th style="font-size:13px;font-weight:bold;background-color:lightgrey;">Absolute</th>
<th style="width:14%"></th>
<th style="font-weight:bold"></th>
<th style="font-size:13px;font-weight:bold;background-color:lightgrey;">Ref.Range</th>
</tr>
<tr>
@foreach ($Absolute as $abs)
@if($abs->flag)
<td style="text-align:center;font-weight:bold;"><mark>{{ $abs->result }}</mark></td>
@else
<td style="text-align:center;font-weight:bold;">{{ $abs->result }}</td>
@endif
<td>{{ $abs->flag }}</td>
<td style="font-size:10px;">{{ $abs->unit }}</td>
@if($abs->nn_normal)
      <td >{!! $abs->nn_normal !!}</td>
      @elseif($abs->low && $abs->high)
      <td >{{$abs->low}}   -   {{$abs->high}}</td>
      @else
      <td></td>
      @endif
    </tr>
</td>
</tr>
@endforeach
</table>
    <div>
    </div>
<br>
<br>
@if($CommentCheck)
<table style="float:left;">
<th style="text-decoration: underline;font-weight:bold;font-size:16px;background-color:lightgrey;float:left;">Comment :</th>
@foreach ($ResultComment as $result)
<tr>
<td style="font-weight:bold;font-size:14px;">
{!! nl2br(e($result->result_comment)) !!}
</td>
</tr>
@endforeach
</table>
@endif


<div class="Footer">Doctor Sig.</div>
 <!-- <p> Doctor Sig. </p> -->
</div>
</body>
</form>