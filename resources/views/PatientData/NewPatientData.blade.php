<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> LabTech Software (New patient) </title>  
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey; 
  /* background-color: RGB(239,228,176);  */
}  

.container {   
        padding: 0px;   
    }   

          
 form {   
    }   
 input[type=text] {   
        font-family:  serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
          
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
        width: 18%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 

    input[type=integer] {   
        font-family: serif;     
        width: 5%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    select {   
        font-family:  serif;     
        width: 8%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
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
<form action = "{{url('newpatientdatacreate')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
	<table>
	<tr>     
    <center> <h1> {{__('title.create_new_patient_data')}} </h1> </center>     
        <div >   
        <b><label style="color:Green;">{{__('title.patient_id_patientdata_new')}} </label>   </b>
            <input type="string"  name="Patient_ID" required> 
            </div>
            <div >
            <b><label>{{__('title.title_patientdata_new')}} </label></b>   
            <select name="Title_id">
            <option value=""> </option>
            @foreach($titles as $title)
               <option value="{{$title->title_id}}">{{$title->title}}</option>
            @endforeach
            </select> 
            </div>
            <div >
            <b><label style="color:red;">{{__('title.patient_name_patientdata_new')}} </label> </b>  
            <input type="string"  name="patient_name" required> 
            </div>
            <div >
            <b><label>{{__('title.dob_patientdata_new')}} </label>  </b> 
            <input type="date"  name="DOB">
            </div>
            <div>
            <b><label>{{__('title.phone_number_patientdata_new')}} </label> </b>  
            <input type="string"  name="phone_number" >
            </div>
            </div>
            <div >
            <b><label style="color:red;">{{__('title.gender_patientdata_new')}} </label>  </b> 
            <select name="Gender" required>
               <option value="Male">Male</option>
               <option value="Female">Female</option>
            </select>
            </div>
            <div >
            <b> <label>{{__('title.address_patientdata_new')}}</label> </b>
            <input type="string"  name="Address" >
            </div>
            <div >
            <b><label>{{__('title.email_patientdata_new')}} </label> </b>  
            <input type="string"  name="Email" >
            </div>
            <div >
            <b><label>{{__('title.website_patientdata_new')}} </label></b>   
            <input type="href"  name="Website" >
            </div>
            <div >
            <b> <label>{{__('title.country_patientdata_new')}} </label> </b>  
            <select name="Country">
            @foreach($Country as $country)
               <option value="{{$country->country_id}}">{{$country->country}}</option>
            @endforeach
            </select> 
            </div>
            <div >
            <b><label>{{__('title.nationality_patientdata_new')}} </label> </b>  
            <input type="string"  name="Nationality" >
            </div>
            <div >
            <button type="submit" class="NewPatient"> <b>{{__('title.new_patientdata_btn')}}</button></b>
            <button type="button" class="cancelbtn"> <b>{{__('title.cancel_btn')}}</button></b>
        </div>   
    </form> 

<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 


<script>
function calculateAge()
{
    var fieldDate   = new Date($('input[name=DOB]').val());
    console.log(fieldDate);
    var currentDate = new Date();
    console.log(currentDate);
    var age        = currentDate.getFullYear() - fieldDate.getFullYear();
    console.log(age);

    $('#Ag').val(age)
}
</script>
</body>     
</html>  