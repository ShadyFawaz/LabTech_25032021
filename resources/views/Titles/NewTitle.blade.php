<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (New Title) </title>  
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
        padding: 5px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
    }   
 input[type=text] {   
        font-family:  serif;     
        width: 20%;   
        margin: 0px 0px;  
        padding: 3px 2px;   
        display: inline-block;   
        box-sizing: border-box;   
        text-align: left;
    }
    select {
    width: 20%;  
    margin: 0px 0px;  
    padding: 3px 2px;    
    cursor:pointer;
    display:inline-block;
    position:relative;
    font:normal 11px/22px  Serif;
    color:black;
    box-sizing: border-box;   

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

    table {
  font-family: serif;
  border-collapse: collapse;
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
@if(Auth::user()->hasPermissionTo(79))
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
<form action = "{{url('newtitlecreate')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
	<table>
	<tr>   
    <center> <h1>{{__('title.create_new_title')}} </h1> </center>        
            <div >
            <b><label>{{__('title.title_new')}} </label></b>   
            <input type="text"  name="title" required>
            </div>
            <div>
            <b><label>{{__('title.gender_new')}}  </label> </b>  
            <select name="gender" id="gender">
               <option value="Male">Male</option>
               <option value="Female">Female</option>
               <option value="Both">Both</option>
            </select>
            </div>
            <div>
            <button type="submit"><b>{{__('title.new_title_btn')}}</button> </b>     
            <button type="button" class="cancelbtn"> <b>{{__('title.cancel_btn')}}</button></b>
            <form action="/action_page.php">
        </div>   
    </form>     
</body>     
</html>  