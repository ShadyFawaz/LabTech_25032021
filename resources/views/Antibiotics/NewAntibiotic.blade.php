<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> LabTech Software (New Antibiotic) </title>  
<style>   
Body {  
  font-family: serif;  
}  

          
 form {   
    }   
 input[type=text] {   
        font-family: serif;     
        width: 50%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }  

    label {   
        font-family:  serif;  
        width: 12%;   
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
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(114))
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
<form action = "{{url('newantibioticcreate')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
     
    <center> <h1> {{__('title.create_new_antibiotic')}} </h1> </center>     
        <div >   
        <b><label>{{__('title.antibiotic_shortcut_new')}} </label>   </b>
            <input type="text"  name="antibiotic_name" required> 
            </div>
            <div >
            <b><label>{{__('title.report_name_new')}} </label></b>   
            <input type="text"  name="report_name" required>
            </div>
            <div >
            <button type="submit" class="NewAntibiotic"> <b>{{__('title.new_antibiotic_btn')}}</button></b>
            <button type="button" class="cancelbtn"> <b>{{__('title.cancel_btn')}}</button></b>
        </div>   
    </form>     
</body>     
</html>  