<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software </title>  
<style>   
Body {  
  font-family:serif;  
  background-color: lightgrey;  
}  
  
 form {   
    }   
 input[type=text] {   
        font-family: serif;     
        width: 50%;   
        margin: 0px 0px;  
        padding: 3px 2px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }
    select {
    width: 10%;  
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
  height:390px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:70%;

}
#table-wrapper table * {
  background:white;
  color:black;
}
#table-wrapper table thead th .text {
  position:absolute;   
  top:-20px;
  z-index:2;
  height:20px;
  width:35%;
  border:1px solid red;
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
</style>   
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(74))
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
    
    <center> <h1> {{__('title.diagnosis_all')}} </h1> </center>   
<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
    <thead>
        <tr>
<td><b> Diagnosis ID </b></td>
<td><b> {{__('title.diagnosis')}} </b></td>
<td><b> {{__('title.diagnosis_description')}} </b></td>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->diagnosis_id }}</td>
<td>{{ $user->diagnosis }}</td>
<td>{{ $user->description }}</td>
@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(76))
<td><input type="button" onclick="editdiagnosis({{$user->diagnosis_id}})" value="{{__('title.edit_btn')}}" ></input></td>
@endif
@endif
@endif


@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(77))
<td><input type="button" onclick="deletediagnosis({{$user->diagnosis_id}})" value="{{__('title.delete_btn')}}" ></input></td>
@endif
@endif
@else
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(77))
<td><input type="button" onclick="restorediagnosis({{$user->diagnosis_id}})" value="{{__('title.restore_btn')}}" ></input></td>
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
@if(Auth::user()->hasPermissionTo(75))
<input type="button" onclick="location.href='{{url('newdiagnosis')}}'" value="{{__('title.create_new_diagnosis')}}" ></input></a>
@endif
@endif
<div>  
<a>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(77))
<input type="button" onclick="location.href='{{url('trasheddiagnosis')}}'" value="{{__('title.trashed_diagnosis')}}" ></input></a>
@endif
@endif
</body> 
<script>
  function editdiagnosis(diagnosis_id){
    console.log(diagnosis_id);
    window.location = "{{url('editdiagnosis/')}}"+'/'+diagnosis_id;
}
function deletediagnosis(diagnosis_id){
  console.log(diagnosis_id);
  var deletediagnosis = confirm("Want to delete ?");
  if (deletediagnosis){
    window.location = "{{url('deletediagnosis/')}}"+'/'+diagnosis_id;
  }
}
function restorediagnosis(diagnosis_id){
  var restorediagnosis = confirm("Want to restore ?");
  if (restorediagnosis){
    window.location = "{{url('restorediagnosis/')}}"+'/'+diagnosis_id;
  }
}
  </script>
</html>  