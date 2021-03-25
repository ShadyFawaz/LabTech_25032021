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
        border: 1px solid #f1f1f1;   
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
  height:390px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:50%;

}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  font-weight:bold;
}
#myInput {
  width: 30%;
  font-size: 14px;
  padding: 10px 15px 10px 20px;
  border: 1px solid #ddd;
  margin-bottom: 10px;
}


</style>  
</head>
@include('MainMenu')
<body>
<center> <h1 > {{__('title.testparameters_all')}} </h1> </center>   

@if(isset($user)&&$user[0])
<a action = "/testparameters/{{$test_id}}"></a>
@endif

    {{ method_field('post') }}
    {{ csrf_field() }}


    
</form>
<div id="table-wrapper">
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
<td><input type="button" onclick="editparameter({{$user->parameter_id}})"    value="{{__('title.edit_btn')}}" ></input></td>
<td><input type="button" onclick="deleteparameter({{$user->parameter_id}})"    value="{{__('title.delete_btn')}}" ></input></td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
<td><input type="button" onclick="location.href='{{url('newtestparameter/'.( $test_id ))}}'" value="{{__('title.createnewtestparameter')}}" ></input></td>

</body>
<script>
  function editparameter(parameter_id){
    console.log(parameter_id);
    window.location = "{{url('edittestparameter/')}}"+'/'+parameter_id;
}
function deleteparameter(parameter_id){
    console.log(parameter_id);
    window.location = "{{url('deletetestparameter/')}}"+'/'+parameter_id;
}
function newparameter(test_id){
    console.log(test_id);
    window.location = "{{url('newtestparameter/')}}"+'/'+test_id;
}
</script> 

</html>