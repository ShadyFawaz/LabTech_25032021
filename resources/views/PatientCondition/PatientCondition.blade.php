<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Patient Condition) </title>  
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
}  
 
 form {   
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
    }
    input[type=button] {   
     color:black;
    }
    select {
    width: 10%;  
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
  height:390px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:40%;
  font-size:12px;
  font-weight:bold;
  /* margin:auto; */
  line-height:24px;
}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  /* font-weight:bold; */
}
#table-wrapper table  th {
  top:0;
  position: sticky;
}
</style>   
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(82))
@else
<script>
alert ('You cannot access this page');
window.location = "{{url('home')}}";
</script>
@endif  
@endif
</head> 
@if(isset(Auth::user()->login_name))
@include('MainMenu') 
@endif  
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
    
    <center> <h1 > {{__('title.patient_condition_all')}} </h1> </center>   
<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
    <thead>
        <tr>
<td><b> Patient Condition ID </b></td>
<td><b> {{__('title.patient_condition')}} </b></td>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->patientcondition_id }}</td>
<td>{{ $user->patient_condition }}</td>
@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(84))
<td><input type="button" onclick="editpatientcondition({{$user->patientcondition_id}})" value="{{__('title.edit_btn')}}" ></input></td>
@endif
@endif
@endif


@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(85))
<td><input type="button" onclick="deletepatientcondition({{$user->patientcondition_id}})" value="{{__('title.delete_btn')}}" ></input></td>
@endif
@endif
@else
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(85))
<td><input type="button" onclick="restorepatientcondition({{$user->patientcondition_id}})" value="{{__('title.restore_btn')}}" ></input></td>
@endif
@endif
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

<a>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(83))
<input type="button" onclick="location.href='{{url('newpatientcondition')}}'" value="{{__('title.create_new_patient_condition')}}" ></input></a>
@endif
@endif
<div>  
<a>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(85))
<input type="button" onclick="location.href='{{url('trashedpatientcondition')}}'" value="{{__('title.trashed_patient_condition')}}" ></input></a>
@endif
@endif
</body> 
<script>
  function editpatientcondition(patientcondition_id){
    console.log(patientcondition_id);
    window.location = "{{url('editpatientcondition/')}}"+'/'+patientcondition_id;
}
function deletepatientcondition(patientcondition_id){
  console.log(patientcondition_id);
  var deletepatientcondition = confirm("Want to delete ?");
  if (deletepatientcondition){
    window.location = "{{url('deletepatientcondition/')}}"+'/'+patientcondition_id;
  }
}
function restorepatientcondition(patientcondition_id){
  var restorepatientcondition = confirm("Want to restore ?");
  if (restorepatientcondition){
    window.location = "{{url('restorepatientcondition/')}}"+'/'+patientcondition_id;
  }
}
  </script> 

</html>  