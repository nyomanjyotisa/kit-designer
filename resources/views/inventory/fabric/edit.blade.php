@extends('inventory.layout')
@section('title', 'Edit Fabric')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Fabric</h5>
                            <span>Edit new size inventory</span>
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
                                <a href="#">Edit Fabric</a>
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
                        <form class="forms-sample fabricForm" enctype="multipart/form-data" method="POST" >
                            @csrf                            
                            <div class="row">
                                <input type="hidden" name="id" value="{{$fabric->id}}">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="title">Fabric Name<span class="text-red">*</span></label>
                                        <input id="fabric" type="text" class="form-control w-40 hm-30" name="fabric" value="{{$fabric->fabric}}" placeholder="Enter Size" required="">
                                        <div class="help-block with-errors"></div> 
                                    </div>  
                                    <div class="form-group w-40 hm-30">
                                        <label for="title">Colour<span class="text-red">*</span></label>
                                         <table class="table">
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
                                            @if(!empty($fabric_colour))
                                                    @foreach($fabric_colour as $colours)
                                                    <tr>
                                                        <td>{{$colours->name}}</td>
                                                        <td>{{$colours->pms}}</td>
                                                        <td>#{{$colours->hex}}</td>
                                                        <td style="background-color:#{{$colours->hex}}"> </td>
                                                        <td>
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input select_all_child" id="" name="colours[]" value="{{$colours->id}}">
                                                                <span class="custom-control-label">&nbsp;</span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endif 
                                                <tr>
                                                    <td><input type="text" class="form-control" name="colourName"> </td>
                                                    <td><input type="text" class="form-control" name="pms"></td>
                                                    <td><input type="text" class="form-control" id="hex" name="hex"></td>
                                                    <td colspan="2"><input type="submit" value="Add Colour" class="btn btn-primary saveColour"></td>
                                                </tr> 
                                            </tbody>
                                         </table>
                                         <div class="colorcode"><strong>Color Code :</strong> <input type="color" class="changecolor"></div>
                                        <div class="help-block with-errors"></div> 
                                    </div>  
                                </div>
                                <div class="col-sm-12"> 
                                    <div class="form-group text-right w-40 hm-30">
                                        <button type="submit" class="btn btn-primary deleteFabric">Delete</button>
                                        <button type="submit" class="btn btn-primary saveFabric">Save</button>
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
            $("#hex").val($(this).val());
        });
        $(".saveFabric").click(function(){
           $(".fabricForm").attr("action","{{ route('update-fabric') }}");
        });
        $(".saveColour").click(function(){
           $(".fabricForm").attr("action","{{ route('save-fabric-colour') }}");
        });
        $(".deleteFabric").click(function(){
           $(".fabricForm").attr("action","{{ route('delete-fabric-colour') }}");
        });
    </script>
@endsection
 