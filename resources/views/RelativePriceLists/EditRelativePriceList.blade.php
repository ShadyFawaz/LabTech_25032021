<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Edit Relative Price Lists)</title>  
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  

          
 form {   
    }   
 input[type=text] {   
    font-family:  serif;     
        width: 10%;   
        margin: 0px 0px;  
        padding: 3px 0px;   
        display: inline;   
        border: border-box;   
        text-align: left;
        font-weight:bold;
    } 
    input[type=string] {   
    font-family:  serif;     
        width: 10%;   
        margin: 0px 0px;  
        padding: 3px 0px;   
        display: inline;   
        border: border-box;   
        text-align: left;
        font-weight:bold;

    }  
    input[type=number] {   
    font-family:  serif;     
        width: 10%;   
        margin: 0px 0px;  
        padding: 3px 0px;   
        display: inline;   
        border: border-box;   
        text-align: left;
        font-weight:bold;

    } 
    select {   
        font-family:  serif;     
        width: 10%;   
        margin: 0px 0px;  
        padding: 3px 0px;   
        display: inline;   
        border: border-box;   
        text-align: left;
        font-weight:bold;

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
</style>   
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(147))
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
<form name="myForm" onsubmit="return validateForm()" action = "{{url('editrelativepricelist/'.$users[0]->relative_pricelist_id)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    
    <center> <h1  > {{__('title.edit_relativepricelist')}} </h1> </center>   
    

   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<div >   
        <b><label>{{__('title.rankpricelists_relativepricelists_new')}} </label>   </b>
        <b><label style="background-color:white;"> {{$users[0]->RankPriceLists->rank_pricelist_name}}</label></b>

        <b><label>{{__('title.relativepricelist_new')}} </label>   </b>
        <input type = 'string' name = 'relative_pricelist_name' value = '{{$users[0]->relative_pricelist_name}}' required/>
            </div>
<br>
<div>
            <b><label>{{__('title.pricelist_relativepricelists_new')}} </label>   </b>
            <select style="width:31%;" name="pricelist_id">
            <option value=""></option>
            @foreach($PriceLists as $pricelist)
            <option required value="{{$pricelist->pricelist_id}}" {{ $users[0]->pricelist_id==$pricelist->pricelist_id? "selected" :""}}>{{$pricelist->price_list}}</option>
            @endforeach
            </select> 
            </div>
<br>

<div >   
        <b><label>{{__('title.insurance_factor_relativepricelist')}} </label>   </b>
        <input id = 'insurance_factor' type="number" step="0.01" name = 'insurance_factor' value = '{{$users[0]->insurance_factor}}'  required />
</div>
            <div >   
        <b><label>{{__('title.patient_load_relativepricelist_new')}} </label>   </b>
        <input id = 'patient_load' type="number" step="0.01" name = 'patient_load' value = '{{$users[0]->patient_load}}'  required />
            
        <b><label>{{__('title.insurance_load_relativepricelist_new')}} </label>   </b>
        <input id = 'insurance_load' type="number" step="0.01" name = 'insurance_load' value = '{{$users[0]->insurance_load}}'  required />            </div>
            
            
            <div >
           <br>
            <input type = 'submit' value = "{{__('title.update_subgroup_btn')}}" />

        </div>  
</form>

<script>
function validateForm(){
//   var PatientLoad     = $('#patient_load').val();
  var PatientLoad = document.forms["myForm"]["patient_load"].value;
  PatientLoad = PatientLoad.replace(/[^0-9.]/g, '');
  PatientLoad = parseFloat(PatientLoad);

//   var InsuranceLoad   = $('#insurance_load').val();
  var InsuranceLoad = document.forms["myForm"]["insurance_load"].value;
  InsuranceLoad = InsuranceLoad.replace(/[^0-9.]/g, '');
  InsuranceLoad = parseFloat(InsuranceLoad);
  
  var total = PatientLoad + InsuranceLoad;
    console.log(PatientLoad);
    console.log(InsuranceLoad);
    console.log(total);

  if (total != "1")
  {
  alert ("Total load must equal 1");
  
  return false;
  }
}
</script>
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

</body> 
</html>  