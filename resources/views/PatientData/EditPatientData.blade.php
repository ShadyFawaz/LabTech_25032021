<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Edit Patient Data)</title>  
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
}  

 form {   
    }   
    input[type=text] {   
        font-family:  serif;     
        width: 50%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
          
        box-sizing: border-box;   
        text-align: left;
    }  
    input[type=date] {   
        font-family:  serif;     
        width: 50%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
          
        box-sizing: border-box;   
        text-align: left;
    } 
    textarea {   
        font-family: serif;     
        width: 50%;   
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
        font-family: serif;     
        width: 50%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    select {   
        font-family:  serif;     
        width: 50%;   
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
  width: 50%;
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
@if(Auth::user()->hasPermissionTo(88))
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
<form action = "{{url('editpatientdata/'.$users[0]->patient_code)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    
    <center> <h1> {{__('title.edit_patientdata')}} </h1> </center>   
   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<table>
<tr>
<td>{{__('title.patient_id_patientdata_edit')}}</td>
<td>
<input type = 'text' name = 'Patient_ID'
value = '{{$users[0]->Patient_ID}}'/> </td>
</tr>
<tr>
<td>{{__('title.title_patientdata_edit')}}</td>
<td>

<select name="Title_id">
<option value=""> </option>
    @foreach($titles as $title)
    <option value="{{$title->title_id}}" {{ $users[0]->Title_id==$title->title_id? "selected" :""}}>{{$title->title}}</option>
    @endforeach
    </select> 
</td>
</tr>
<tr>
<td>{{__('title.patient_name_patientdata_edit')}}</td>
<td>
<input type = 'text' name = 'patient_name'
value = '{{$users[0]->patient_name}}'/>
</td>
</tr>
<tr>
<td>{{__('title.dob_patientdata_edit')}}</td>
<td>
<input type = 'date' name = 'DOB'
value = '{{$users[0]->DOB}}'/>
</td>
</tr>
<tr>
<td>{{__('title.phone_number_patientdata_edit')}}</td>
<td>
<input type = 'text' name = 'phone_number'
value = '{{$users[0]->phone_number}}'/>
</td>
</tr>
<tr>
<td>{{__('title.gender_patientdata_edit')}}</td>
<td>
<select name="Gender" required>
               <option value="Male" {{ $users[0]->Gender=="Male"? "selected":"" }}>Male</option>
               <option value="Female" {{ $users[0]->Gender=="Female"? "selected":"" }}>Female</option>
            </select>
</td>
</tr>
<tr>
<td>{{__('title.address_patientdata_edit')}}</td>
<td>
<input type = 'text' name = 'Address'
value = '{{$users[0]->Address}}'/>
</td>
</tr>
<tr>
<td>{{__('title.email_patientdata_edit')}}</td>
<td>
<input type = 'text' name = 'Email'
value = '{{$users[0]->Email}}'/>
</td>
</tr>
<tr>
<td>{{__('title.website_patientdata_edit')}}</td>
<td>
<input type = 'text' name = 'Website'
value = '{{$users[0]->Website}}'/>
</td>
</tr>
<tr>
<td>{{__('title.country_patientdata_edit')}}</td>
<td>
<input type = 'text' name = 'Country'
value = '{{$users[0]->Country}}'/>
</td>
</tr>
<tr>
<td>{{__('title.nationality_patientdata_edit')}}</td>
<td>
<input type = 'text' name = 'Nationality'
value = '{{$users[0]->Nationality}}'/>
</td>
</tr>
<tr>
<td colspan = '2'>
<input type = 'submit' value = "{{__('title.update_patientdata_btn')}}" />
<input type="button" value="{{__('title.cancel_btn')}}" onclick="history.back()"/>
</td>
</tr>
</table>
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" ></script>  -->
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
</form>
</html>  