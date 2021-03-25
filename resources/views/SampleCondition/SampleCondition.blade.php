<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Sample Condition) </title>  
<style>   
Body {  
  font-family:  serif;  
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
        width: auto;   
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
  width:50%;

}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  font-weight:bold;
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
@if(Auth::user()->hasPermissionTo(101))
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
    
    <center> <h1 > {{__('title.sample_condition_all')}} </h1> </center>   
<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
<thead>
<tr>
<th><b> Sample Condition ID </b></th>
<th><b> {{__('title.sample_condition')}} </b></th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->samplecondition_id }}</td>
<td>{{ $user->sample_condition }}</td>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(103))
<td><input type="button" onclick="editsamplecondition({{$user->samplecondition_id}})"    value="{{__('title.edit_btn')}}" ></input></td>
@endif
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(102))
<input type="button" onclick="location.href='{{url('newsamplecondition')}}'" value="{{__('title.create_new_sample_condition')}}" ></input>
@endif
@endif
</body>   
<script>
  function editsamplecondition(samplecondition_id){
    console.log(samplecondition_id);
    window.location = "{{url('editsamplecondition/')}}"+'/'+samplecondition_id;
}
</script>  
</html>  