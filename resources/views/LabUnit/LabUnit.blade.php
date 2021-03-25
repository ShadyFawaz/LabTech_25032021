<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Lab Units) </title>  
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
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
@if(Auth::user()->hasPermissionTo(95))
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
    
    <center> <h1 > {{__('title.lab_units_all')}} </h1> </center>   
    <div id="table-wrapper">
  <div id="table-scroll">
  <table id="myTable">
        <thead>
            <tr>
<th><b> Lab Unit ID </b></th>
<th><b> {{__('title.lab_unit')}} </b></th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->labunit_id }}</td>
<td>{{ $user->lab_unit }}</td>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(96))
<td><input type="button" onclick="editlabunit({{$user->labunit_id}})" value="{{__('title.edit_btn')}}" ></input></td>
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
@if(Auth::user()->hasPermissionTo(96))
<input type="button" onclick="location.href='{{url('newlabunit')}}'" value="{{__('title.create_new_lab_unit')}}" ></input></a>
@endif
@endif
</body> 
<script>
  function editlabunit(labunit_id){
    console.log(labunit_id);
    window.location = "{{url('editlabunit/')}}"+'/'+labunit_id;
}
</script>    
</html>  