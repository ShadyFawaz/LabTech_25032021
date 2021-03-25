<!DOCTYPE html>   
<html>  
@if(isset(Auth::user()->login_name))
   @else
    <script>window.location = "{{url('/')}}";</script>
   @endif 
<head>    
<title>LabTech Software</title> 
@if(isset(Auth::user()->login_name))
@include('MainMenu')
@endif
</head>
<body> 
<!-- <br>
<br> -->
@if(isset(Auth::user()->login_name))
<div>
     <strong>User Name : {{ Auth::user()->user_name }}</strong>
     <br />
     <a href="{{ url('/logout') }}">Logout</a>
    </div>
    @endif
    </div>
    
<div class="content" >
  <center><h3 style="font-size:50px;color:black"> LabTech software</h3></center>
  <center><p style="font-size:50px;color:black">Medical Laboratories Solutions</p></center>
</div>     
</body>     
</html>  