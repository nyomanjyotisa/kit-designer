@extends('inventory.layout')
@section('title', 'Add Size')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Size</h5>
                            <span>Add new size inventory</span>
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
                                <a href="#">Add Size</a>
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
                        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ route('store-size') }}">
                            @csrf                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="title">Size<span class="text-red">*</span></label>
                                        <input id="size" type="text" class="form-control w-40 hm-30" name="size" value="" placeholder="Enter Size" required="">
                                        <div class="help-block with-errors"></div> 
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Gender<span class="text-red">*</span></label>
                                        <select name="gender" id="gender" class="form-control w-40 hm-30">
                                            <option value="1">Mens</option>
                                            <option value="2">Womens</option>
                                            <option value="3">Kids</option>
                                            <option value="4">Unisex</option>
                                        </select>
                                        <div class="help-block with-errors"></div> 
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Code<span class="text-red">*</span></label>
                                        <input id="code" type="text" class="form-control w-40 hm-30" name="code" value="" placeholder="Enter short name" required="">
                                        <div class="help-block with-errors"></div> 
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Weight<span class="text-red">*</span></label>
                                        <input id="code" type="text" class="form-control w-40 hm-30" name="weight" value="" placeholder="Enter weight" required="">
                                        <div class="help-block with-errors"></div> 
                                    </div> 
                                </div>
                                <div class="col-sm-12"> 
                                    <div class="form-group text-right w-40 hm-30">
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
 