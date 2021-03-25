<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> LabTech Software </title>  
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  

          
 form {   
    }   
 input[type=text] {   
        font-family:  serif;     
        width: 60%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }  
    input[type=number] {   
        font-family:  serif;     
        width: 60%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
        -webkit-appearance: none;
    } 

    select {   
        font-family:  serif;     
        width: 20%;   
        margin: 3px 0px;  
        padding: 3px 3px;   
        display: inline-block;   
        border: 1px black solid;   
        box-sizing: border-box;   
        text-align: left;
    }  

    label {   
        font-family: serif;  
        width: 15%;   
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
<form action = "{{url('newpriceliststestscreate')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
	<table>
	<tr>     
    <center> <h1  style="background-color:DodgerBlue;"> Add New Test Price </h1> </center>   
    <div class="container">   
        <b><label>{{__('title.pricelist_name_new')}} </label>   </b>
        <select name="pricelist_id" required>
            @foreach($PriceLists as $pricelists)
               <option value="{{$pricelists->pricelist_id}}">{{$pricelists->price_list}}</option>
            @endforeach
            </select> 
            </div>
        <div class="container">   
        <b><label>{{__('title.testname_priceliststests_new')}}</label>   </b>
        <select name="megatest_id" required>
            @foreach($megaTests as $megatests)
               <option value="{{$megatests->megatest_id}}">{{$megatests->test_name}}</option>
            @endforeach
            </select> 
            </div>
            <div class="container">
            <b><label>{{__('title.price_priceliststests_new')}}  </label>   </b>
            <input type="integer"  name="price" required>
            </div>
            <div class="container">
            <button type="submit" class="NewPriceListsTests"> <b>{{__('title.new_priceliststests_btn')}}</button></b>    
            <button type="button" class="cancelbtn"> <b>{{__('title.cancel_btn')}}</button></b>
        </div>   
    </form>     
</body>     
</html>  