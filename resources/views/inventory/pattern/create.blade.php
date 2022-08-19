@extends('inventory.layout')
@section('title', 'Add Pattern')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Pattern</h5>
                            <span>Add new pattern in inventory</span>
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
                            <a href="#">Designs</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Product</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Add Pattern</a>
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
                        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ route('store-pattern') }}">
                            @csrf                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" name="product_design_id" id="product_design_id" value="{{$product_design_id}}"> 
                                    @inject('dropdown','App\Http\Controllers\Productset_controller')
                                    <div class="form-group">
                                        <label for="title">Parent Product set</label>
                                        <select class="form-control w-40 hm-30" name="parent_product_set" id="parent_product_set"  required="">
                                            <option value="default">Default</option>
                                            {{$dropdown->getParentChild()}}
                                        </select>  
                                        <div class="help-block with-errors"></div> 
                                    </div> 
                                    <div class="form-group">
                                        <label for="title">Name<span class="text-red">*</span></label>
                                        <input type="text" name="patternName" id="patternName" class="form-control w-40 hm-30">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">URL</label>
                                        <input type="text" name="patternURL" id="patternURL" class="form-control w-40 hm-30">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Weight</label>
                                        <select name="patternweight" id="patternweight" class="form-control w-40 hm-30">
                                            @for($i=0;$i<=50;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                            @endfor 
                                        </select>
                                        <!-- <input type="text" name="patternweight" id="patternweight" class="form-control w-40 hm-30"> -->
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
@endsection
 