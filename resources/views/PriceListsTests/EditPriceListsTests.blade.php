<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software </title>  
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
}  
  
 form {   
    }   
    input[type=text] {   
        font-family:  serif;     
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
          
        box-sizing: border-box;   
        text-align: left;
    }  
    textarea {   
        font-family: serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
          
        box-sizing: border-box;   
        text-align: left;
    }  

    input[type=string] {   
        font-family:  serif;     
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 

    input[type=number] {   
        font-family:  serif;     
        width: 100%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    select {   
        font-family:  serif;     
        width: 150%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    label {   
        font-family:  serif;  
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
  width: 25%;
}
td, th {
  text-align: left;
  padding: 0px;
}
tr {
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
<form action = "{{url('editpriceliststests/'.$users[0]->testprice_id)}}" method = "post">

    {{ method_field('post') }}
    {{ csrf_field() }}
    
    <center> <h1> Edit Test Price </h1> </center>   
    <center> <b style="background-color:lightblue;"> {{__('title.pricelist_name_tests_edit')}} </b> </center>
    <center> <b style="background-color:lightblue;">  <?php echo $users[0]->PriceLists->price_list; ?> </b> </center>
    
   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<table>


<tr>
<td>{{__('title.testname_priceliststests_edit')}}</td>
@if ($users[0]->megatest_id)
<td> {{$users[0]->megaTests->test_name}} </td>
@endif
@if ($users[0]->test_id)
<td> {{$users[0]->TestData->abbrev}} </td>
@endif
</tr>
<tr>
<td>{{__('title.price_priceliststests_edit')}}</td>
<td>
<input type = 'number' min="1" step="1" name = 'price'
value = '{{$users[0]->price}}'/>
</td>
</tr>
<tr>
<tr>
<td colspan = '2'>
<input type = 'submit' value = "{{__('title.update_priceliststests_btn')}}" />
</td>
</tr>
</table>
</form>
</html>  