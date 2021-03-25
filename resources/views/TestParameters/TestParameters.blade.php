<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Test Parameters)</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  
button {   
        font-family:  serif;
        background-color: grey;   
        width: 10%;  
        color: Black;   
        padding: 5px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
    }   
 input[type=text] {   
        font-family: serif;     
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
    }   

    #table-wrapper {
  position:relative;
}
#table-scroll {
  height:200px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:20%;
  margin:auto;

}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  font-weight:bold;
  text-align:center;
}
#myInput {
  width: 30%;
  font-size: 14px;
  padding: 10px 15px 10px 20px;
  border: 1px solid #ddd;
  margin-bottom: 10px;
}


/* #myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
  font-family: times_new_roman, Helvetica, sans-serif; 
  margin-bottom: 10px; 
} */

</style>  
</head>
@include('MainMenu')
<body>
<center> <h1  > {{__('title.testparameters_all')}} </h1> </center>   


<form id="myForm"  action = "{{url('updateresulttestparameter/'.$result_id)}}"  method = "post" >


    {{ method_field('post') }}
    {{ csrf_field() }}
    
    <center><select style="width:30%" type="number" name="parameter_select" >
                <option value="{{old('parameter_select')}}"> Select Parameter </option>
                @foreach($users as $user)
                <option value="{{$user->parameter_id}}" {{ old('parameter_select') ==$user->parameter_id? "selected":"" }} >{{$user->test_parameter}}</option>
                @endforeach
                </select>
                <div>
                <br>
                <input type="submit"  value="Save" ></center>

<!-- <div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
<thead>
<tr>
<th>{{__('title.parameter_testdata')}}</th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->test_parameter }}</td>
<td> <input type="number" value="0" ></input> </td>
<td style="width:10%;"  ><input type="submit"  value="Select" ></input></td>

</tr>
@endforeach
</tbody>
</table>
</div>
</div> -->
</body>
</form>
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

</html>