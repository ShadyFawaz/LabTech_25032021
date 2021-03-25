<!DOCTPE html>
<html>
<head>
<title>LabTech Software</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  
 
 form {   
    }   
 input[type=text] {   
        font-family: serif;     
        width: 15%;   
        margin: 0px 0px;  
        padding: 1px 0px;   
        display: inline-block;   
        border: 1px  solid;   
        text-align: left;
    }
    input[type=datetime] {   
        font-family: serif;     
        width: 15%;   
        margin: 0px 0px;  
        padding: 1px 0px;   
        display: inline-block;   
        border: 1px  solid;   
        text-align: left;
    }
    input[type=number] {   
        font-family: serif; 
        font-weight: bold;    
        width: 15%;   
        margin: 0px 0px;  
        padding: 1px 0px;   
        display: inline-block;   
        border: 1px  solid;   
        text-align: left;
    }
    select {   
        font-family:  serif;     
        width: 15% !important;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
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
    input[type=button] {   
        color:black;   
    } 
        
     
 .container {   
        padding: 0px;  
        margin: 0px 0;  
        background-color: white;  
    }   

    table {
        font:normal 13px/13px  Sans-Serif;
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
  font-family:  serif; 
  margin-bottom: 10px; 
}

</style>  
@include('MainMenu')
</head>
<body>
<center> <h1 > {{__('title.searchresultsbyday')}} </h1> </center>   

<form method="post" action="{{url('resultsmenu')}}">
            {{method_field('post')}}
            {{csrf_field()}}
            <b><label >{{__('title.datefrom_search')}}  </label>   </b>
            <input type="datetime"  name="datefrom" value="{{Carbon\Carbon::now()->format('Y-m-d\ 00:00')}}"> 
            
            <b><label > {{__('title.patient_id_search')}}  </label></b>   
            <input type="text"  name="patient_id" > 
            </div>


            <div>
            <b><label > {{__('title.dateto_search')}}  </label></b>   
            <input type="datetime" name="dateto" value="{{Carbon\Carbon::now()->format('Y-m-d\ 23:59')}}"> 
          
            <b><label > {{__('title.visit_no_search')}}  </label></b>   
            <input type="number" step='1' min='1' name="visit_no" > 
            </div>

            <b><label style="color:purple;" >{{__('title.rank_pricelist_search')}} </label> </b>  
        <select name="rank_pricelist_id" id="rank_pricelist_id" class="lg dynamic" data-dependent="relative_pricelist_id" data-type="relative_pricelist_name">
        <option value="">Select Price List</option>
        @foreach($RelativePriceLists as $relativepricelist)
        <option value="{{ $relativepricelist->rank_pricelist_id}}">{{ $relativepricelist->rankpricelists->rank_pricelist_name }}</option>
        @endforeach
        </select>
        </div>

        <b><label style="color:purple;" >{{__('title.relative_pricelist_search')}} </label> </b>  
        <select name="relative_pricelist_id" id="relative_pricelist_id" class="lg dynamic" >
        <option value="">Relative Price list</option>
        </select>
        </div>
    </div>

            <div >
            <b><label > {{__('title.group_search')}}   </label> </b>  
            <select name="group">
            <option value="">Choose Group</option>
            @foreach($Groups as $group)
               <option value="{{$group->group_id}}" >{{$group->group_name}}</option>
            @endforeach
            </select> 
       
           
            <b><label > {{__('title.testname_search')}} </label> </b>  
            <select id ="selecttest_id" name="selecttest_id" >
            <option value="" >Choose Test
            @foreach($MegaTests as $megatest )
               <option  id="megatest_id" name="megatest_id" value="{{$megatest->megatest_id}}" >{{$megatest->test_name}}</option>
            @endforeach
            @foreach($GroupTests as $grouptest )
               <option  id="grouptest_id" name="grouptest_id" value="{{$grouptest->grouptest_id}}" >{{$grouptest->test_name}}</option>
            @endforeach
            @foreach($TestData as $test)
               <option id="test_id" name="test_id" value="{{$test->test_id}}" >{{$test->abbrev}}</option>
            @endforeach
            </option>
            </select> 
           


         

            <div >
            <input type="checkbox" name="completed" value='1'> 
            <b><label > {{__('title.completed_search')}}  </label></b>   
            <input type="checkbox" name="verified" value='1'> 
            <b><label > {{__('title.verified_search')}}  </label></b> 
            <input type="checkbox" name="printed" value='1'> 
            <b><label > {{__('title.printed_search')}}  </label></b>     
            </div>


            <div >
            <input type="checkbox" name="notcompleted" value='1'> 
            <b><label > {{__('title.notcompleted_search')}}  </label></b>   
    
            <input type="checkbox" name="notverified" value='1'> 
            <b><label > {{__('title.notverified_search')}}  </label></b>  
            <input type="checkbox" name="notprinted" value='1'> 
            <b><label > {{__('title.notprinted_search')}}  </label></b>    
            </div>
           <div> 
           <input type="submit" name="searchResultsByDay" value="{{__('title.searchresultsbyday_btn')}}" >  
           <a><input type="button" onclick="location.href='{{url('searchresultsbyday')}}'" value="{{__('title.clearall_search_btn')}}" ></input></a>




</form>
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" ></script>  -->
<script>
$().ready(function(){

 $('.dynamic').change(function(){
  if($(this).val() != '')
  {
   var select    = $(this).attr("id");
   var value     = $(this).val();
   var dependent = $(this).data('dependent');
   var nam       = $(this).data('type');
   console.log(nam);
   console.log(dependent);

   var _token    = $('input[name="_token"]').val();
//    $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }   
//     });
   $.ajax({
    url:"{{ route('dynamicdependent.fetch') }}",
    method:"POST",
    data:{select:select, value:value, _token:_token, dependent:dependent ,nam:nam},
    success:function(result)
    {
     $('#'+dependent).html(result);
    }
   })
  }
 });

  $('#pricelist_id').change(function(){
  $('#relative_pricelist_id').val('');
 });
 

});
</script>

</body>
</html>