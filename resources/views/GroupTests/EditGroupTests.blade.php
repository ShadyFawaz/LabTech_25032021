<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Edit Group Test) </title>  
<style>   
Body {  
  font-family: serif;  
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
        font-family: serif;     
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
        font-family:  serif;     
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    label {   
        font-family: serif;  
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
  font-family: serif;
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
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(61))
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
<form action = "{{url('editgrouptests/'.$users[0]->grouptest_id)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    
    <center> <h1> {{__('title.edit_grouptest')}} </h1> </center>   
   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<table>
<tr>
<td>{{__('title.grouptest_name')}}</td>
<td>
<input type = 'text' name = 'test_name'
value = '{{$users[0]->test_name}}'/> </td>
</tr>
<tr>
<td>{{__('title.active_grouptest')}}</td>
<td>
<input  type="checkbox" value="1" name="active"  {{ $users[0]->active==1 ? "checked":"" }} >
</tr>
<tr>
<td>{{__('title.outlab_grouptest')}}</td>
<td>
<input  type="checkbox" value="1" name="outlab"  {{ $users[0]->outlab==1 ? "checked":"" }} >
</td>
<tr>
<td>{{__('title.outlabid_grouptest')}}  
            <select name="outlab_id">
            <option value="" ></option>
                @foreach($OutLabs as $outlab)
                <option value="{{$outlab->outlab_id}}" {{ $users[0]->outlab_id==$outlab->outlab_id? "selected" :""}}>{{$outlab->out_lab}}</option>
                @endforeach
            </select> 
</td>
</tr>
</tr>
<tr>
<tr>
<td colspan = '2'>
<input type = 'submit' value = "{{__('title.update_btn')}}" />
</td>
</tr>
</table>
</form>
</html>  