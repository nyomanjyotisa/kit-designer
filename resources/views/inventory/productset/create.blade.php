@extends('inventory.layout')
@section('title', 'Add Product set')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Product Set</h5>
                            <span>Add new product set in inventory</span>
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
                                <a href="#">Add Product Set</a>
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
                        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ route('store-product_set') }}">
                            @csrf                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="title">Product set<span class="text-red">*</span></label>
                                        <input id="product_set" type="text" class="form-control w-40 hm-30" name="product_set" value="" placeholder="Enter product name" required="">
                                        <div class="help-block with-errors"></div> 
                                    </div>  
                                    @if(!$parentId)  
                                    @inject('dropdown','App\Http\Controllers\Productset_controller')
                                    <div class="form-group">
                                        <label for="title">Parent Product set<span class="text-red">*</span></label>
                                        <select class="form-control w-40 hm-30" name="parent_product_set" id="parent_product_set"  required="">
                                            <!-- <option value="default">Default</option> -->
                                            {{$dropdown->getParentChild()}}
                                        </select>  
                                        <div class="help-block with-errors"></div> 
                                    </div>
                                    @else
                                    <div class="form-group"> <input type="hidden" name="parent_product_set" @if($parentId==1) value="default" @else value="{{$parentId}}" @endif> </div>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="title">Price<span class="text-red">*</span></label>  
                                        </div>
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <label for="title">$ &nbsp;</label> 
                                                <input type="text"  class="form-control w-60 text-center hm-30" name="price_aud">
                                                <label>&nbsp; AUD <span class="">&nbsp;</span</label> 
                                            </div> 
                                            <div class="form-group">
                                                <label for="title">€ &nbsp;</label> 
                                                <input type="text"  class="form-control w-60 text-center hm-30" name="price_eur">
                                                <label for="title">&nbsp; EUR<span class="">&nbsp;</span></label> 
                                            </div>
                                            <div class="form-group">
                                                <label for="title">£ &nbsp;</label> 
                                                <input type="text"  class="form-control w-60 text-center hm-30" name="price_gbp">
                                                <label for="title">&nbsp; GBP<span class="">&nbsp;</span></label> 
                                            </div>
                                            <div class="form-group">
                                                <label for="title">$ &nbsp;</label> 
                                                <input type="text"   class="form-control w-60 text-center hm-30" name="price_usd">
                                                <label for="title">&nbsp; USD<span class="">&nbsp;</span></label> 
                                            </div> 
                                            <div class="form-group">
                                                <label for="title">$ &nbsp;</label> 
                                                <input type="text"  class="form-control w-60 text-center hm-30" name="price_nzd">
                                                <label for="title">&nbsp; NZD<span class="">&nbsp;</span></label> 
                                            </div> 
                                        </div>
                                  </div> 
                                 
                                  <div class="col-sm-12">   
                                  <br>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="title">Minimum &nbsp;</label>     
                                            <input type="text" class="form-control w-40 text-center hm-30"  name="minimum">
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Discount Levels&nbsp;</label>   
                                            <input type="text" class="form-control w-300 text-center hm-30" name="discountLevel">
                                        </div>
                                        <div class="form-group">
                                        <label for="title"> &nbsp; &nbsp;Disable Discount Levels &nbsp;</label>   
                                            <div class="border-checkbox-section">
                                                <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                    <input class="border-checkbox" type="checkbox" name="DisableDiscountLevels" id="DisableDiscountLevels">
                                                    <label class="border-checkbox-label" for="DisableDiscountLevels"></label>   
                                                </div>   
                                            </div>
                                        </div> 
                                    </div>
                                     <br>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th> 
                                                      Pattern Code 
                                                </th>
                                            </tr>
                                        </thead> 
                                    </table>
                                   <div class="form-inline">
                                    <div class="form-group">
                                            <label for="Men">Men<span class="">&nbsp;</span></label>
                                            <input type="text" name="pattern[men]"  class="form-control w-70 hm-30" id="men">
                                            <span>&nbsp;</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="Men">Women<span class="">&nbsp;</span></label>
                                            <input type="text" name="pattern[women]" class="form-control w-70 hm-30" id="women">
                                        </div> 
                                   </div>
                                   <br>
                                   <div class="form-inline">
                                    <div class="form-group">
                                            <label for="Men">kids<span class="">&nbsp;&nbsp;</span></label>
                                            <input type="text" name="pattern[kids]" class="form-control w-70 hm-30" id="kids"><span class="">&nbsp;</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="Men">Unisex<span class="">&nbsp;&nbsp;&nbsp;</span></label>
                                            <input type="text" name="pattern[unisex]" class="form-control w-70 hm-30" id="unisex">
                                        </div>  
                                   </div>
                                  <br>
                                    <table class="table">
                                        <tr>
                                            <th>Documents</th>
                                        </tr>
                                        <tr>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th><label class="border-checkbox-label" for="name">Name</label></th>
                                                        <th><label class="border-checkbox-label" for="Files">Files</label></th>
                                                        <!-- <th>Upload</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody id="documentAdd">
                                                    <tr>
                                                        <td><input type="text" name="documents[0][]" class="form-control w-40 hm-30"></td>
                                                        <td><input type="file" name="documents_image[0][]"></td>
                                                        <!-- <td><input type="submit" class="btn btn-primary" value="Upload"></td> -->
                                                    </tr>
                                                    <tr>
                                                    <td><input type="text" name="documents[1][]" class="form-control w-40 hm-30"></td>
                                                        <td><input type="file" name="documents_image[1][]"></td>
                                                        <!-- <td><input type="submit" class="btn btn-primary" value="Upload"></td> -->
                                                    </tr>
                                                    <tr>
                                                    <td><input type="text" name="documents[2][]" class="form-control w-40 hm-30"></td>
                                                        <td><input type="file" name="documents_image[2][]"></td>
                                                        <!-- <td><input type="submit" class="btn btn-primary" value="Upload"></td> -->
                                                    </tr> 
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3"><input type="button" class="btn btn-primary" value="Add more fields" id="MoredocumentAdd"> </td>
                                                    </tr> 
                                                </tfoot>
                                            
                                                
                                            </table>
                                        </tr>
                                    </table> 
                                  </div>
                                <div class="col-sm-12">   
                                    <div class="form-group">
                                        <label for="title">Description</label>
                                        <textarea id="productset_description" type="text" rows="5" class="form-control w-40 hm-30" name="productset_description" value="" placeholder="Enter product set description" ></textarea>
                                        <div class="help-block with-errors"></div> 
                                    </div>  
                                </div>
                                <div class="col-sm-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sizes</th>
                                            </tr> 
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="border-checkbox-section ml-3">
                                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                            <input class="border-checkbox" type="checkbox" id="inherit" value="1" name="inherit">
                                                            <label class="border-checkbox-label" for="inherit">Inherit Sizes</label>
                                                        </div>   
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-3">
                                <table class="table">
                                    <thead>
                                        <tr> 
                                            <th>
                                            <div class="border-checkbox-section ml-3">
                                                    <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                        <input class="border-checkbox gendersize"  type="checkbox" id="menSize" value="1" name="menSize">
                                                        <label class="border-checkbox-label" for="menSize"></label>
                                                    </div>   
                                                </div>
                                            </th> 
                                            <th>
                                            <label class="border-checkbox-label" for="menSize">Mens Sizes</label>
                                            </th>
                                            <th><label class="border-checkbox-label" for="Short">Code</label></th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($sizeMens)
                                            @foreach($sizeMens as $menSize)
                                                @if($menSize->gender==1)
                                                <tr> 
                                                <td>
                                                    <div class="border-checkbox-section ml-3">
                                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                            <input class="border-checkbox checkItem" type="checkbox" id="{{$menSize->name}}_{{$menSize->id}}" value="{{$menSize->id}}" name="sizes[{{$menSize->id}}]">
                                                            <label class="border-checkbox-label" for="{{$menSize->name}}_{{$menSize->id}}"></label>
                                                        </div>   
                                                    </div>
                                                    </td> 
                                                    <td>{{$menSize->name}}</td>
                                                    <td>{{$menSize->short}}</td> 
                                                </tr>
                                                @endif
                                            @endforeach 
                                        @endif  
                                    </tbody>
                                </table>
                                </div>
                                <div class="col-sm-3">
                                <table class="table">
                                    <thead>
                                        <tr> 
                                            <th> 
                                                <div class="border-checkbox-section ml-3">
                                                    <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                        <input class="border-checkbox gendersize"  type="checkbox" id="womenSize" value="1" name="menSize">
                                                        <label class="border-checkbox-label" for="womenSize"></label>
                                                    </div>   
                                                </div>
                                            </th>
                                            <th><label class="border-checkbox-label" for="womenSize">Women sizes</label></th>
                                            <th><label class="border-checkbox-label" for="Min">Code</label></th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($sizeWomens)
                                        @foreach($sizeWomens as $womenSize)
                                            @if($womenSize->gender==2)
                                            <tr>
                                            <td>
                                                <div class="border-checkbox-section ml-3">
                                                    <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                        <input class="border-checkbox checkItem" type="checkbox" id="{{$womenSize->name}}_{{$womenSize->id}}" value="{{$womenSize->id}}" name="sizes[{{$womenSize->id}}]">
                                                        <label class="border-checkbox-label" for="{{$womenSize->name}}_{{$womenSize->id}}"></label>
                                                    </div>   
                                                </div>
                                                </td> 
                                                
                                                <td>{{$womenSize->name}}</td>
                                                <td>{{$womenSize->short}}</td>
                                               
                                            </tr>
                                            @endif
                                        @endforeach
                                        
                                        @endif  
                                    </tbody>
                                </table>
                                </div> 
                                <div class="col-sm-3"> 
                                <table class="table">
                                    <thead>
                                        <tr> 
                                            <th>
                                            <div class="border-checkbox-section ml-3">
                                                <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                    <input class="border-checkbox gendersize"  type="checkbox" id="kidSize" value="1" name="kidSize">
                                                    <label class="border-checkbox-label" for="kidSize"></label>
                                                </div>   
                                            </div>    
                                        </th>
                                        <th>  <label class="border-checkbox-label" for="kidSize"> Kids sizes</label></th>
                                        <th><label class="border-checkbox-label" for="Min">Code</label></th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($sizeKids)
                                    @foreach($sizeKids as $kidSize)
                                            @if($kidSize->gender==3)
                                            <tr> 
                                                <td>
                                                <div class="border-checkbox-section ml-3">
                                                    <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                        <input class="border-checkbox checkItem" type="checkbox" id="{{$kidSize->name}}_{{$kidSize->id}}" value="{{$kidSize->id}}" name="sizes[{{$kidSize->id}}]">
                                                        <label class="border-checkbox-label" for="{{$kidSize->name}}_{{$kidSize->id}}"></label>
                                                    </div>   
                                                </div>
                                                </td> 
                                                <td>{{$kidSize->name}}</td>
                                                <td>{{$kidSize->short}}</td>
                                                
                                            </tr>
                                            @endif
                                        @endforeach 
                                        @endif  
                                    </tbody>
                                </table>
                                </div>
                                <div class="col-sm-3">
                                <table class="table">
                                    <thead>
                                        <tr> 
                                            <th>
                                               <div class="border-checkbox-section ml-3">
                                                    <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                        <input class="border-checkbox gendersize"  type="checkbox" id="unisexSize" value="1" name="unisexSize">
                                                        <label class="border-checkbox-label" for="unisexSize"></label>
                                                    </div>   
                                                </div>

                                            </th>
                                            <th> <label class="border-checkbox-label" for="unisexSize">Unisex sizes</label></th>
                                            <th><label class="border-checkbox-label" for="Min">Code</label></th> 
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($sizeUnisex)
                                    @foreach($sizeUnisex as $unisexSize)
                                            @if($unisexSize->gender==26)
                                            <tr> 
                                                <td>
                                                <div class="border-checkbox-section ml-3">
                                                    <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                        <input class="border-checkbox checkItem" type="checkbox" id="{{$unisexSize->name}}_{{$unisexSize->id}}" value="{{$unisexSize->id}}" name="sizes[{{$unisexSize->id}}]">
                                                        <label class="border-checkbox-label" for="{{$unisexSize->name}}_{{$unisexSize->id}}"></label>
                                                    </div>   
                                                </div>
                                                </td> 
                                                <td>{{$unisexSize->name}}</td>
                                                <td>{{$unisexSize->short}}</td> 
                                            </tr>
                                            @endif
                                        @endforeach 
                                        @endif 
                                    </tbody>
                                </table>
                                </div>
                                <div class="col-sm-12"> 
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Save</button>
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
        $("#MoredocumentAdd").click(function(){ 
            var countTables =  $("#documentAdd tr").length; 
            var addFields =  
                                '<tr>'+
                                    '<td>'+
                                    '<div class="form-group">'+ 
                                        '<input type="text" name="documents['+countTables+']" class="form-control w-40 hm-30">'+
                                    '</div>'+  
                                    '</td>'+
                                    '<td>'+
                                    '<div class="form-group">'+ 
                                        '<input type="file" name="documents_image['+countTables+'][]">'+
                                    '</div> '+
                                    '</td>'+ 
                                '</tr>'+
                            '</table>'; 
            $("#documentAdd").append(addFields); 
        });

        // $(".deleteRow").click(function(){
        //     console.log("remove Row");
        //     $(this).parent().remove(); 
        // });
        $('#inherit').click(function () {
            if (this.checked) {
                $(':checkbox.checkItem').prop('disabled', "disabled");    
                $(':checkbox.gendersize').prop('checked',"");    
            }else{
                $(':checkbox.checkItem').prop('disabled', "");    
                $(':checkbox.gendersize').prop('checked',"checked");    
            }
        });
    </script>
@endsection
 