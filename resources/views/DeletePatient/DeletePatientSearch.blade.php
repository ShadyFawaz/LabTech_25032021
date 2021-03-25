<!DOCTPE html>
<html>
<head>
<title>LabTech Software</title>
<style>   
Body {  
  font-family: times_new_roman, serif;  
  background-color: lightgrey;  
}  
 
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family: times_new_roman,serif;     
        width: 13%;   
        margin: 0px 0px;  
        padding: 1px 0px;   
        display: inline-block;   
        border: 1px  solid;   
        text-align: left;
    }
    input[type=number] {   
        font-family: times_new_roman,serif;     
        width: 13%;   
        margin: 0px 0px;  
        padding: 1px 0px;   
        display: inline-block;   
        border: 1px  solid;   
        text-align: left;
    }
    select {   
        font-family: times_new_roman, serif;     
        width: 15%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 

    label {   
        font-family: times_new_roman, serif;  
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
        background-color: white;  
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
  font-family: times_new_roman, Helvetica, sans-serif; 
  margin-bottom: 10px; 
}

</style>  
</head>
@include('MainMenu')
<body>
<center> <h1  style="background-color:DodgerBlue;"> {{__('title.deletepatient_deletepatient')}} </h1> </center>   

<form method="post" action="{{url('resultsmenu')}}">
            {{method_field('post')}}
            {{csrf_field()}}
            <b><label >{{__('title.datefrom_search')}}  </label>   </b>
            <input type="datetime-local"  name="datefrom" value='{{date("Y-m-d\ H:i")}}'> 
            </div>
            <div >
            <b><label > {{__('title.dateto_search')}}  </label></b>   
            <input type="datetime-local" name="dateto" value='{{date("Y-m-d\ H:i")}}'> 
            </div>
            <div >
            <b><label > {{__('title.patientid_deletepatient')}}  </label></b>   
            <input type="text"  name="patient_id" > 
            </div>
            <div >
            <b><label > {{__('title.visit_no_deletepatient')}}  </label></b>   
            <input type="number" step='1' min='1' name="visit_no" > 
            </div>


           <div> 
           <input type="submit" name="deletepatientsearch" value="{{__('title.deletesearch_btn_deletepatient')}}" >  
           <td><a href = "{{url('deletepatientsearch')}}">{{__('title.clearall_deletepatient_btn')}}</a></td>


</form>


</body>
</html>