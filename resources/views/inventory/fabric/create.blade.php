@extends('inventory.layout')
@section('title', 'Add Fabric')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Fabric</h5>
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
                                <a href="#">Add Fabric</a>
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
                        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ route('store-fabric') }}">
                            @csrf                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="title">Fabric Name<span class="text-red">*</span></label>
                                        <input id="fabric" type="text" class="form-control w-40 hm-30" name="fabric" value="" placeholder="Enter Fabric" required="">
                                        <div class="help-block with-errors"></div> 
                                    </div>   
                                    <div class="form-group w-40 hm-30">
                                        <label for="title">Colour<span class="text-red">*</span></label>
                                         <table class="table colourTable">
                                            <thead>
                                                <tr>
                                                    <td>Colour Name</td>
                                                    <td>PMS</td>
                                                    <td>Colour code</td>
                                                    <td>Sample</td>
                                                    <td>Delete</td>
                                                </tr> 
                                            </thead>
                                            <tbody> 
                                                <tr>
                                                    <td><input type="text" class="form-control" required="" id="colourName" name="colourName"> </td>
                                                    <td><input type="text" class="form-control" required="" id="pms" name="pms"></td>
                                                    <td><input type="text" class="form-control" required="" id="hex" name="hex"></td>
                                                    <td colspan="2"><input type="button" value="Add Colour" class="btn btn-primary saveColour"></td>
                                                </tr> 
                                            </tbody>
                                         </table>
                                         <div class="colorcode"><strong>Color Code :</strong> <input type="color" class=" changecolor"></div>
                                        <div class="help-block with-errors"></div> 
                                    </div>  
                                </div>
                                <div class="col-sm-12"> 
                                    <div class="form-group text-right w-40 hm-30">
                                        <button type="button" class="btn btn-primary deletecolor">Delete</button>
                                        <button type="submit" class="btn btn-primary savefabric">Save</button>
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
        $(".changecolor").change(function(){
            // $("#hexcode").text($(this).val());
            $("#hex").val($(this).val());
        });
        $(".savefabric").click(function(){
            $("#colourName").attr("required",false);
            $("#pms").attr("required",false);
            $("#hex").attr("required",false);
        });
        $(".saveColour").click(function(){ 
            $("#hex").text("");
            var colourName = $("#colourName").val();
            var pms = $("#pms").val();
            var hex = $("#hex").val(); 
            // $("#colourName").val("");
            // $("#pms").val("");
            // $("#hex").val("");   
            var checkLength = $(".colourTable tbody tr").length;  
            if(colourName && pms && hex){
                var add_fields = '<tr id="chkbox_'+checkLength+'"><td>'+colourName+'</td><td>'+pms+'</td><td>'+hex+'<input type="hidden" name="colour[]" value="'+colourName+'|'+pms+'|'+hex+'"></td><td style="background-color:'+hex+'"></td><td><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input checkForDelete" id="chk_'+checkLength+'" name="colourId[]"  value="'+checkLength+'"><span class="custom-control-label">&nbsp;</span></label></td></tr>';  
                $(".colourTable tbody").prepend(add_fields);
                $("#colourName").val("");
                $("#pms").val("");
                $("#hex").val("");   
            }else{
                $("#colourName").attr("value",colourName);
                $("#pms").attr("value",pms);
                $("#hex").attr("value",hex); 
                return false;
            }
        }); 
        $('.deletecolor').click(function(){ 
            $('input[name="colourId[]"]:checked').each(function() { 
                $("#chkbox_"+this.value).remove(); 
            });

 
        });  
    </script>
@endsection
 