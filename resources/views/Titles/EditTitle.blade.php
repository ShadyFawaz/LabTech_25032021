<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software </title>  
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  
button {   
        font-family:  serif;
        background-color: grey;   
        width: 10%;  
        color: Black;   
        padding: 10px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
    }   
 input[type=text] {   
        font-family:  serif;     
        width: 50%;   
        margin: 3px 0px;  
        padding: 3px 0px;   
        display: inline-block;   
        box-sizing: border-box;   
        text-align: left;
    }  
    select {   
        font-family:  serif;     
        width: 50%;   
        margin: 3px 0px;  
        padding: 3px 0px;   
        display: inline-block;   
        box-sizing: border-box;   
        text-align: left;
    }  

    label {   
        font-family:  serif;  
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

    table {
  font-family: serif;
  width: 25%;
}
td, th {
  text-align: left;
  padding: 0px;
}
tr:nth-child(even) {
}

</style>   
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(80))
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
<form action = "{{url('edittitle/'.$users[0]->title_id)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    
    <center> <h1> {{__('title.edit_title')}} </h1> </center>   
   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<table>
<tr>
<td>{{__('title.title_edit')}}</td>
<td>
<input type = 'text' name = 'title' required
value = '{{$users[0]->title}}'/> </td>
</tr>
<tr>
<td>{{__('title.gender_edit')}}</td>
<td>
<select  name="gender" required>
  <option value="Male" {{ $users[0]->gender=="Male"? "selected" :"" }} >Male</option>
  <option value="Female" {{ $users[0]->gender=="Female"? "selected" :"" }} >Female</option>
  <option value="Female" {{ $users[0]->gender=="Both"? "selected" :"" }} >Both</option>
  </select>

</td>
</tr>
<tr>
<td colspan = '2'>
<input type = 'submit' value = "{{__('title.update_title_btn')}}" />
</td>
</tr>
</table>
</form>
</html>  