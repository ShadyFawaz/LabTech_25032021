<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (New Result Unit) </title>  
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
}  
 
 form {   
    }   
    input[type=text] {   
        font-family:  serif;     
        width: 30%;   
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
        width: 50%;   
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
        width: 100%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
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
@if(Auth::user()->hasPermissionTo(93))
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
<form action = "{{url('newresultsunitscreate')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
	<table>
	<tr>   
  <center> <h1  > {{__('title.create_new_result_unit')}} </h1> </center>       
            <div >
            <b><label>{{__('title.result_unit_new')}} </label></b>   
            <input type="text"  name="result_unit" required>
            </div>
            <div >
            <button type="submit"><b>{{__('title.new_result_unit_btn')}}</button> </b>     
            <button type="button" class="cancelbtn"> <b>{{__('title.cancel_btn')}}</button></b>
            <form action="/action_page.php">
        </div>   
    </form>     
</body>     
</html>  