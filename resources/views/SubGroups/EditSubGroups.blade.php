<!DOCTYPE html>   
<html>   
<head>    
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
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
          
        box-sizing: border-box;   
        text-align: left;
    }  
    textarea {   
        font-family: times_new_roman, serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
          
        box-sizing: border-box;   
        text-align: left;
    }  

    input[type=string] {   
        font-family: times_new_roman, serif;     
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 

    input[type=integer] {   
        font-family: times_new_roman, serif;     
        width: 50%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    select {   
        font-family: times_new_roman, serif;     
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    label {   
        font-family: times_new_roman, serif;  
        width: 50%;   
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

    table {
  font-family: times_new_roman;
  border-collapse: collapse;
  width: 25%;
}
td, th {
  text-align: left;
  padding: 0px;
}
tr {
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
<form action = "{{url('editsubgroups/'.$users[0]->subgroup_id)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    
    <center> <h1  style="background-color:DodgerBlue;"> {{__('title.edit_subgroup')}} </h1> </center>   
    

   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<table>
<tr>
<td>{{__('title.group_subgroup_edit')}}</td>
<td> {{$users[0]->Groups->group_name}}</td>
</tr>
<td>{{__('title.subgroup_edit')}}</td>
<td>
<input type = 'integer' name = 'subgroup_name'
value = '{{$users[0]->subgroup_name}}' required/> </td>
</tr>
<td>{{__('title.report_name_subgroup_edit')}}</td>
<td>
<input type = 'string' name = 'report_name'
value = '{{$users[0]->report_name}}' /> </td>
</tr>

<tr>
<td colspan = '2'>
<input type = 'submit' value = "{{__('title.update_subgroup_btn')}}" />
</td>
</tr>
</table>
</form>
</html>  