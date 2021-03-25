<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Edit Profile Tests)</title>  
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
        width: 50%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    label {   
        font-family:  serif;  
        width: 100%;   
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
  font-family: serif;
  border-collapse: collapse;
  width: 50%;
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
<form action = "{{url('editprofiletest/'.$users[0]->profiletest_id)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    
    <center> <h1  style="background-color:DodgerBlue;"> {{__('title.edit_profile_test')}} </h1> </center>   
    

   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<table>
<tr>
<td>{{__('title.profile_profile_test_edit')}}</td>
<td> {{$users[0]->Profiles->profile_name}}</td>
</tr>
<td>{{__('title.profile_test_edit')}}</td>
<td>
@if($users[0]->megatest_id)
<select name="megatest_id">
    @foreach($MegaTests as $megatest)
    <option value="{{$megatest->megatest_id}}" {{ $users[0]->megatest_id==$megatest->megatest_id? "selected" :""}}>{{$megatest->test_name}}</option>
    @endforeach
    </select> 
    @endif
    @if($users[0]->grouptest_id)
<select name="megatest_id">
    @foreach($GroupTests as $grouptest)
    <option value="{{$grouptest->grouptest_id}}" {{ $users[0]->grouptest_id==$grouptest->grouptest_id? "selected" :""}}>{{$grouptest->test_name}}</option>
    @endforeach
    </select> 
    @endif
    @if($users[0]->test_id)
<select name="test_id">
    @foreach($TestData as $test)
    <option value="{{$test->test_id}}" {{ $users[0]->test_id==$test->test_id? "selected" :""}}>{{$test->abbrev}}</option>
    @endforeach
    </select> 
    @endif
</td>
</tr>
<tr>
<td colspan = '2'>
<input type = 'submit' value = "{{__('title.update_profile_test_btn')}}" />
</td>
</tr>
</table>
</form>
</html>  