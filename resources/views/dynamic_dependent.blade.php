<!DOCTYPE html>
<html>
 <head>
  <title>Ajax Dynamic Dependent Dropdown in Laravel</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
    border:1px solid #ccc;
   }
  </style>
 </head>
 <body>
  <br />
  <div class="container box">
   <h3 align="center">Ajax Dynamic Dependent Dropdown in Laravel</h3><br />
   <div class="form-group">
    <select name="Relative Price List" id="pricelist_id" class="form-control input-lg dynamic" data-dependent="relative_pricelist_name">
     <option value="">Select Price List</option>
     @foreach($PriceLists as $pricelist)
     <option value="{{ $pricelist->pricelist_id}}">{{ $pricelist->pricelist_id }}</option>
     @endforeach
    </select>
   </div>
   <br />
   <div class="form-group">
    <select name="relative_pricelist_name" id="relative_pricelist_name" class="form-control input-lg dynamic" >
     <option value="">Relative Price list</option>
    </select>
   </div>
   <br />
   <div class="form-group">
    <select name="city" id="city" class="form-control input-lg">
     <option value="">Select City</option>
    </select>
   </div>
   {{ csrf_field() }}
   <br />
   <br />
  </div>
 </body>
</html>

<script>
$().ready(function(){
console.log(document);
 $('.dynamic').change(function(){
  if($(this).val() != '')
  {
   var select    = $(this).attr("id");
   var value     = $(this).val();
   var dependent = $(this).data('dependent');
   var name      = $(this).data('name');
   var _token    = $('input[name="_token"]').val();
   $.ajax({
    url:"{{ route('dynamicdependent.fetch') }}",
    method:"POST",
    data:{select:select, value:value, _token:_token, dependent:dependent},
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
