<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Result Entry)</title>
<style>   
Body {  
  font-family:  serif !important;  
  background-color: lightgrey ;  
}  
button {   
        font-family:  serif;
        background-color: grey;   
        width: 10%;  
        color: Black;   
        padding: 5px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
        /* border: 1px solid #f1f1f1;    */
    }   
 input[type=text] {   
        font-family:  serif;     
        width: 10%;   
        margin: 0px 0px;  
        padding: 3px 2px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
        text-align: center;

    }
    
    select {
    width: 100%;  
    margin: 0px 0px;  
    padding: 3px 2px;    
    cursor:pointer;
    display:inline-block;
    position:relative;
    font:normal 11px/22px  Serif;
    color:black;
    border:1px solid #ccc;
}  

    label {   
        font-family:  serif;  
        width: 10%;   
        margin: 0px 0;  
        padding: 3px 2px;  
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box; 
        text-align: left; 
    }  
 button:hover {   
        opacity: 0.7;   
    }   
    
        
     
 .container {   
        padding: 0px;  
        margin: 0px 0;  
    }   

    #table-wrapper {
  position:relative;

}
#table-scroll {
  height:380px;
  overflow:auto;  
  margin-top:20px;

}
#table-wrapper table {
  width:100%;
  font-size:12px;
  font-weight:bold;
  margin:auto;

}
#table-wrapper table * {
  background:white;
  color:black;
  font-weight: bold;
  margin:auto;
  border: none;
}
#table-wrapper table thead th .text {
  position:absolute;   
  top:-20px;
  z-index:2;
  height:20px;
  width:35%;
  /* border:1px solid red; */
  line-height:10px
}
#table-wrapper table  th {
  top:0;
  position: sticky;
}

#myInput {
  width: 30%;
  font-size: 14px;
  padding: 10px 15px 10px 20px;
  border: 1px solid #ddd;
  margin-bottom: 10px;
}

/* #myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
  font-family: times_new_roman, Helvetica, sans-serif; 
  margin-bottom: 10px; 
} */

</style>  
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 
<script src="{{asset('JS/bootstrap.min.js')}}" ></script> 

</head>
@include('MainMenu')
<body >
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


@if($users[0]->megatest_id)
<form action = "{{url('editresultentry',[$users[0]->regkey, $users[0]->TestData->test_group, $users[0]->MegaTests->megatest_id, $users[0]->seperate_test])}}" method = "post" >
@else
<form action = "{{url('editresultentry',[$users[0]->regkey, $users[0]->TestData->test_group, $users[0]->seperate_test])}}" method = "post" >
@endif
    {{ method_field('post') }}
    {{ csrf_field() }}

 <center>
<table  id="myTable0" border = "1">
<tr class="header">
<th style="color:red;padding: 0px;font-size: 12px;"> Patient ID </th>
<th style="color:red;padding: 0px;font-size: 12px;"> Visit No.</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Patient Name</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Req Date</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Gender</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Age</th>
</tr>
<tr>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $users[0]->PatientReg->patient_id }}</td>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $users[0]->PatientReg->visit_no }}</td>
<td style="padding: 0px;font-size: 12px;font-weight:bold;width:35%">{{ $users[0]->PatientReg->patient_name }}</td>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{Carbon\Carbon::parse($users[0]->PatientReg->req_date)->format('Y-m-d g:i A')}} </td>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $users[0]->PatientReg->gender }} </td>
<td style="padding: 0px;font-size: 12px;font-weight:bold"> 
@if ($users[0]->PatientReg->age_y > 0)
{{ $users[0]->PatientReg->age_y }} Years
@elseif ( $users[0]->PatientReg->age_y == 0 && $users[0]->PatientReg->age_m > 0 )
{{ $users[0]->PatientReg->age_m }} Months
@elseif ( $users[0]->PatientReg->age_y == 0 && $users[0]->PatientReg->age_m == 0 && $users[0]->PatientReg->age_d > 0 )
{{ $users[0]->PatientReg->age_d }} Days
@endif
</td>
</tr>
</table>
<center> <h1   style="font-size:20px;"> Result Entry </h1> </center>   

</center>
<center>

    <td><input  type="submit" value="Save All"/> </td>
  

    @if($users[0]->megatest_id)
    <input  type="button" value="PDF" onclick="verifiedCheckMegaPDF()"></input>
    @else
    <input  type="button" value="PDF" onclick="verifiedCheckGroupPDF()"></input>
    @endif


    @if($users[0]->megatest_id)
    <input  type="button" value="Verify" onclick="completedCheckMega()"></input>
    @else
    <input  type="button" value="Verify" onclick="completedCheckGroup()"></input>
    @endif
    
    @if($users[0]->megatest_id)
    <input type="button" value="Preview" onclick="verifiedCheckMegaPreview()"></input>
    @else
    <input  type="button" value="Preview" onclick="verifiedCheckGroupPreview()"></input>
    @endif

    @if($users[0]->megatest_id)
    <input type="button" value="Print Current Result" onclick="verifiedCheckMegaPrint()"></input>
    @else
    <input  type="button" value="Print Current Result" onclick="verifiedCheckGroupPrint()"></input>
    @endif
</center>
<br>
<center> <b    style="background-color:lightblue;"> {{ $users[0]->TestData->Groups->group_name }} </b> </center>   
@if($users[0]->megatest_id)
<center> <b    style="background-color:lightblue;"> {{$users[0]->MegaTests->test_name }} </b> </center>   
@endif
    <div id="table-wrapper">
  <div id="table-scroll">
  <table id="myTable">
<thead>
    <tr>

<th></th>
<th></th>
<th>Test Name</th>
<th>Result</th>
<th>Unit</th>
<th>From</th>
<th>To</th>
<th>N.N Normal Range</th>
<th>Flag</th>
<th>Result Comment</th>
<th>Visible</th>
<th>Seperate Test</th>
<th>Test Status</th>
<th>RT</th>
<th>Test Parameters</th>
</tr>
@foreach ($users as $user)
<tr>
<td><input class="actives" id="active-{{$user->result_id}}" style="width:50px;"  type="hidden" name="active[{{$user->result_id}}]" value="{{ $user->TestData->active }}"></td>
<td><input id="test_id-{{$user->result_id}}" style="width:30px;"  type="hidden" name="test_id[{{$user->result_id}}]" value="{{ $user->test_id }}"></td>
<td>{{ $user->TestData->abbrev }}</td>
@if(Auth::user()->hasPermissionTo(1))
<td><input class="results" id="result-{{$user->result_id}}" onchange='check({{$user->result_id}})' style="width:200px;font-size:12px"  type="string" name="result[{{$user->result_id}}]" value="{{ $user->result }}" {{ $user->TestData->calculated? "readonly":"" }}></td>
@else
<td><input readonly="readonly" class="results" id="result-{{$user->result_id}}" onchange='check({{$user->result_id}})' style="width:200px;font-size:12px"  type="string" name="result[{{$user->result_id}}]" value="{{ $user->result }}" {{ $user->TestData->calculated? "readonly":"" }}></td>
@endif
<td><input tabindex="-1" style="width:100px;font-size:12px"   type="string" name="unit[{{$user->result_id}}]" value="{{ $user->unit }}"></td>
<td><input tabindex="-1" id="low-{{$user->result_id}}" onchange='check({{$user->result_id}})' style="width:80px;"    type="number" step="any" name="low[{{$user->result_id}}]" value="{{ $user->low }}"></td>
<td><input tabindex="-1" id="high-{{$user->result_id}}" onchange='check({{$user->result_id}})' style="width:80px;"    type="number" step="any" name="high[{{$user->result_id}}]" value="{{ $user->high }}"></td>
<td><textarea tabindex="-1" style="height:20;width:150px;"   name="nn_normal[{{$user->result_id}}]" >{{ $user->nn_normal }}</textarea></td>
<td><input tabindex="-1" id="flag-{{$user->result_id}}" style="width:100px;"  type="string" name="flag[{{$user->result_id}}]" value="{{ $user->flag }}"> </td>
<td><textarea tabindex="-1" style="width:100px;"   type="string" name="result_comment[{{$user->result_id}}]"> {{ $user->result_comment }} </textarea></td>
<td><input tabindex="-1" style="width:30px;" value="1"   type="checkbox" name="report_printed[{{$user->result_id}}]" {{ $user->report_printed==1 ? "checked":"" }}></td>
<td><input tabindex="-1" id="seperate_test-{{$user->result_id}}" style="width:30px;" type="checkbox" onchange="checkchild({{$user->result_id}})" name="seperate_test[{{$user->result_id}}]" {{ $user->seperate_test? "checked":"" }}></td>


    @if($user->verified )
    <td>Verified</td>
    @elseif($user->completed )
    <td>Completed</td>
    @else
    <td>Ordered</td>
    @endif

<td><a tabindex="-1" href = '' data-toggle="modal" class="ls-modal" data-target="#rt-modal-{{$user->result_id}}" data-remote="{{url('resulttracking/'.($user->result_id))}}">RT</a></td>
<td><a tabindex="-1" href = "{{url('testparameters/'.($user->test_id) ,( $user->result_id) )}}" target="_blank">Test Parameters</a></td>
@if($user->TestData->culture_link)
<td><a style="font-size:8px" tabindex="-1" href = "{{url('antibioticentry/'.( $user->regkey),( $user->TestData->culture_link))}}" target="_blank">Antibiotics Entry</a></td>
@endif
<td><input tabindex="-1" type="hidden" id="completed" class="completes" style="width:30px;"  type="number" name="completed[{{$user->result_id}}]" value="{{ $user->completed }}"></td>
<td><input tabindex="-1" type="hidden" id="verified"  class="verifies"  style="width:30px;"  type="number" name="verified[{{$user->result_id}}]"  value="{{ $user->verified }}"></td>
<td><input tabindex="-1" type="hidden" id="megatest_id"  class="megatestids"  style="width:30px;"  type="number" name="megatest_id[{{$user->result_id}}]"  value="{{ $user->megatest_id }}"></td>

<div class="modal " data-remote="{{url('resulttracking/'.($user->result_id))}}" id="rt-modal-{{$user->result_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
    </div>
  </div>
</div>


<div class="modal " data-remote="{{url('report/'.($users[0]->regkey),($users[0]->subgroup))}}" id="rt-modal-{{$users[0]->regkey}}-{{$users[0]->subgroup}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
    </div>
  </div>
</div>

</form>
<script>
$('#rt-modal-{{$user->result_id}}').on('show.bs.modal', function (e) {
  console.log(this);

    var loadurl = $(this).data('remote');
    console.log($(this).find('.modal-body'));
    $(this).find('.modal-body').load(loadurl);
});
</script>
</tr>
</thead>
</tbody>
@endforeach
</table>
</div>
</div>
<table style="float:left;width:50%;">
<th style="text-align:left;background-color:white;font-size:13px;">Comment</th>
@if($CommentCheck)
@foreach ($ResultComment as $comment)
<tr>
<td style="text-align:left;background-color:white;font-size:13px;font-weight:bold;">{{ $comment->result_comment }}</td>
</tr>
@endforeach
@endif
</table>
</div>
<script>

function check(result_id){
  console.log(result_id);
 var resultvalue = $('#result-'+result_id).val();
 var resultcheck = $('#resultcheck-'+result_id);

resultvalue = resultvalue.replace(/[^0-9.]/g, '');
resultvalue = parseFloat(resultvalue);
// resultvalue = resultvalue.join("")
var low         = $('#low-'+result_id).val();
var high        = $('#high-'+result_id).val();
var flag        = $('#flag-'+result_id);
console.log(resultvalue);

if (low !='' && resultvalue<low){
flag.val('L') 
var myResult = document.getElementById("result-"+result_id); 
console.log(myResult);
myResult.style.backgroundColor = "pink";
 }
if (high !='' && resultvalue>high){
  console.log(high);
flag.val('H') 
var myResult = document.getElementById("result-"+result_id); 
console.log(myResult); 
myResult.style.backgroundColor = "red";

}
if (resultvalue>=low && resultvalue<=high){
flag.val('') 
var myResult = document.getElementById("result-"+result_id); 
console.log(myResult); 
myResult.style.backgroundColor = "";

} 
if (!resultvalue){
flag.val('') 
var myResult = document.getElementById("result-"+result_id); 
console.log(myResult); 
myResult.style.backgroundColor = "";

}
resultcheck.val('1');

}
// $('.ls-modal').on('click', function(e){
//   e.preventDefault();
//   console.log($('#rt-modal-{{$user->test_id}}'));
//   $('#rt-modal-{{$user->test_id}}').modal('show').find('.modal-body').load($(this).attr('data-remote'));
// });
// $('#rt-modal-{{$user->result_id}}').on('show.bs.modal', function (e) {
//   console.log(this);

//     var loadurl = $(this).data('remote');
//     console.log($(this).find('.modal-body'));
//     $(this).find('.modal-body').load(loadurl);
// });
</script>




<script>
function myFunction() {
  alert("I am an alert box!");
}

function completedCheckGroup(){
  console.log($('.completes'));

var completed = 0;
$('.completes').each(function(i,complete){
  console.log(complete);
completed = completed + parseInt($(complete).val());
});
var megatestid = 0;
$('.megatestids').each(function(i,mega){
  console.log(mega);
  megatestid = megatestid + parseInt($(mega).val());
});

console.log(completed);
console.log(megatest_id);

  if (completed == 0)
  {
  alert ("{{__('title.results_not_completed')}}");
  }else{
    window.location = "{{url('verifyresultentry',[$users[0]->regkey,$users[0]->TestData->test_group,$users[0]->seperate_test])}}";
  }
}

function completedCheckMega(){
  console.log($('.completes'));
  
var megatestid     = $('.megatestids').last().val();

console.log(completed);
console.log(megatestid);

var completed = 0;
$('.completes').each(function(i,complete){
  console.log(complete);
completed = completed + parseInt($(complete).val());
});
console.log(completed);

  if (completed == 0)
  {
  alert ("{{__('title.results_not_completed')}}");
  }else{
    window.location = "{{url('verifyresultentry',[$users[0]->regkey,$users[0]->TestData->test_group])}}/" + megatestid + "/url($users[0]->seperate_test)}}";
  }
}




function verifiedCheckGroupPrint(){
  
  console.log($('.verifies'));

var verified = 0;
$('.verifies').each(function(i,verify){
  console.log(verify);
verified = verified + parseInt($(verify).val());
});
console.log(verified);

  if (verified == 0)
  {
  alert ("{{__('title.results_not_verified')}}");
  }else{
      var page     = "{{url('report',[$users[0]->regkey,$users[0]->TestData->test_group,$users[0]->seperate_test])}}";
      var myWindow = window.open(page, "_blank", "scrollbars=yes,width=800,height=800,top=300"); myWindow.print();
         // focus on the popup //
         myWindow.focus();
         myWindow.onafterprint = myWindow.close;
    // window.location = "{{url('report/'.($users[0]->regkey),($users[0]->subgroup))}}"
  }
}

function verifiedCheckMegaPrint(){
  
  console.log($('.verifies'));
var megatestid     = $('.megatestids').last().val();

var verified = 0;
$('.verifies').each(function(i,verify){
  console.log(verify);
verified = verified + parseInt($(verify).val());
});
console.log(verified);

  if (verified == 0)
  {
  alert ("{{__('title.results_not_verified')}}");
  }else{
      var page     = "{{url('report',[$users[0]->regkey,$users[0]->TestData->test_group])}}/" + megatestid + "/url($users[0]->seperate_test)}}";
      var myWindow = window.open(page, "_blank", "scrollbars=yes,width=800,height=800,top=300"); myWindow.print();
         // focus on the popup //
         myWindow.focus();
         myWindow.onafterprint = myWindow.close;
    // window.location = "{{url('report/'.($users[0]->regkey),($users[0]->subgroup))}}"
  }
}


function verifiedCheckGroupPreview(){
  
  console.log($('.verifies'));

var verified = 0;
$('.verifies').each(function(i,verify){
  console.log(verify);
verified = verified + parseInt($(verify).val());
});
console.log(verified);

  if (verified == 0)
  {
  alert ("{{__('title.results_not_verified')}}");
  }else{
      var page     = "{{url('report',[$users[0]->regkey,$users[0]->TestData->test_group,$users[0]->seperate_test])}}";
      var myWindow = window.open(page, "_blank", "scrollbars=yes,width=800,height=800,top=300");
         // focus on the popup //
         myWindow.focus();
    // window.location = "{{url('report/'.($users[0]->regkey),($users[0]->subgroup))}}"
  }
}

function verifiedCheckGroupPDF(){
  
  console.log($('.verifies'));

var verified = 0;
$('.verifies').each(function(i,verify){
  console.log(verify);
verified = verified + parseInt($(verify).val());
});
console.log(verified);

  if (verified == 0)
  {
  alert ("{{__('title.results_not_verified')}}");
  }else{
      var page     = "{{url('reportPDF',[$users[0]->regkey,$users[0]->TestData->test_group,$users[0]->seperate_test])}}";
      var myWindow = window.open(page, "_blank", "scrollbars=yes,width=800,height=800,top=300");
         // focus on the popup //
         myWindow.focus();
    // window.location = "{{url('report/'.($users[0]->regkey),($users[0]->subgroup))}}"
  }
}

function verifiedCheckMegaPreview(){
  
  console.log($('.verifies'));
var megatestid     = $('.megatestids').last().val();

var verified = 0;
$('.verifies').each(function(i,verify){
  console.log(verify);
verified = verified + parseInt($(verify).val());
});
console.log(verified);

  if (verified == 0)
  {
  alert ("{{__('title.results_not_verified')}}");
  }else{
      var page     = "{{url('report',[$users[0]->regkey,$users[0]->TestData->test_group])}}/" + megatestid + "/url($users[0]->seperate_test)}}";
      var myWindow = window.open(page, "_blank", "scrollbars=yes,width=800,height=800,top=300");
         // focus on the popup //
         myWindow.focus();
    // window.location = "{{url('report/'.($users[0]->regkey),($users[0]->subgroup))}}"
  }
}

function verifiedCheckMegaPDF(){
  
  console.log($('.verifies'));
var megatestid     = $('.megatestids').last().val();

var verified = 0;
$('.verifies').each(function(i,verify){
  console.log(verify);
verified = verified + parseInt($(verify).val());
});
console.log(verified);

  if (verified == 0)
  {
  alert ("{{__('title.results_not_verified')}}");
  }else{
      var page     = "{{url('reportPDF',[$users[0]->regkey,$users[0]->TestData->test_group])}}/" + megatestid + "/url($users[0]->seperate_test)}}";
      var myWindow = window.open(page, "_blank", "scrollbars=yes,width=800,height=800,top=300");
         // focus on the popup //
         myWindow.focus();
    // window.location = "{{url('report/'.($users[0]->regkey),($users[0]->subgroup))}}"
  }
}

</script>
<script>
function checkchild(result_id){
  console.log(result_id);
 var ParentTest   = $('#active-'+result_id).val();
 var SeperateTest = document.getElementById("seperate_test-"+result_id).checked; 
;

console.log(ParentTest);
console.log(SeperateTest);
if (ParentTest == 0){
alert ("{{__('title.cannot_seperate_inactive_test')}}");
  document.getElementById("seperate_test-"+result_id).checked = false; 
  }else{
    if(SeperateTest == 1){
    document.getElementById("seperate_test-"+result_id).checked = true; 

    }else{
    document.getElementById("seperate_test-"+result_id).checked = false; 
  }}
}
</script>



</body>
</html>



