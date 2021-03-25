<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Doctors) </title>  
<style>   
Body {  
  font-family: serif;  
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
        font-family: serif;  
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
</style>   
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(70))
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
    
    <center> <h1 > {{__('title.doctors_all')}} </h1> </center>   
  <div id="table-wrapper">
  <div id="table-scroll">
  <table id="myTable">
        <thead>
            <tr>
<td><b> Doctor ID </b></td>
<td><b> {{__('title.doctor')}}</b></td>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->doctor_id }}</td>
<td>{{ $user->doctor }}</td>
@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(72))
<td><input type="button" onclick="editdoctor({{$user->doctor_id}})" value="{{__('title.edit_btn')}}" ></input></td>
@endif
@endif
@endif


@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(73))
<td><input type="button" onclick="deletedoctor({{$user->doctor_id}})" value="{{__('title.delete_btn')}}" ></input></td>
@endif
@endif
@else
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(73))
<td><input type="button" onclick="restoredoctor({{$user->doctor_id}})" value="{{__('title.restore_btn')}}" ></input></td>
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
@if(Auth::user()->hasPermissionTo(71))
<input type="button" onclick="location.href='{{url('newdoctor')}}'" value="{{__('title.create_new_doctor')}}" ></input></a>
@endif
@endif
<div>  
<a>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(73))
<input type="button" onclick="location.href='{{url('trasheddoctor')}}'" value="{{__('title.trashed_doctor')}}" ></input></a>
@endif
@endif
</body> 

  <script>
  function editdoctor(doctor_id){
    console.log(doctor_id);
    window.location = "{{url('editdoctor/')}}"+'/'+doctor_id;
}
function deletedoctor(doctor_id){
  console.log(doctor_id);
  var deletedoctor = confirm("Want to delete ?");
  if (deletedoctor){
    window.location = "{{url('deletedoctor/')}}"+'/'+doctor_id;
  }
}
function restoredoctor(doctor_id){
  var restoredoctor = confirm("Want to restore ?");
  if (restoredoctor){
    window.location = "{{url('restoredoctor/')}}"+'/'+doctor_id;
  }
}
  </script>   
</html>  