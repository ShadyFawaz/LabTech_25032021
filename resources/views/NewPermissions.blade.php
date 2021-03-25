<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software </title>  
<style>   
Body {  
  font-family: times_new_roman, Helvetica, sans-serif;  
  background-color: lightgrey;  
}  

 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family: times_new_roman, Helvetica, sans-serif;     
        width: 50%;   
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
    font:normal 11px/22px times_new_roman, Sans-Serif;
    color:black;
    border:1px solid #ccc;
}  

    label {   
        font-family: times_new_roman,serif;  
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
  font-family: times_new_roman;
  border-collapse: collapse;
  width: 25%;
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 0px;
}
tr:nth-child(even) {
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
<form action = "{{url('newpermissioncreate')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
	<table>
	<tr>   
    <center> <h1> Create New Permission </h1> </center>        
            <div >
            <b><label>Permission </label></b>   
            <input type="text"  name="permission" required>
            </div>
            <div >
            <b><label>Type </label></b>   
            <input type="text"  name="type" required>
            </div>
            <div>
            <b><label>Description </label> </b>  
            <input type="text"  name="description" required>
            </div>
            <div >
            <button type="submit"><b>{{__('title.new_diagnosis_btn')}}</button> </b>     
            <button type="button" class="cancelbtn"> <b>{{__('title.cancel_btn')}}</button></b>
            <form action="/action_page.php">
        </div>   
    </form>     
</body>     
</html>  