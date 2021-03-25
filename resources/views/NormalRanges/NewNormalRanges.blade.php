<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> Create New Normal Range </title>  
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
}  
button {   
        font-family:serif;
        background-color: grey;   
        width: 15%;  
        color: Black;   
        padding: 5px;   
        margin: 5px 0px;   
        border: none;   
        cursor: pointer;   
         }  
          
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family: serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }  

    label {   
        font-family: serif;  
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
        background-color: #B9CDE5;  
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
<form action = "{{url('newnormalrangescreate')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
	<table>
	<tr>     
    <center> <h1  style="background-color:DodgerBlue;"> New Normal Range </h1> </center>   
        <div class="container">   
        <b><label>Test Name </label>   </b>
        <select name="test_id">
            @foreach($TestData as $testdata)
               <option value="{{$testdata->test_id}}">{{$testdata->abbrev}}</option>
            @endforeach
            </select> 
            </div>
            <div class="container">   
        <b><label>From </label>   </b>
            <input type="integer"  name="low" > 
            </div>
            <div class="container">   
        <b><label>To </label>   </b>
            <input type="integer"  name="high" > 
            </div>
            <div class="container">
            <b><label>N_N Normal Range  </label></b>   
            <input type="string"  name="nn_normal" > 
            </div>
            <div class="container">
            <b><label>Age From  </label> </b>  
            <input type="integer"  name="age_from" required> 
            </div>
            <div class="container">
            <b><label>Age To </label>  </b> 
            <input type="integer"  name="age_to" required>
            </div>
            <div class="container">   
        <b><label>Age  </label>   </b>
            <input type="string"  name="age" required> 
            </div>
            <div class="container">
            <b><label> Gender </label>   </b>
            <input type="string"  name="gender" required> 
            </div>

            <div class="container">   
        <b><label>Patient Condition </label>   </b>
        <select name="patient_condition">
        <option value=""></option>
            @foreach($PatientCondition as $patientcondition)
               <option value="{{$patientcondition->patientcondition_id}}">{{$patientcondition->patient_condition}}</option>
            @endforeach
            </select> 
            </div>


            <div class="container">   
        <b><label>Active  </label>   </b>
            <input type="integer"  name="active" required> 
            </div>
            
            <div class="container">
            <button type="submit" class="NewNormalRange"> <b>Create New Normal Range</button></b>
            <button type="button"><b>Save</button> </b>     
            <button type="button" class="cancelbtn"> <b>Cancel</button></b>
        </div>   
    </form>     
</body>     
</html>  