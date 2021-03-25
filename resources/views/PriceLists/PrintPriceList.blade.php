<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Print Price List)</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: white;  
}  
   
    table {
        font:normal 13px/13px  Serif;
        font-weight:bold;
        border-collapse: collapse;
        width: 80%;
        margin:auto;
}
 th {
   font-size:18px;
   line-height:20px;
  border: 1px solid #dddddd;
  text-align: left;
  padding: 5px;
  background-color: lightgrey;
}
td {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 5px;
  background-color: white;
}
tr:nth-child(even) {
  background-color: white;
}


</style>  
</head>
<body>

@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<center> <h4 style="font-size:20px;font-weight:bold;"> Price List : {{ $users[0]->PriceLists->price_list }} </h4> </center>   
@endif


  <table id="myTable">
            <tr>
<th>{{__('title.test_name_priceliststests')}}</th>
<th>{{__('title.price_priceliststests')}}</th>
</tr>
@foreach ($users as $user)
<tr>
@if($user->megatest_id)
<td>{{ $user->megaTests->test_name }}</td>
@endif
@if($user->grouptest_id)
<td>{{ $user->GroupTests->test_name }}</td>
@endif
@if($user->test_id)
<td>{{ $user->TestData->abbrev }}</td>
@endif
<td>{{$user->price}}</td>
</tr>
@endforeach
</table>
<hr style="border:double;">

 <b style="font-size:12px;"> Printed By : @if(isset(Auth::user()->login_name))
{{ (Auth::user()->user_name) }}
@endif
</b> 

</html>