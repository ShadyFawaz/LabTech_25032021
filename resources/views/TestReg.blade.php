<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Patient Tests)</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  
  

 input[type=text] {   
        font-family:\ serif;     
        width: 10%;   
        margin: 0px 0px;  
        padding: 3px 2px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }
    input[type=button] {   
 color:black;
 line-height:15px;
    }
    select {
    width: 100%;  
    margin: 0px 0px;  
    padding: 3px 2px;    
    cursor:pointer;
    display:inline-block;
    position:relative;
    font:normal 11px/22px Serif;
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
  height:250px;
  overflow:auto;  
  margin-top:20px;

}
#table-wrapper table {
  width:50%;
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
  font-family: times_new_roman, serif; 
  margin-bottom: 10px; 
} */

</style>  

</head>
@if(isset(Auth::user()->login_name))
@else
<script>window.location = "{{url('/')}}";</script>
@endif 

@if(isset(Auth::user()->login_name))
@include('MainMenu')
@endif
<body>
<center> <h1 > {{__('title.patienttests_testreg')}} </h1> </center>  
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
<form action = "{{url('/updatetestreg/'.($regkey))}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    <center><b><input type="submit" value="{{__('title.save_btn')}}" ></b></center>


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
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $PatientID }}</td>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $VisitNo }}</td>
<td style="padding: 0px;font-size: 12px;font-weight:bold;width:35%">{{ $PatientName }}</td>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{Carbon\Carbon::parse($ReqDate)->format('Y-m-d g:i A')}} </td>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $Gender }} </td>
<td style="padding: 0px;font-size: 12px;font-weight:bold"> 
@if ($Age_Y > 0)
{{ $Age_Y }} / Years
@elseif ( $Age_Y == 0 && $Age_M > 0 )
{{ $Age_M }} / Months
@elseif ( $Age_Y == 0 && $Age_M == 0 && $Age_D > 0 )
{{ $Age_D }} / Days
@endif
</td>
</tr>
</table>
<br>
<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
<thead>
<tr>
<th></th>
<th>{{__('title.testname_testreg')}}</th>
<th>{{__('title.patientload_testreg')}}</th>
<th>{{__('title.insuranceload_testreg')}}</th>
<th>{{__('title.outlab_testreg')}}</th>
<th>{{__('title.outlabname_testreg')}}</th>
<th>{{__('title.outlabfees_testreg')}}</th>


</tr>
</thead>
<tbody>
<tr>
@foreach ($users as $user)
<tr>
<td><input hidden  name="testreg_id[{{$user->testreg_id}}]" value="{{ $user->testreg_id }}"></td>
@if($user->megatest_id )
    <td>{{ $user->MegaTests->test_name }}</td>
    @elseif($user->grouptest_id )
    <td>{{ $user->GroupTests->test_name }}</td>
    @elseif($user->test_id )
    <td>{{ $user->TestData->abbrev }}</td>
    @endif
<td>{{ $user->patient_fees }}</td>
<td>{{ $user->insurance_fees }}</td>
<td><input  type="checkbox"  name="outlab[{{$user->testreg_id}}]" value="1"  {{ $user->outlab==1 ? "checked":"" }} ></td>
<td>
<select name="outlab_id[{{$user->testreg_id}}]">
<option value=""></option>
    @foreach($OutLabs as $outlab)
    <option value="{{$outlab->outlab_id}}" {{ $user->outlab_id==$outlab->outlab_id? "selected" :""}}>{{$outlab->out_lab}}</option>
    @endforeach
    </select>
 </td>
 <td><input  type="number" min="0" step="1"   name="outlab_fees[{{$user->testreg_id}}]"   value="{{ $user->outlab_fees }}"></td>

@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(119))
<td><input style="background-color:red;" type="button" onclick="deletetest({{$user->testreg_id}})" value="{{__('title.delete_testreg_btn')}}" ></input></td>
@endif
@endif
@endif

@if($user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(119))
<td><input style="background-color:yellow;" type="button" onclick="restoretest({{$user->testreg_id}})" value="{{__('title.restore_testreg_btn')}}" ></input></td>
@endif
@endif
@endif
</tr>

</tr>
@endforeach
</tbody>
</table>
</div>
</div>

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(117))
<a><input type="button" onclick="location.href='{{url('testnotreg/'.($user->regkey)) }}'" value="{{__('title.addtests_regtests')}}" ></input></a>
@endif
@endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(119))
<a><input type="button" onclick="location.href='{{url('trashedregtests/'.($user->regkey)) }}'" value="{{__('title.trashed_regtests')}}" ></input></a>
@endif
@endif


<input  type="button" value="{{__('title.reset_regtests')}}" onclick="receipt()"></input>


<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

<script>

function deletetest(testreg_id){
  console.log(testreg_id);
  var deletetest = confirm("Want to delete ?");
  if (deletetest){
    window.location = "{{url('deletepatienttest/')}}"+'/'+testreg_id;
  }
}
function restoretest(testreg_id){
  var restoretest = confirm("Want to restore ?");
  if (restoretest){
    window.location = "{{url('restorepatienttest/')}}"+'/'+testreg_id;
  }
}


function receipt(){
      var page     = "{{url('patientreset',[$regkey])}}";
      var myWindow = window.open(page, "_blank", "scrollbars=yes,width=800,height=800,top=300");
         // focus on the popup //
         myWindow.focus();
  }




  </script>
  </body>
  </form>
</html>