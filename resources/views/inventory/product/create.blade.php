@extends('inventory.layout')
@section('title', 'Add Product')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Product</h5>
                            <span>Add new product in inventory</span>
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
                                <a href="#">Add Product</a>
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
                        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ route('store-product') }}">
                            @csrf                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title">Name<span class="text-red">*</span></label>
                                        <input id="product_name" type="text" class="form-control" name="product_name" value="" placeholder="Enter product product name" required="">
                                        <div class="help-block with-errors"></div> 
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Author<span class="text-red">*</span></label>
                                        <input id="product_author" type="text" class="form-control" name="product_author" value="" placeholder="Enter product Author" required="">
                                        <div class="help-block with-errors"></div> 
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Parent Product Set<span class="text-red">*</span></label> 
                                        <select class="form-control" name="productSet" >
                                            <option selected="selected" value="" >Default</option>
                                            <option value="Outershells">...Outershells</option>
                                            <option value="Spray Jacket">......Spray Jacket</option>
                                        </select>
                                        <div class="help-block with-errors"></div>  
                                    </div>
                                        <div class="form-group">
                                            <label>Sizes</label>
                                            <table class="table">
                                                <tr>
                                                    <td>
                                                        <table class="table">
                                                            <tr>
                                                                <th>  
                                                                    <div class="border-checkbox-section ml-3">
                                                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                                            <input class="border-checkbox" type="checkbox" id="checkbox1" value="1">
                                                                            <label class="border-checkbox-label" for="checkbox1"></label>
                                                                        </div>   
                                                                </div>
                                                                </th>
                                                                <th>Mens Sizes</th>
                                                                <th>Short</th>
                                                                <th>Min in UK</th>
                                                                <th>Min in AU</th>
                                                                <th>Min in EU</th>
                                                                <th>Min in US</th>
                                                            </tr> 
                                                            <tr>
                                                                <td>Shoes 36</td>
                                                                <td>S 36</td>
                                                                <td><input type="text" value="0"  size="4"></td>
                                                                <td><input type="text" value="0"  size="4"></td>
                                                                <td><input type="text" value="0"  size="4"></td>
                                                                <td><input type="text" value="0"  size="4"></td>
                                                                <td><input type="text" value="0"  size="4"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Shoes 38</td>
                                                                <td>S 38</td>
                                                                <td><input type="text" value="0"  size="4"></td>
                                                                <td><input type="text" value="0"  size="4"></td>
                                                                <td><input type="text" value="0"  size  ="4"></td>
                                                                <td><input type="text" value="0"  size="4"></td>
                                                                <td><input type="text" value="0"  size="4"></td>
                                                            </tr>   
                                                        </table>
                                                    </td> 
                                                </tr>
                                            </table>
                                            <table class="table">
                                                <tr>
                                                    <th>  
                                                        <div class="border-checkbox-section ml-3">
                                                            <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                                <input class="border-checkbox" type="checkbox" id="checkbox1" value="1">
                                                                <label class="border-checkbox-label" for="checkbox1"></label>
                                                            </div>   
                                                        </div>
                                                    </th>
                                                    <th>Women Sizes</th>
                                                    <th>Short</th>  
                                                    <th>Min in UK</th>
                                                    <th>Min in AU</th>
                                                    <th>Min in EU</th>
                                                    <th>Min in US</th>
                                                </tr> 
                                                <tr>
                                                    <td>Shoes 36</td>
                                                    <td>S 36</td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                </tr>
                                                <tr>
                                                    <td>Shoes 38</td>
                                                    <td>S 38</td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size  ="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                </tr>   
                                            </table>    
                                            
                                        </div>


                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <table class="table">
                                                <tr>
                                                    <th>  
                                                        <div class="border-checkbox-section ml-3">
                                                            <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                                <input class="border-checkbox" type="checkbox" id="checkbox1" value="1">
                                                                <label class="border-checkbox-label" for="checkbox1"></label>
                                                            </div>   
                                                        </div>
                                                    </th>
                                                    <th>Kid Sizes</th>
                                                    <th>Short</th>  
                                                    <th>Min in UK</th>
                                                    <th>Min in AU</th>
                                                    <th>Min in EU</th>
                                                    <th>Min in US</th>
                                                </tr> 
                                                <tr>
                                                    <td>Shoes 36</td>
                                                    <td>S 36</td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                </tr>
                                                <tr>
                                                    <td>Shoes 38</td>
                                                    <td>S 38</td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size  ="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                </tr>   
                                            </table>    
                                            <table class="table">
                                                <tr>
                                                    <th>  
                                                        <div class="border-checkbox-section ml-3">
                                                            <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                                <input class="border-checkbox" type="checkbox" id="checkbox1" value="1">
                                                                <label class="border-checkbox-label" for="checkbox1"></label>
                                                            </div>   
                                                        </div>
                                                    </th>
                                                    <th>Unisex Sizes</th>
                                                    <th>Short</th>  
                                                    <th>Min in UK</th>
                                                    <th>Min in AU</th>
                                                    <th>Min in EU</th>
                                                    <th>Min in US</th>
                                                </tr> 
                                                <tr>
                                                    <td>Shoes 36</td>
                                                    <td>S 36</td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                </tr>
                                                <tr>
                                                    <td>Shoes 38</td>
                                                    <td>S 38</td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size  ="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                    <td><input type="text" value="0"  size="4"></td>
                                                </tr>   
                                            </table>  
                                    </div>
                                    <div class="form-group">
                                        <label>Product Images</label>
                                        <div class="input-images" data-input-name="product-images" data-label="Drag & Drop product images here or click to browse"></div>
                                    </div>
                                    <div class="colorAndImages">
                                        <table class="table">
                                            <tr>
                                                <th>Colours</th>
                                                <th>Image</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                <div class="form-group"> 
                                                    <select class="form-control" name="colours[0][]" >
                                                        <option selected="selected" value="" >Select colour</option>
                                                        <option value="Navy and Sky">Navy and Sky</option>
                                                        <option value="Pink">Pink</option>
                                                        <option value="Navy">Navy</option>
                                                        <option value="Black">Black</option>
                                                        <option value="Fluro Green">Fluro Green</option>
                                                        <option value="Baby Blue">Baby Blue</option>
                                                        <option value="Summit Pink">Summit Pink</option>
                                                        <option value="Summit Grey">Summit Grey</option>
                                                        <option value="Red">Red</option>
                                                    </select>
                                                </div>  
                                                </td>
                                                <td>
                                                <div class="form-group"> 
                                                    <input type="file" name="product_color_image[0][]">
                                                </div> 
                                                </td>
                                                <td><span class="btn-primary btn addMore"><i class="ik ik-plus"></i></span> <span class="btn-primary btn deleteRow"><i class="ik ik-minus"></i></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                 
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
        $(".addMore").click(function(){ 
            var countTables =  $(".colorAndImages table").length; 
            var addFields = '<table class="table">'+ 
                                '<tr>'+
                                    '<td>'+
                                    '<div class="form-group">'+ 
                                        '<select class="form-control" name='+"colours["+countTables+"][]"+'>'+
                                            '<option selected="selected" value="" >Select colour</option>'+
                                            '<option value="Navy and Sky">Navy and Sky</option>'+
                                            '<option value="Pink">Pink</option>'+
                                            '<option value="Navy">Navy</option>'+
                                            '<option value="Black">Black</option>'+
                                            '<option value="Fluro Green">Fluro Green</option>'+
                                            '<option value="Baby Blue">Baby Blue</option>'+
                                            '<option value="Summit Pink">Summit Pink</option>'+
                                            '<option value="Summit Grey">Summit Grey</option>'+
                                            '<option value="Red">Red</option>'+
                                        '</select>'+
                                    '</div>'+  
                                    '</td>'+
                                    '<td>'+
                                    '<div class="form-group">'+ 
                                        '<input type="file" name="product_color_image['+countTables+'][]">'+
                                    '</div> '+
                                    '</td>'+ 
                                '</tr>'+
                            '</table>'; 
            $(".colorAndImages").append(addFields); 
        });

        // $(".deleteRow").click(function(){
        //     console.log("remove Row");
        //     $(this).parent().remove(); 
        // });
    </script>
@endsection
