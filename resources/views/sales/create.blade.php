@extends('inventory.layout') 
@section('title', 'Add Sale')
@section('content')
	<div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-shopping-cart bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Sale</h5>
                            <span>Create Sales Entry</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Add Sale</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            <div class="col-md-12">
        </div>            <!-- end message area-->
            <div class="col-md-12">
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                @endif 

                @if (\Session::has('error'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{!! \Session::get('error') !!}</li>
                        </ul>
                    </div>
                @endif 
                <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{route('store-sales')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 pr-0">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Delivery Date</label>
                                      
                                        <input type="text" class="form-control datetimepicker-input" id="datepicker" data-toggle="datetimepicker" name="delilvery_date" id= "delilvery_date" data-target="#datepicker" placeholder="Select Date" value="">
                                    </div> 
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-10 pr-0">
                                                <label>Customer</label> 
                                                <select class="form-control select2" name="customerid" id="customerid">
                                                	<option selected="selected" value="" data-select2-id="3">Select Customer</option>
                                                	@if($customer)
                                                        @foreach($customer as $val)
                                                            <option @if(old('customerid')==$val->id) selected='selected' @endif value="{{$val->id}}" >{{$val->name}}</option>
                                                        @endforeach
                                                    @endif
                                               </select> 
                                            </div>
                                            <div class="col-sm-2 pl-1 pt-1">
                                                <button type="button" class="mt-4 btn btn-sm btn-primary" data-toggle="modal" data-target="#CustomerAdd">+</button>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Customer Order NO</label>
                                        <input type="text" value="{{old('orderno')}}" class="form-control" name="orderno" id="orderno" placeholder="Enter Order NO">
                                    </div>
                                    <div class="form-group">
                                        <label>Upload spec. sheet (pdf)</label>
                                        <input type="file" name="attachment" id="attachment" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Note</label>
                                        <textarea class="form-control h-123" name="note" id="note" placeholder="Enter Note">{{old('note')}}</textarea> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <select class="form-control select2" name="source" id="source">
                                                	<option selected="selected" value="" data-select2-id="6">Select Source</option>
                                                	<option @if(old('source')==1) selected='selected' @endif value="1">Create a New Order</option>
                                                	<option @if(old('source')==2) selected='selected' @endif  value="2">Add Order From Saved Designs</option>
                                                	<option @if(old('source')==3) selected='selected' @endif  value="3">Add Order from Quote Requests</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                        @inject('dropdown','App\Http\Controllers\Productset_controller')
                                            <div class="form-group"> 
                                                <select name="productset" id="design_product_set_id" class="form-control select2">
                                                  {{$dropdown->getParentChild()}}
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="salestable" id="sizes_box_new">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="wp-5">SL</th>
                                                    <th class="wp-15">Product</th> 
                                                    <th class="wp-80">Qty</th> 
                                                </tr>
                                            </thead>
                                            <!-- <tbody>
                                                <tr>
                                                    <td>1.</td>
                                                    <td> <img src="../img/widget/p1.jpg" alt="" class="img-fluid img-20"> HeadPhone</td>
                                                    <td>
                                                    <table class="table">
                                                        <tr>
                                                            <td>Mens</td> 
                                                            <td>
                                                                <label for="">small</label>
                                                                <input type="text" name="shiping" class="form-control w-60 text-center hm-30" value="5">
                                                            </td>
                                                            <td>
                                                                <label for="">x small</label>
                                                                <input type="text" name="shiping" class="form-control w-60 text-center hm-30" value="5">
                                                            </td>
                                                            <td>
                                                                <label for="">x small</label>
                                                                <input type="text" name="shiping" class="form-control w-60 text-center hm-30" value="5">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mens</td> 
                                                            <td>
                                                                <label for="">small</label>
                                                                <input type="text" name="shiping" class="form-control w-60 text-center hm-30" value="5">
                                                            </td>
                                                            <td>
                                                                <label for="">x small</label>
                                                                <input type="text" name="shiping" class="form-control w-60 text-center hm-30" value="5">
                                                            </td>
                                                            <td>
                                                                <label for="">x small</label>
                                                                <input type="text" name="shiping" class="form-control w-60 text-center hm-30" value="5">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                 
                                                </tr> 
                                            </tbody> -->
                                        </table> 
                                    </div>
                                    <!-- <div class="row" id="sizes_box_new">
                                
                                    </div>   -->
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Sale Status</label>
                                                <select class="form-control" name="sale_status" id="sale_status">
                                                    <option selected="">Select Sale Status</option>
                                                    <option @if(old('sale_status')=='completed') selected='selected' @endif value="completed">Completed</option>
                                                    <option @if(old('sale_status')=='Shipped') selected='selected' @endif  value="shipped">Shipped</option>
                                                    <option @if(old('sale_status')=='Pending') selected='selected' @endif  value="pending">Pending</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Payment Status</label>
                                                <select class="form-control" name="payment_status" id="payment_status">
                                                    <option selected="">Select Payment Status</option>
                                                    <option @if(old('payment_status')=='Pending') selected='selected' @endif value="pending">Pending</option>
                                                    <option @if(old('payment_status')=='Due') selected='selected' @endif value="Due">Due</option>
                                                    <option @if(old('payment_status')=='Paid') selected='selected' @endif value="Paid">Paid</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <!-- <div class="form-group">
                                                <label>Pay</label>
                                                <input type="text" name="pay" class="form-control text-center  ml-auto" value="" placeholder="Amount">
                                            </div> -->
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="pt-4 text-right">
                                                <!-- <div type="button" class="btn btn-danger" data-toggle="modal" data-target="#InvoiceModal">Preview Invoice</div> -->
                                                <button type="submit" name="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                        
            </div>

                            
        </div>
    </div>
    <div class="modal fade edit-layout-modal pr-0 " id="CustomerAdd" role="dialog" aria-labelledby="CustomerAddLabel" aria-hidden="true">
        <div class="modal-dialog w-300" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CustomerAddLabel">Add Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('store-customer')}}"> 
                        @csrf
                        <div class="form-group">
                            <label class="d-block">Customer Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Customer Name">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter Phone">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control select2" name="country">
                            	<option selected="selected" value="">Select Country</option>
                                @foreach($country as $val)
                                  <option value="{{$val->sortname}}" >{{$val->country_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="d-block">City</label>
                            <input type="text" name="city" class="form-control" placeholder="Enter City">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="Save" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
     var controller_url = "{{ url('sales/getSize') }}" ; 
     $("#design_product_set_id").change(function(){
           var productSetId = $(this).val();
           var productset = $("#design_product_set_id option:selected").text(); 
           productset = productset.replace(/([-,.€~!@#$%^&*()_+=`{}\[\]\|\\:;'<>])+/g, '');  
           $.ajax({
                url: controller_url+"/"+productSetId,
                type: "get",
                data: { id : productSetId },
                success: function(data){
                    var obj = JSON.parse(data);
                    console.log(obj);
                    // var addSize = "";
                    var add_sizes_new = "<table class='table'><thead><tr><th>Sr.</th><th>Product Set</th><th>Qty</th></tr></thead><tbody><tr><td>1.</td><td>"+productset+"</td>";
                    add_sizes_new += "<td>"
                    $.each(obj, function(key, item) {  
                        // add_sizes_new +=  "";
                        add_sizes_new += "<table class='table'><tr><td  class='wp-15'>"+key+"</td>";
                        // addSize += "<div class='col-sm-3'><table class='table'>";
                        // addSize += "<thead><tr><th colspan='2'>"+key+" sizes</th><th>Code</th></tr></thead><tbody>"; 
                        $.each(item, function(key_1, item_1) {
                            let qty = item_1['qty'];
                            if(qty==null){
                                qty = 0;
                            }
                            // addSize += "<tr><td><input type='number' class='form-control w-60 text-center hm-30' value='"+qty+"' name='sizeqty["+item_1['id']+"]'><input type='hidden' value='"+item_1['id']+"' name='sizes[]'></td><td>"+item_1['name']+"</td><td>"+item_1['short']+"</td></tr>";

                            add_sizes_new += "<td><label>"+item_1['short']+"</label><input type='text' name='qty[]["+item_1['id']+"]' class='form-control w-60 text-center hm-30' value='0'></td>";
                        });
                        // addSize += "</tbody></table></div>";
                        add_sizes_new +=  "</tr></table>"; 
                    }); 
                    add_sizes_new += "</td>"
                      add_sizes_new +=  "</tr></tbody></table>";
                    // $("#sizes_box").html(addSize);
                    $("#sizes_box_new").html(add_sizes_new);
                }
            });


        });
</script>
@endsection