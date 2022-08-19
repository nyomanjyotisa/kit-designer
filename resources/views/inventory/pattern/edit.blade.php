@extends('inventory.layout')
@section('title', 'Edit Pattern')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Pattern</h5>
                            <span>Edit new pattern in inventory</span>
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
                                <a href="{{url('designs')}}">Designs</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{url('designs/show')}}/{{$pattern->product_design_id}}">Product</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Edit Pattern</a>
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
                        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ route('update-pattern') }}">
                            @csrf                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" name="id" id="id" value="{{$pattern->id}}"> 
                                    @inject('dropdown','App\Http\Controllers\Productset_controller')
                                    <div class="form-group">
                                        <label for="title">Parent Product set</label>
                                        <select class="form-control w-40 hm-30" name="parent_product_set" id="parent_product_set"  required="">
                                            <option value="default">Default</option>
                                            {{$dropdown->getParentChild_edit($pattern->parent_product_set)}}
                                        </select>  
                                        <div class="help-block with-errors"></div> 
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Name<span class="text-red">*</span></label>
                                        <input type="text" name="patternName" id="patternName" value="{{$pattern->patternName}}" class="form-control w-40 hm-30">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">URL</label>
                                        <input type="text" name="patternURL" id="patternURL" value="{{$pattern->patternURL}}"  class="form-control w-40 hm-30">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Weight</label>
                                        <select name="patternweight" id="patternweight"  class="form-control w-40 hm-30">
                                            @for($i=0;$i<=50;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                            @endfor 
                                        </select>
                                        <!-- <input type="text" name="patternweight" id="patternweight" class="form-control w-40 hm-30"> -->
                                    </div>
                                </div> 
                                <div class="col-sm-12"> 
                                    <div class="form-group text-right w-40 hm-30">
                                        <button type="submit" name="savebtn" value="save" class="btn btn-primary">Save</button>
                                        <button type="submit" name="deletebtn" value="delete" class="btn btn-danger">Delete</button> 
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
 