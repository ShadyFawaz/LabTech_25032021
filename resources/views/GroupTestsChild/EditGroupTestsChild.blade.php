<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software </title>  
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  
  
 form {   
    }   
    input[type=text] {   
        font-family:  serif;     
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
          
        box-sizing: border-box;   
        text-align: left;
    }  
    textarea {   
        font-family:  serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
          
        box-sizing: border-box;   
        text-align: left;
    }  

    input[type=string] {   
        font-family:  serif;     
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 

    input[type=integer] {   
        font-family:  serif;     
        width: 50%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    select {   
        font-family: serif;     
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    label {   
        font-family:  serif;  
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
  font-family:serif;
  border-collapse: collapse;
  width: 35%;
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
<form action = "{{url('editmegatestschild/'.$users[0]->test_code)}}" method = "post">
<!-- "{{url('editantibiotic/'.$users[0]->antibiotic_id)}}" -->
    {{ method_field('post') }}
    {{ csrf_field() }}
    
    <center> <h1> {{__('title.edit_megatestchild')}} </h1> </center>   
   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<table>
<tr>
<td>{{__('title.parent_name')}}</td>
<td> {{$users[0]->megaTests->test_name}} </td>
</tr>
<tr>
<td>{{__('title.megatestchild_name_edit')}}</td>
<td>
<select name="test_id">

            @foreach($TestData as $testdata)
            <option value="{{$testdata->test_id}}" {{ $users[0]->test_id==$testdata->test_id? "selected" :""}}>{{$testdata->abbrev}}</option>
            @endforeach
            </select> 
             </td>
</tr>
<tr>
<tr>
<td colspan = '2'>
<input type = 'submit' value = "{{__('title.update_megatestchild_btn')}}" />
</td>
</tr>
</table>
</form>
</html>  