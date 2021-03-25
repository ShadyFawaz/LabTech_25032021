<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> LabTech Software</title>  
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  

          
 form {   
    }   
 input[type=text] {   
    font-family:  serif;     
        width: 15%;   
        margin: 0px 0px;  
        padding: 3px 0px;   
        display: inline;   
        border: border-box;   
        text-align: left;
        font-weight:bold;
    } 
    input[type=string] {   
    font-family:  serif;     
        width: 15%;   
        margin: 0px 0px;  
        padding: 3px 0px;   
        display: inline;   
        border: border-box;   
        text-align: left;
        font-weight:bold;

    }  
    input[type=number] {   
    font-family:  serif;     
        width: 15%;   
        margin: 0px 0px;  
        padding: 3px 0px;   
        display: inline;   
        border: border-box;   
        text-align: left;
        font-weight:bold;

    } 
    select {   
        font-family:  serif;     
        width: 15%;   
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
<form name="myForm" onsubmit="return validateForm()" action = "{{url('newrelativepricelistcreate/'.$users[0]->RankPriceLists->rank_pricelist_id)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}  
	<table>
	<tr>     

    <center> <h1  style="background-color:DodgerBlue;"> {{__('title.create_new_relativepricelist')}} </h1> </center>   
        <div class="container">   
        <b><label>{{__('title.rankpricelists_relativepricelists_new')}} </label>   </b>
        <select style="width:41%" name="rank_pricelist_id">
            @foreach($RankPriceLists as $rank)
               <option value="{{$rank->rank_pricelist_id}}" required>{{$rank->rank_pricelist_name}}</option>
            @endforeach
            </select>


        <b><label>{{__('title.relativepricelist_new')}} </label>   </b>
            <input type="string"  name="relative_pricelist_name" required> 
            </div>
<br>
<div>
            <b><label>{{__('title.pricelist_relativepricelists_new')}} </label>   </b>
            <select style="width:41%" name="pricelist_id">
            @foreach($PriceLists as $pricelist)
               <option value="{{$pricelist->pricelist_id}}" required>{{$pricelist->price_list}}</option>
            @endforeach
            </select>
            </div>
<br>
            <div class="container">   
        <b><label>{{__('title.patient_load_relativepricelist_new')}} </label>   </b>
            <input id="patient_load" type="number" step="0.01" value="0.00"  name="patient_load"  required> 

            
        <b><label>{{__('title.insurance_load_relativepricelist_new')}} </label>   </b>
            <input id="insurance_load" type="number" step="0.01" value="0.00"  name="insurance_load" required> 
            </div>
            
            
            <div class="container">
            <button type="submit" class="NewRelativePriceList"> <b>{{__('title.new_relativepricelist_btn')}}</button></b> 
            <button type="button" class="cancelbtn"> <b>{{__('title.cancel_btn')}}</button></b>
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

</body>     
</html>  