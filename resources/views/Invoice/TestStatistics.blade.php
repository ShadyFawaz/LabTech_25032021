<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Test Statistics)</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: #495C70 ;  
}  
 
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family:  serif;     
        width: 10%;   
        margin: 0px 0px;  
        padding: 3px 2px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }
    select {
    width: 100%;  
    margin: 0px 0px;  
    padding: 3px 2px;    
    cursor:pointer;
    display:inline-block;
    position:relative;
    font:normal 11px/22px  Serif;
    color:black;
    border:1px solid #ccc;
}  

    label {   
        font-family:  serif;  
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
        font:normal 13px/13px Serif;
        border-collapse: collapse;
        
        width: auto;
        margin: 20 auto;
}
td, th {
  text-align: left;
  padding: 5px;
  background-color: white;
}
tr:nth-child(even) {
  background-color: white;
}
#myInput {
  width: 30%;
  font-size: 14px;
  padding: 10px 15px 10px 20px;
  border: 1px solid #ddd;
  margin-bottom: 10px;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
  font-family: times_new_roman, serif; 
  margin-bottom: 10px; 
}

</style>  

</head>
@include('MainMenu')
<body>
<center> <h1  > {{__('title.test_statistics')}} </h1> </center>   
<center> <b1  style="background-color:white;">{{$datefrom}} احصائيه بعدد التحاليل التى تم عملها بالمعمل عن الفتره مــن  </b1> </center> 
<center> <b1  style="background-color:white;margin-right: 280px;" >{{$dateto}} الــى</b1> </center> 


    {{ method_field('post') }}
    {{ csrf_field() }}
    
</form>
<table  id="myTable" border = "1">
<tr class="header">

<th>Test name</th>
<th>Count</th>


</tr>
@foreach ($users as $user)
<tr>
<td>
@if($user->megatest_id)
{{ $user->megatests->test_name }} 
@endif
@if($user->grouptest_id)
{{ $user->GroupTests->test_name }} 
@endif
@if($user->test_id)
{{ $user->TestData->abbrev }} 
@endif
</td>
<td>{{ $user->mega_count }} </td>

</tr>


@endforeach

</table>
<label style="width:20%;background-color:yellow"> Total Tests Count = {{$TestCount}} </label>
<hr style="border:double;">

 <b style="font-size:12px;"> Printed By : @if(isset(Auth::user()->login_name))
{{ (Auth::user()->user_name) }}
@endif
</b> 

</body>
</html>