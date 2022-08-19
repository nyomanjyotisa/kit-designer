@extends('inventory.layout') 
@section('title', 'Products')
@section('content')

	<div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-green"></i>
                        <div class="d-inline">
                            <h5>Designs</h5>
                            <span>View, delete and update products</span>
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
                                <a href="#">Designs</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row"> 
		    <div class="col-md-12"><hr></div>



		    <!-- list layout 2 --> 
		    <div class="col-md-12">
                <div class="mb-2 clearfix"> 
                    <div class="collapse d-md-block display-options" id="displayOptions"> 
                        </div>
                        <div class="float-md-right"> 
                            <a href="{{route('create-designproduct')}}" class="btn btn-outline-primary btn-rounded-20">
                            	Add Product
                            </a>
                        </div>
                    </div>
                </div>
                <div class="separator mb-20"></div>  
                <div class="col-sm-12 bg-white">
                    <!-- Tag list start -->
                <div class="col-md-12 text-right">  <div class="separator mb-20"></div> Product Groups are defined by tags under the category Designgroup<hr></div>
			        <div class="customer-area"> 
                    @if(!empty($tagList))  
                        @foreach($tagList as $tags)
                        <div class="row pos-products layout-wrap" id="layout-wrap">

                            <div class="col-md-12">
                                <h3>{{$tags->name}}</h3>
                            </div>
                        </div>	
			        	<div class="row pos-products layout-wrap" id="layout-wrap"> 
                            
                                    
                            <!-- <h3>{{$tags->name}}</h3> -->
                            @if($DesignProducts)
                                @foreach($DesignProducts as $product)
                                    @if(in_array($tags->id,explode(',',$product->design_tags)))
                                    <!-- include product preview page -->
                            

                                    <div class="col-xl-2 col-lg-4 col-12 col-sm-6 list-item list-item-grid">
                                        <div class="card d-flex flex-row mb-3">
                                            <a class="d-flex card-img" href="#editLayoutItem" data-toggle="modal" data-target="#editLayoutItem">
                                                @if($product->design_thumbnail!='')
                                                    <img src="{{url('img/designs')}}/{{$product->id}}/{{$product->design_thumbnail}}" alt="Donec sit amet est at sem iaculis a " class="list-thumbnail responsive border-0">
                                                    @else
                                                    <img src="{{url('img/designs')}}/default.png">
                                                @endif
                                                
                                                <!-- <span class="badge badge-pill badge-primary position-absolute badge-top-left">New</span>
                                                <span class="badge badge-pill badge-secondary position-absolute badge-top-left-2">Trending</span> -->
                                            </a>
                                            <div class="d-flex flex-grow-1 min-width-zero card-content">
                                                <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                                    <a class="list-item-heading mb-1 truncate w-40 w-xs-100" href="#editLayoutItem" data-toggle="modal" data-target="#editLayoutItem" style="text-align: center; padding-bottom: 20px;">
                                                    {{$product->design_pro_name}}
                                                    </a>
                                                    <!-- <p class="mb-1 text-muted text-small category w-15 w-xs-100">Art')}}</p> -->
                                                    <!-- <p class="mb-1 text-muted text-small date w-15 w-xs-100">02.04.2018</p> -->
                                                  
                                                </div>
                                                <div class="list-actions">
                                                    <a href="{{url('designs/show')}}/{{$product->id}}"><i class="ik ik-eye"></i></a>
                                                    <a href="{{url('designs/edit')}}/{{$product->id}}"><i class="ik ik-edit-2"></i></a>
                                                    <a href="{{url('designs/delete')}}/{{$product->id}}" class="list-delete"><i class="ik ik-trash-2"></i></a>
                                                </div>
                                                <div class="custom-control custom-checkbox pl-1 align-self-center">
                                                    <label class="custom-control custom-checkbox mb-0">
                                                        <input type="checkbox" class="custom-control-input">
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            @endif
			        	</div>
			        	<hr>
                        @endforeach 
                        @endif    
			        </div>
	    		</div>
                              
<!-- Tags list end -->


            </div>
            <!-- list layout 2 end -->
		</div>
	</div>
	<div class="modal fade edit-layout-modal pr-0" id="productView" tabindex="-1" role="dialog" aria-labelledby="productViewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productViewLabel">Iphone 6</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <img src="../img/products/ipone-6.jpg" class="img-fluid" alt="">
                        <div class="other-images">
                            <div class="row">
                                <div class="col-sm-4">
                                    <img src="../img/widget/p2.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="col-sm-4">
                                    <img src="../img/widget/p2.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="col-sm-4">
                                    <img src="../img/widget/p2.jpg" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <p>
                            </p><div class="badge badge-pill badge-dark">Electronics</div>
                            <div class="badge badge-pill badge-dark">Accesories &amp; Gadgets</div>
                        <p></p>
                        <h3 class="text-danger">
                            $ 1234
                            <del class="text-muted f-16">$ 1250</del>
                        </h3>
                        <p class="text-green">Purchase Price: $ 1000</p>
                        <p>Apple iPhone 6 smartphone. Announced Sep 2014. Features 4.7″ display, Apple A8 chipset, 8 MP primary camera, 1.2 MP front camera, 1810 mAh</p>
                        <p>In Stock: 100</p>
                        <p>Spplier: PZ Tech</p>
                    </div>
                </div>
                <h5><strong>Sales</strong></h5>
                <div id="line_chart" class="chart-shadow"></div>
                        
            </div>
        </div>
    </div>

	@push('script')                
        <script src="{{ asset('plugins/amcharts/amcharts.js') }}"></script>
        <script src="{{ asset('plugins/amcharts/gauge.js') }}"></script>
        <script src="{{ asset('plugins/amcharts/serial.js') }}"></script>
        <script src="{{ asset('plugins/amcharts/themes/light.js') }}"></script>
        <script src="{{ asset('plugins/amcharts/animate.min.js') }}"></script>
        <script src="{{ asset('plugins/amcharts/pie.js') }}"></script>
        <script src="{{ asset('plugins/ammap3/ammap/ammap.js') }}"></script>
        <script src="{{ asset('plugins/ammap3/ammap/maps/js/usaLow.js') }}"></script>
        <script src="{{ asset('js/product.js') }}"></script>
    @endpush
@endsection