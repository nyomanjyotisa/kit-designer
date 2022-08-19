@extends('inventory.layout')
@section('title', 'Add Order')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Order</h5>
                            <span>Create a new order</span>
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
                                <a href="#">Add Order</a>
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
                        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ route('store-order') }}">
                            @csrf                            
                            <div class="row">  
                                <!-- @if (\Session::has('orders'))
                                  @php $orders = \Session::get('orders') @endphp
                                  {{$orders->firstname}}
                                @endif -->
                                <div class="col-sm-6"> 
                                    <div class="form-group" data-select2-id="295">
                                        <div class="row" data-select2-id="294">
                                            <div class="col-sm-2 pl-1 pt-1">
                                                <div class="text-center"> 
                                                    <img src="../img/images.png" class="img-responsive" width="80"> 
                                                </div>
                                            </div> 
                                            <div class="col-sm-8 pr-0" data-select2-id="293">
                                                <label>Organization</label> 
                                                <select class="form-control organizations select2">
                                                    <option selected="selected" value="" data-select2-id="6">Select Organization</option>
                                                    <option value="1">Organization 1</option>
                                                    <option value="2">Organization 2</option>
                                                </select> 
                                            </div>
                                            <div class="col-sm-2 pl-1 pt-1">
                                                <button type="button" class="mt-4 btn btn-sm btn-primary" data-toggle="modal" data-target="#OrganizationAdd" >+ Add new</button>
                                            </div> 
                                        </div> 
                                    </div>  
                                    <div class="form-group">
                                        <label for="title">First name<span class="text-red">*</span></label>
                                        <input type="text" name="firstname" id="firstname" value="" class="form-control w-100 hm-30">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Last name<span class="text-red">*</span></label>
                                        <input type="text" name="lastname" id="lastname" value="" class="form-control w-100 hm-30">
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Address<span class="text-red">*</span></label>
                                        <input type="text" name="address" id="address" value="" class="form-control w-100 hm-30">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">City<span class="text-red">*</span></label>
                                        <input type="text" name="city" id="city" value="" class="form-control w-100 hm-30">
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Post code<span class="text-red">*</span></label>
                                        <input type="text" name="postcode" id="postcode" value="" class="form-control w-100 hm-30">
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <div class="form-group">
                                        <label for="title">Country<span class="text-red">*</span></label>
                                        <select name="country" id="country" value="" class="form-control w-100 hm-30 select2">
                                                <option value="">Select country</option>
                                                @foreach($country as $val)
                                                <option value="{{$val->sortname}}" >{{$val->country_name}}</option>
                                                @endforeach
                                        </select>
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Email address<span class="text-red">*</span></label>
                                        <input type="text" name="emailaddress" id="emailaddress" value="" class="form-control w-100 hm-30">
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Mobile phone<span class="text-red">*</span></label>
                                        <input type="text" name="mobilephone" id="mobilephone" value="" class="form-control w-100 hm-30">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Work phone<span class="text-red">*</span></label>
                                        <input type="text" name="workphone" id="workphone" value="" class="form-control w-100 hm-30">
                                    </div>  
                                    <div class="form-group">
                                        <label for="title">Shipping Deadline<span class="text-red">*</span></label>
                                        <input type="date" name="shippingdeadline" id="shippingdeadline" value="" class="form-control w-100 hm-30">
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
                                            {{$dropdown->getParentChild()}}
                                        </select>
                                        <div class="help-block with-errors"></div> 
                                    </div>   
                                    <div class="form-group">
                                        <label for="sizes">Sizes</label>
                                    </div> 
                                </div> 
                            </div>
                            <div class="row" id="sizes_box">
                                
                            </div>
                            <div class="row">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>Upload Spec Document</td>
                                            <td></td>
                                        </tr> 
                                    </thead> 
                                    <tbody>
                                        <tr>
                                            <td><input type="text" class="form-control w-80 text-center hm-30"></td>
                                            <td><input type="file" ></td>
                                        </tr> 
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group text-right w-100 hm-30">
                                        <button type="submit" class="btn btn-primary">Save & Continue</button>
                                    </div>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- category edit modal --> 
 <div class="modal fade edit-layout-modal pr-0 " id="OrganizationAdd" tabindex="-1" role="dialog" aria-labelledby="addOrganizationLabel" aria-hidden="true">
        <div class="modal-dialog w-300" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryEditLabel">{{ __('Add Organization')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body"> 
                    <form method="post" enctype="multipart/form-data" action="{{route('store-organization')}}">
                        @csrf
                        <div class="form-group">
                            <label class="d-block">Organization</label> 
                            <input type="text" name="organizationname" id="organizationname" required="" class="form-control" placeholder="Enter Organization">
                        </div> 
                        <div class="form-group">
                            <label class="d-block">Image</label> 
                            <input type="file" name="organiztion_img" id="organiztion_img" required="" class="form-control" placeholder="Enter Organization">
                        </div> 
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="Save" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    <!-- category edit modal -->
    
    <script>
        var controller_url = "{{ url('organization/getOrganization') }}";
        $(document).ready(function() { 
            $(".organizations").html("<option value=''>Select Organization</option>");
            // load if sizes with quantity presents start 
            $.ajax({
                    url: controller_url,
                    type: "get",
                    // data: { id : productSet },
                    success: function(data){ 
                        var obj = JSON.parse(data);
                        $.each(obj, function(key, item) { 
                           $(".organizations").append("<option>"+item.organization+"</option>");
                        }); 
                        
                    }
                });
            // load if sizes with quantity presents end
            var curl = "{{ url('orders/getSize') }}" ; 
            $("#design_product_set_id").change(function(){
           var productSetId = $(this).val();
           $.ajax({
                url: curl+"/"+productSetId,
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
                            addSize += "<tr><td><input class='form-control w-60 text-center hm-30' type='number' value='"+qty+"' name='sizeqty["+item_1['id']+"]'><input type='hidden' value='"+item_1['id']+"' name='sizes[]'></td><td>"+item_1['name']+"</td><td>"+item_1['short']+"</td></tr>";
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


 