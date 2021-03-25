<!DOCTYPE html>   
<html>   
<head>    
<title> Titles </title>  
<style>   
Body {  
  font-family: times_new_roman, Helvetica, sans-serif;  
  background-color: lightgrey;  
}  
button {   
        font-family: times_new_roman, Helvetica, sans-serif;
        background-color: grey;   
        width: 10%;  
        color: Black;   
        padding: 5px;   
        margin: 10px 0px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family: times_new_roman, Helvetica, sans-serif;     
        width: 10%;   
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
        font-family: times_new_roman, Helvetica, sans-serif;  
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
        background-color: #B9CDE5;  
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
  background-color: #dddddd;
}

</style>   
</head>    
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
    
    <center> <h1> Titles </h1> </center>   
    <form     
            <div class="container">
            <b><label>Title : </label></b>   
            <input type="text"  name="title" required>
            </div>
            <div class="container">
            <b><label>Gender : </label> </b>  
            <select name="gender" id="gender">
               <option value="Male">Male</option>
               <option value="Female">Female</option>
               <option value="Both">Both</option>
            </select> 
            </div>
            <div class="container">
            <button type="submit"><b>Save</button> </b>     
            <button type="button" class="cancelbtn"> <b>Cancel</button></b> 
            <a href="/newtitle">Create New Title</a>  
            <form action="/action_page.php">
        </div>   
    

    
    <center> <h1> Edit Title </h1> </center>   
   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<table>
<tr>
<td>Title</td>
<td>
<input type = 'text' name = 'title'

</tr>
<tr>
<td>Gender</td>
<td>
<input type = 'text' name = 'gender'

</td>
</tr>
<tr>
<td colspan = '2'>
<input type = 'submit' value = "Update Title" />
</td>
</tr>
</table>
<a href="/newtitle">Create New Title</a>   
</body>  
</form>    
</html>  