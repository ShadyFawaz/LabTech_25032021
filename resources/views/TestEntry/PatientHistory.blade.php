<!DOCTPE html>
<html>
<head>
<title>Patient History</title>
<style>
.table-scroll {
	position:relative;
	width:80%;
	margin:auto;
	overflow:hidden;
	border:1px  #000;
  
}
.table-wrap {
	width:100%;
	overflow:auto;
  
}
.table-scroll table {
	width:100%;
	margin:auto;
	border-collapse:separate;
	/* border-spacing:0; */
  line-height: 7px;
    font-size: 14px;
}
.table-scroll th, .table-scroll td {
	padding:5px 10px;
	border:1px solid #000;
	background:#fff;
	white-space:nowrap;
	vertical-align:top;
}
.table-scroll thead, .table-scroll tfoot {
	background:#f9f9f9;
}
.clone {
	position:absolute;
	top:0;
	left:0;
	pointer-events:none;
}
.clone th, .clone td {
	visibility:hidden
}
.clone td, .clone th {
	border-color:transparent
}
.clone tbody th {
	visibility:visible;
	color:red;
}
.clone .fixed-side {
	border:1px solid #000;
	background:#eee;
	visibility:visible;
}
.clone thead, .clone tfoot{background:transparent;}
</style> 
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

</head>
@include('MainMenu')
<body>
@if (session('status'))
<div class="alert alert-success" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	{{ session('status') }}
</div>
@elseif(session('failed'))
<div class="alert alert-danger" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	{{ session('failed') }}
</div>
@endif

    {{ method_field('post') }}
    {{ csrf_field() }}

 <center>
<table  id="myTable0" border = "1">
<tr class="header">
<th style="color:red;padding: 0px;font-size: 12px;"> Patient ID </th>
<th style="color:red;padding: 0px;font-size: 12px;"> Patient Name</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Gender</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Age</th>
</tr>
<tr>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $PatientIDGet->PatientReg->patient_id }}</td>
<td style="padding: 0px;font-size: 12px;font-weight:bold;width:35%">{{ $PatientIDGet->PatientReg->patient_name }}</td>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $PatientIDGet->PatientReg->gender }} </td>
<td style="padding: 0px;font-size: 12px;font-weight:bold"> 
@if ($PatientIDGet->PatientReg->age_y > 0)
{{ $PatientIDGet->PatientReg->age_y }} Years
@elseif ( $PatientIDGet->PatientReg->age_y == 0 && $PatientIDGet->PatientReg->age_m > 0 )
{{ $PatientIDGet->PatientReg->age_m }} Months
@elseif ( $PatientIDGet->PatientReg->age_y == 0 && $PatientIDGet->PatientReg->age_m == 0 && $PatientIDGet->PatientReg->age_d > 0 )
{{ $PatientIDGet->PatientReg->age_d }} Days
@endif
</td>
</tr>
</table>
<center> <h1   style="font-size:20px;"> Patient History </h1> </center>   

</center>



<div id="table-scroll" class="table-scroll">
  <div class="table-wrap">
    <table class="main-table">
      <thead>
        <tr>
          <th class="fixed-side" scope="col">&nbsp;</th>
          @foreach ($PatientHistoryDate as $his)
          <th scope="col">{{$his->first()->PatientReg->req_date}}</th>
        @endforeach
        </tr>
      </thead>
      <tbody>
      @foreach ($PatientHistory as $history)
        <tr>
          <th class="fixed-side">{{$history->first()->TestData->abbrev}}</th>
        @foreach ($PatientHistoryDate as $hisdate)
		<th scope="col">{{$his->first()->PatientReg->req_date}}</th>

</th>


	    @endforeach
          </tr>
        @endforeach
        
     
    </table>
  </div>
</div>
</div>
</form>
</body>
<!-- <script>
// requires jquery library
jQuery(document).ready(function() {
   jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');   
 });
</script> -->
</html>