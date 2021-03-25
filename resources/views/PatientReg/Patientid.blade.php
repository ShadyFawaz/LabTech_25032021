<!DOCTYPE html>   
<html>   
<head>    
<title> New Patient Visit </title>  
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
        padding: 10px;   
        margin: 10px 0px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
        border: 1px solid #f1f1f1;   
    }   
    input[type=text] {   
        font-family: times_new_roman, Helvetica, sans-serif;     
        width: 50%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
          
        box-sizing: border-box;   
        text-align: left;
    }  
    textarea {   
        font-family: times_new_roman, Helvetica, sans-serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
          
        box-sizing: border-box;   
        text-align: left;
    }  

    input[type=string] {   
        font-family: times_new_roman, Helvetica, sans-serif;     
        width: 80%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 

    input[type=integer] {   
        font-family: times_new_roman, Helvetica, sans-serif;     
        width: 50%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    select {   
        font-family: times_new_roman, Helvetica, sans-serif;     
        width: 50%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    label {   
        font-family: times_new_roman, Helvetica, sans-serif;  
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
        background-color: #B9CDE5;  
    }   

    table {
  font-family: times_new_roman;
  border-collapse: collapse;
  width: auto;
}
td, th {
  border: 1px solid lightgrey;
  text-align: left;
  padding: 0px;
}
tr {
  background-color: lightgrey;
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

<form action = "{{url('newpatientregcreate')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    
    @if(isset($user)&&$user[0])
<center> <b  style="background-color:lightblue;">  {{ $users[0]->PatientData? $users[0]->patientdata->Patient_ID:"" }} </b> </center>
<form action = "/patientid/<?php echo $users[0]->Patient_ID; ?>" method = "get">
@endif

<form action = "/newpatientreg/" method = "post">


    <center> <h1  style="background-color:DodgerBlue;"> New Patient Visit </h1> </center>   
   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<table>
<tr>
<td>Patient ID</td>
<td>
<input type = 'string' name = 'patient_id'
value = '<?php echo$users[0]->Patient_ID; ?>'/> </td>
</tr>


<tr>
<td>Title</td>
<td> 
<select name="title_id">
<option value="" </option>
    @foreach($Titles as $titles)
    <option value="{{$titles->Title_id}}" {{ $users[0]->Title_id==$titles->title_id? "selected" :""}}>{{$titles->title}}</option>
    @endforeach
</select> 

            
</td>
</tr>


<tr>
<td style="color:red;">Patient Name</td>
<td>
<input type = 'string' name = 'patient_name'
value = '<?php echo$users[0]->patient_name; ?>' required/>
</td>
</tr>


<tr>
<td style="color:red;">Gender</td>
<td>
<input type = 'string' name = 'gender'
value = '<?php echo$users[0]->Gender; ?>' required/>
</td>
</tr>


<tr>
<td>DOB</td>
<td>
<input type = 'date' name = 'dob'
value = '<?php echo$users[0]->DOB; ?>'/>
</td>
</tr>


<tr>
<td style="color:red;">Age</td>
<td>
<input type = 'integer' name = 'ag'
value = '<?php echo$users[0]->Ag; ?>' required/>
<input type = 'string' name = 'age'
value = '<?php echo$users[0]->Age; ?>' required/>
</td>
</tr>


<tr>
<td>Req Date</td>
<td>
<input type="timestamp"  name="req_date" value="<?php echo date("Y-m-d\ H:i"); ?>" required>
</td>
</tr>

<tr>
<td>Phone Number</td>
<td>
<input type = 'string' name = 'phone_number'>
</td>
</tr>

<tr>
<td>Patient Condition</td>
<td>
<input type = 'integer' name = 'patient_condition'> </td>
</td>
</tr>



<tr>
<td>E_Mail</td>
<td>
<input type = 'string' name = 'email'>
</td>
</tr>


<tr>
<td>Web Site</td>
<td>
<input type = 'string' name = 'website'>
</td>
</tr>


<tr>
<td>Country</td>
<td>
<input type = 'integer' name = 'country_id'> </td>
</td>
</tr>


<tr>
<td>Nationality</td>
<td>
<input type = 'string' name = 'nationality'>
</td>
</tr>


<tr>
<td>Doctor</td>
<td>

<input type = 'integer' name = 'doctor_id'> </td>
</td>
</tr>

<tr>
<td>Diagnosis</td>
<td>
<input type = 'integer' name = 'diagnosis_id'> </td>
</td>
</tr>

<tr>
<td>Comment</td>
<td>
<input type = 'text' name = 'comment'>
</td>
</tr>



<td colspan = '2'>
<input type = 'submit' value = "Select Tests" />
</td>
</tr>
</table>
</form>
</html>  