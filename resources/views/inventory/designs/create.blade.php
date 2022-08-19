@extends('inventory.layout')
@section('title', 'Add product')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Product</h5>
                            <span>Add new product design inventory</span>
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
                        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ route('store-designproduct') }}">
                            @csrf                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="title">Name<span class="text-red">*</span></label>
                                        <input id="design_pro_name" type="text" class="form-control w-40 hm-30" name="design_pro_name" value="" placeholder="Enter product name" required="">
                                        <div class="help-block with-errors"></div> 
                                    </div>  
                                    <div class="form-group">
                                        <label for="title">URL</label>
                                        <input id="design_product_url" type="text" class="form-control w-40 hm-30" name="design_product_url" value="" placeholder="Enter URL">
                                        <div class="help-block with-errors"></div> 
                                    </div>  
                                    @inject('dropdown','App\Http\Controllers\Productset_controller')
                                    <div class="form-group">
                                        <label for="title">Product Set</label>
                                        <select name="design_product_set_id" id="design_product_set_id" class="form-control w-40">
                                            <option value="">Default</option>
                                            {{$dropdown->getParentChild()}}
                                        </select>
                                        <div class="help-block with-errors"></div> 
                                    </div>  
                                    <div class="form-group">
                                        <label for="title">Product Thumbnail</label>
                                        <input id="design_thumbnail" type="file" class="form-control w-40 hm-30" name="design_thumbnail" value="">
                                        <div class="help-block with-errors"></div> 
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Weight</label>
                                        <select name="design_weight" id="design_weight" class="form-control w-10"> 
                                            @for($i=0;$i<=50;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                            @endfor 
                                        </select> 
                                        <div class="help-block with-errors"></div> 
                                    </div>  
                                </div> 
                               @if($tags_list)
                                    @foreach($tags_list as $category_tags) 
                                        @if(empty($category_tags['tags']))
                                        @continue
                                        @endif
                                            <div class="col-sm-3">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>{{$category_tags['category_name']}}</th>
                                                        </tr> 
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($category_tags['tags']))
                                                        @foreach($category_tags['tags'] as $tag) 
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="tags[{{$category_tags['categoryid']}}][]" value="{{$tag['tagid']}}">
                                                            </td>
                                                            <td>{{$tag['tagname']}}</td>
                                                        </tr> 
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                    @endforeach
                               @endif 
                                <div class="col-sm-12"> 
                                    <div class="form-group text-right w-40 hm-30">
                                        <!-- <button type="button" class="btn btn-primary deletecolor">Delete</button> -->
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
  
@endsection
 