<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> LabTech Software</title>  
<style>   
Body {  
  font-family: times_new_roman, serif;  
  background-color: lightgrey;  
}  

          
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family: times_new_roman, serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }  

    label {   
        font-family: times_new_roman, serif;  
        width: 10%;   
        margin: 0px 0;  
        padding: 5px 0px;  
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
    }   
</style>   
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
<form action = "{{url('newsubgroupscreate')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
	<table>
	<tr>     
    <center> <h1  style="background-color:DodgerBlue;"> {{__('title.create_new_subgroup')}} </h1> </center>   
        <div class="container">   
        <b><label>{{__('title.group_subgroup_new')}} </label>   </b>
        <select name="group_id">
            @foreach($Groups as $groups)
               <option value="{{$groups->group_id}}">{{$groups->group_name}}</option>
            @endforeach
            </select> 
            </div>
            <div class="container">   
        <b><label>{{__('title.subgroup_new')}} </label>   </b>
            <input type="string"  name="subgroup_name" > 
            </div>
            <div class="container">   
        <b><label>{{__('title.report_name_subgroup_new')}} </label>   </b>
            <input type="string"  name="report_name" > 
            </div>
            
            
            <div class="container">
            <button type="submit" class="NewSubGroup"> <b>{{__('title.new_subgroup_btn')}}</button></b> 
            <button type="button" class="cancelbtn"> <b>{{__('title.cancel_btn')}}</button></b>
        </div>   
    </form>     
</body>     
</html>  