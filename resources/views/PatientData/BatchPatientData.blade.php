<!DOCTPE html>
<html>
<head>
<title>Batch Patient Data</title>
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
    width: 10%;  
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
        font:normal 15px/15px times_new_roman, Sans-Serif;
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
<center> <h1> Batch Patient Data </h1> </center>  
 
<table  id="myTable" border = "1">
<tr class="header">
<th>Patient ID</th>
<th>Title</th>
<th>Patient Name</th>
<th>Gender</th>
<th>DOB</th>
<th>Ag</th>
<th></th>
<th>Phone Number</th>
<th>Address</th>
<th>Email</th>
<th>Website</th>
<th>Country</th>
<th>Nationality</th>
</tr>
$users = array("patient_data");
@foreach ($users as $user)
<tr>
<td><br><input type="text"  name="Patient_ID" required> $user</br></td>
           
</tr>
@endforeach
</table>


<a href="/newpatientdata">Create New Patient</a>  
</body>
</html>