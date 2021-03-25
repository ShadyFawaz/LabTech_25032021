<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> Test Data </title>  
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
        padding: 10px;   
        margin: 10px 0px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family: times_new_roman, Helvetica, sans-serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }  

    label {   
        font-family: times_new_roman, Helvetica, sans-serif;  
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
        background-color: #B9CDE5;  
    }   
</style>   
</head>    
<body>    
    <center> <h1> Test Data </h1> </center>   
    <form>  
        <div class="container">   
        <b><label>Patient ID : </label>   </b>
            <input type="text"  name="PatientID" required> 
            </div>
            <div class="container">
            <b><label>Title : </label></b>   
            <input type="text"  name="Title_id" required>
            </div>
            <div class="container">
            <b><label>Patient Name : </label> </b>  
            <input type="text"  name="PatientName" required> 
            </div>
            <div class="container">
            <b><label>Date Of Birth : </label>  </b> 
            <input type="date"  name="DOB" required>
            </div>
            <div class="container">
            <b><label>Mobile Number : </label> </b>  
            <input type="text"  name="PhoneNumber" required>
            </div>
            <div class="container">
            <b> <label>Age : </label>  </b> 
            <input type="number"  name="Ag" required>   
            <input type="text"  name="Age" required>
            </div>
            <div class="container">
            <b><label>Gender : </label>  </b> 
            <input type="text"  name="Gender" required>
            </div>
            <div class="container">
            <b> <label>Address : </label> </b>
            <input type="text"  name="Address" required>
            </div>
            <div class="container">
            <b><label>E-Mail : </label> </b>  
            <input type="text"  name="E-Mail" required>
            </div>
            <div class="container">
            <b><label>WebSite : </label></b>   
            <input type="href"  name="Website" required>
            </div>
            <div class="container">
            <b> <label>Country : </label> </b>  
            <input type="text"  name="Country" required>
            </div>
            <div class="container">
            <b><label>Nationality : </label> </b>  
            <input type="text"  name="Nationality" required>
            </div>
            <div class="container">
            <button type="submit"><b>Save</button> </b>     
            <button type="button" class="cancelbtn"> <b>Cancel</button></b>
        </div>   
    </form>     
</body>     
</html>  