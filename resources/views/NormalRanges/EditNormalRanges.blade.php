<!DOCTYPE html>   
<html>   
<head>    
<title> Edit Normal Range</title>  
<style>   
Body {  
  font-family: times_new_roman, serif;  
  background-color: lightgrey;  
}  
 
 form {   
        border: 1px solid #f1f1f1;   
    }   
    input[type=text] {   
        font-family: times_new_roman, serif;     
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
          
        box-sizing: border-box;   
        text-align: left;
    }  
    textarea {   
        font-family: times_new_roman, serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
          
        box-sizing: border-box;   
        text-align: left;
    }  

    input[type=string] {   
        font-family: times_new_roman, serif;     
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 

    input[type=integer] {   
        font-family: times_new_roman, serif;     
        width: 50%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    select {   
        font-family: times_new_roman, serif;     
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    label {   
        font-family: times_new_roman, serif;  
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
  font-family: times_new_roman;
  border-collapse: collapse;
  width: 25%;
}
td, th {
  border: 1px solid lightgrey;
  text-align: left;
  padding: 0px;
}
tr {
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
<form action = "/editnormalranges/<?php echo $normals[0]->normal_id; ?>" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    
    <center> <h1  style="background-color:DodgerBlue;"> Edit Normal Range </h1> </center>   
    <center> <h1  style="background-color:DodgerBlue;">  <?php echo$normals[0]->TestData->abbrev; ?> </h1> </center>   

   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<table>
<tr>
<td>Test Name</td>
<td> <?php echo$normals[0]->TestData->abbrev; ?></td>
</tr>
<td>From</td>
<td>
<input type = 'integer' name = 'low'
value = '<?php echo$normals[0]->low; ?>'/> </td>
</tr>
<td>To</td>
<td>
<input type = 'integer' name = 'high'
value = '<?php echo$normals[0]->high; ?>'/> </td>
</tr>
<td>N_N Normal Range</td>
<td>
<input type = 'string' name = 'nn_normal'
value = '<?php echo$normals[0]->nn_normal; ?>'/> </td>
</tr>
<td>{{__('title.age_from')}}</td>
<td>
<input type = 'integer' name = 'age_from'
value = '<?php echo$normals[0]->age_from; ?>'/> </td>
</tr>
<td>Age To</td>
<td>
<input type = 'integer' name = 'age_to'
value = '<?php echo$normals[0]->age_to; ?>'/> </td>
</tr>
<td>Age</td>
<td>
<input type = 'string' name = 'age'
value = '<?php echo$normals[0]->age; ?>'/> </td>
</tr>

<td>Gender</td>
<td>
<input type = 'string' name = 'gender'
value = '<?php echo$normals[0]->gender; ?>'/> </td>
</tr>

<tr>
<td>Patient Condition</td>
<td>
<select name="patient_condition">
<option value=""></option>
            @foreach($PatientCondition as $patientcondition)
               <option value="{{$patientcondition->patientcondition_id}}">{{$patientcondition->patient_condition}}</option>
            @endforeach
            </select> 
</td>
</tr>


<td>active</td>
<td>
<input type = 'integer' name = 'active'
value = '<?php echo$normals[0]->active; ?>'/> </td>
</tr>
<tr>
<tr>
<td colspan = '2'>
<input type = 'submit' value = "Update Normal Range" />
</td>
</tr>
</table>
</form>
</html>  