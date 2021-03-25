<!DOCTPE html>
<html>
<head>
<title>Test Entry</title>
<style>   
Body {  
  font-family: times_new_roman, Helvetica, sans-serif;  
  background-color: lightgrey;  
}  
button {   
        font-family: times_new_roman, Helvetica, sans-serif;
        background-color: grey;   
        width: 10%;  
        color: Black;   
        padding: 5px;   
        margin: 10px 0px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family: times_new_roman, Helvetica, sans-serif;     
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
    font:normal 11px/22px times_new_roman, Sans-Serif;
    color:black;
    border:1px solid #ccc;
}  

    label {   
        font-family: times_new_roman, Helvetica, sans-serif;  
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
        font:normal 13px/13px times_new_roman, Sans-Serif;
        border-collapse: collapse;
        width: auto;
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 5px;
}
tr:nth-child(even) {
  background-color: #dddddd;
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
  font-family: times_new_roman, Helvetica, sans-serif; 
  margin-bottom: 10px; 
}

</style>  
</head>
<body>
<center> <h1  style="background-color:DodgerBlue;"> Test Entry </h1> </center>   
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for tests.." title="Type in a name">
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
<form action = "{{url('newtestentrycreate')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
<table  id="myTable" border = "1">
<tr class="header">
<th>Reg Key</th>
<th>Test ID</th>
<th style="color:orange;">Result</th>
<th>Unit</th>
<th>From</th>
<th>To</th>
<th>N_N Normal Range</th>
<th>Flag</th>
<th>Test Order</th>
<th>Profile Order</th>
<th>Report</th>
<th>Result Comment</th>
<th>Printed</th>
<th>Report Printed</th>
<th>Completed</th>
<th>Verified</th>
</tr>
@foreach ($users as $user)
<tr>
<td><input type = 'integer' name = 'regkey'
value = ""/></td>
<td><input type="integer"  name="test_id" ></td>
<td><input type="string"  name="result" ></td>
<td><input type="string"  name="unit" ></td>
<td><input type="integer"  name="low" ></td>
<td><input type="integer"  name="high" ></td>
<td><input type="string"  name="nn_normal" ></td>
<td><input type="string"  name="flag" ></td>
<td><input type="integer"  name="test_order" ></td>
<td><input type="integer"  name="profile_order" ></td>
<td><input type="string"  name="rpt" ></td>
<td><input type="text"  name="result_comment" ></td>
<td><input type="integer"  name="printed" ></td>
<td><input type="integer"  name="report_printed" ></td>
<td><input type="integer"  name="completed" ></td>
<td><input type="integer"  name="verified" ></td>
<td><a href = 'edittestdata/{{ $user->test_id }}'>Edit</a></td>
<td><a href = 'normalranges/{{ $user->test_id }}'>Normal Ranges</a></td>
</tr>
@endforeach
</table>


<button type="submit" class="NewTest"> <b>Save</button></b>
  
</body>
</html>