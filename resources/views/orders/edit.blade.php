@extends('inventory.layout')
@section('title', 'Edit Order')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Order</h5>
                            <span>Add new Order in inventory</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                            <a href="#">Orders</a>
                            </li> 
                            <li class="breadcrumb-item">
                                <a href="#">Edit Order</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body">
                        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ route('update-order') }}">
                            @csrf                            
                            <div class="row">  
                                <!-- @if (\Session::has('orders'))
                                  @php $orders = \Session::get('orders') @endphp
                                  {{$orders->firstname}}
                                @endif -->
                                <input type="hidden" name="id" value="{{$orders->id}}">
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label for="title">First name<span class="text-red">*</span></label>
                                        <input type="text" name="firstname" id="firstname" value="{{$orders->firstname}}" class="form-control w-100 hm-30">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Last name<span class="text-red">*</span></label>
                                        <input type="text" name="lastname" id="lastname" value="{{$orders->lastname}}" class="form-control w-100 hm-30">
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Address<span class="text-red">*</span></label>
                                        <input type="text" name="address" id="address" value="{{$orders->address}}" class="form-control w-100 hm-30">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">City<span class="text-red">*</span></label>
                                        <input type="text" name="city" id="city" value="{{$orders->city}}" class="form-control w-100 hm-30">
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Post code<span class="text-red">*</span></label>
                                        <input type="text" name="postcode" id="postcode" value="{{$orders->postcode}}" class="form-control w-100 hm-30">
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <div class="form-group">
                                        <label for="title">Country<span class="text-red">*</span></label>
                                        <select name="country" id="country" value="" class="form-control w-100 hm-30">
                                                <option value="">Select country</option>
                                                @foreach($country as $val)
                                                    <option @if($val->sortname==$orders->country) selected="selected" @endif value="{{$val->sortname}}" >{{$val->country_name}}</option>
                                                @endforeach
                                        </select> 
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Email address<span class="text-red">*</span></label>
                                        <input type="text" name="emailaddress" id="emailaddress" value="{{$orders->emailaddress}}" class="form-control w-100 hm-30">
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Mobile phone<span class="text-red">*</span></label>
                                        <input type="text" name="mobilephone" id="mobilephone" value="{{$orders->mobilephone}}" class="form-control w-100 hm-30">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Work phone<span class="text-red">*</span></label>
                                        <input type="text" name="workphone" id="workphone" value="{{$orders->workphone}}" class="form-control w-100 hm-30">
                                    </div>  
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group text-right w-100 hm-30">
                                        <button type="submit" class="btn btn-primary" name="SaveAndContinue" value="SaveAndContinue">Save & Continue</button>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Add Item</th>
                                            </tr>
                                        </thead> 
                                    </table> 
                                    @inject('dropdown','App\Http\Controllers\Productset_controller')
                                    <div class="form-group">
                                        <label for="title">Product Set</label>
                                        <select name="design_product_set_id" id="design_product_set_id" class="form-control w-100">
                                            <option value="">Default</option>
                                            {{$dropdown->getParentChild_edit($orders->productset_id)}}
                                        </select>
                                        <div class="help-block with-errors"></div> 
                                    </div>   
                                    <div class="form-group">
                                        <label for="sizes">Sizes</label>
                                    </div> 
                                </div> 
                            </div>
                            @php $jsonDecode = []; 
                            $orderqty = "";
                            @endphp
                            @if(isset($orders->qty))
                                @php 
                                    $orderqty = $orders->qty; 
                                    $jsonDecode = json_decode($orderqty,true);
                                @endphp
                            @endif
                             
                            <div class="row" id="sizes_box">
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-12"> 
                                    <div class="form-group text-right w-100 hm-30">
                                        <button type="submit" class="btn btn-primary" name="addSizes" value="addsize">Add to order</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    var controller_url = "{{ url('orders/getSize') }}" ; 
    $(document).ready(function() {

        // load if sizes with quantity presents start
        var productSet= "{{$orders->productset_id}}"; 
 
           $.ajax({
                url: controller_url+"/"+productSet,
                type: "get",
                data: { id : productSet },
                success: function(data){
                    var obj = JSON.parse(data);
                    var addSize = "";
                    $.each(obj, function(key, item) { 
                        addSize += "<div class='col-sm-3'><table class='table'>";
                        addSize += "<thead><tr><th colspan='2'>"+key+" sizes</th><th>Code</th></tr></thead><tbody>"; 
                        $.each(item, function(key_1, item_1) {  
                            let qty = item_1['qty'];
                            if(qty==null){
                                qty = 0;
                            }
                            addSize += "<tr><td><input type='number' value='"+qty+"' name='sizeqty["+item_1['id']+"]'><input type='hidden' value='"+item_1['id']+"' name='sizes[]'></td><td>"+item_1['name']+"</td><td>"+item_1['short']+"</td></tr>";
                        });
                        addSize += "</tbody></table></div>";
                    }); 
                    $("#sizes_box").html(addSize);
                }
            });
        // load if sizes with quantity presents end


        $("#design_product_set_id").change(function(){
           var productSetId = $(this).val();
           $.ajax({
                url: controller_url+"/"+productSetId,
                type: "get",
                data: { id : productSetId },
                success: function(data){
                    var obj = JSON.parse(data);
                    console.log(obj);
                    var addSize = "";
                    $.each(obj, function(key, item) { 
                        addSize += "<div class='col-sm-3'><table class='table'>";
                        addSize += "<thead><tr><th colspan='2'>"+key+" sizes</th><th>Code</th></tr></thead><tbody>"; 
                        $.each(item, function(key_1, item_1) {
                            let qty = item_1['qty'];
                            if(qty==null){
                                qty = 0;
                            }
                            addSize += "<tr><td><input type='number' value='"+qty+"' name='sizeqty["+item_1['id']+"]'><input type='hidden' value='"+item_1['id']+"' name='sizes[]'></td><td>"+item_1['name']+"</td><td>"+item_1['short']+"</td></tr>";
                        });
                        addSize += "</tbody></table></div>";
                    }); 
                    $("#sizes_box").html(addSize);
                }
            });


        });
    });

 </script>
@endsection
 