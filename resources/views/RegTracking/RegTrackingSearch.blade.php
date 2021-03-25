<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Result Tracking)</title>
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
}  

    table {
        font: 15px/15px Serif;
        border-collapse: collapse;
        width: auto;
        margin: auto;
     
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 5px;
  background-color: white;
}

</style>  
</head>
@include('MainMenu')
<body>

<center> <h1 > {{__('title.reg_tracking')}} </h1> </center>   

<form method="post" action="{{url('regtracking')}}">
            {{method_field('post')}}
            {{csrf_field()}}


<b><label > {{__('title.visit_no_search')}}  </label></b>   
            <input type="number" step='1' min='1' name="visit_no" > 
            <button type="submit"><b>{{__('title.search_btn')}}</button> </b>     

</body>
</html>