<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> Login </title>  
<style>   
Body {  
  font-family: times_new_roman, Helvetica, sans-serif;  
  background-color: lightgrey;  
}  
button {   
        font-family: times_new_roman, Helvetica, sans-serif;
        background-color: grey;   
        width: auto;  
        color: Black;   
        padding: 10px;   
        margin: 10px 0px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text], input[type=password] {   
        font-family: times_new_roman, Helvetica, sans-serif;  
        width: 25%;   
        margin: 5px 0;  
        padding: 8px 5px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;
        text-align: left;   
    }  

    label {
        font-family: times_new_roman, Helvetica, sans-serif;     
        width: 8%;   
        margin: 0px 0;  
        padding: 5px 5px;  
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;  
        text-align: left; 
    }  
 button:hover {   
        opacity: 0.7;   
    }   
  .cancelbtn {  
    font-family: times_new_roman, Helvetica, sans-serif;
        background-color: grey;   
        width: auto%;  
        color: Black;   
        padding: 10px;   
        margin: 10px 0px;   
        border: none;   
        cursor: pointer;   
         }      
        
         .backbtn {  
    font-family: times_new_roman, Helvetica, sans-serif;
        background-color: white;   
        width: auto%;  
        color: Black;   
        padding: 5px;   
        margin: 10px 0px;   
        border: none;   
        cursor: pointer; 
        text-align: left;   
         }      
     
 .container {   
        padding: 0px;   
        background-color: #B9CDE5;  
    }   
</style>   
</head>    
</head>
    <body>
        <h1>Simple Login Page</h1>
        <form name="login">
            Username<input type="text" name="userid"/>
            Password<input type="password" name="pswrd"/>
            <input type="button" onclick="check(this.form)" value="Login"/>
            <input type="reset" value="Cancel"/>
        </form>
        <script language="javascript">
            function check(form) { /*function to check userid & password*/
                /*the following code checkes whether the entered userid and password are matching*/
                if(form.userid.value == form.pswrd.value) {
                    window.open('patientreg')/*opens the target page while Id & password matches*/
                }
                else {
                    alert("Error Password or Username")/*displays error message*/
                }
            }
        </script>
    </body>
</html>  