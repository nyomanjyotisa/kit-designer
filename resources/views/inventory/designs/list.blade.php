@extends('inventory.layout') 
@section('title', 'Products')
@section('content')
<style>
    label.labelClass {
        font-size: 11px;
        text-align: center;
        width: 100%; 
        padding: 15px;
        padding: 31px;
    }
    img.designimage {
        width: 100%;
        height: 75%;
    }



.list-actions a {
    width: 30px;
    height: 30px;
    padding: 0;
    border-radius: 50%;
    text-align: center;
    line-height: 32px;
    color: #999;
    display: inline-block;
    font-size: 16px;
}
.list-actions { 
    display:none;
    opacity: 1;
    margin: 0;
    position: absolute;
    right: 56px;
    bottom: 20px;
}
.showAction{
    display:block;
}
 
 
</style>
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
            </div> 
    	</div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-block text-right"> 
                        <span>Product Groups are defined by tags under the category Designgroup</span>
                    </div>
                    <div class="card-body p-0 table-border-style">
                        
                    </div>
                </div> 
            </div>
        </div>
        <div class="row">
            <!-- Tags and products start -->
            @if(!empty($tagList)) 
           
                        @foreach($tagList as $tags) 
                       
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h3>{{$tags->name}}</h3> 
                    </div> 
                    <div class="card-body p-2 table-border-style">
                        <div class="row">
                        <!-- <div class="col-lg-3 col-md-6 mb-20"><img src="../img/big/img2.jpg" class="img-fluid rounded"></div> -->
                        @if($DesignProducts)  
                                @foreach($DesignProducts as $product)
                                @php $i = rand(0,1000); @endphp
                                    @if(in_array($tags->id,explode(',',$product->design_tags)))
                                        <div class="col-lg-2 col-md-2 mb-20 d-flex flex-row mb-3 display_action"  data-id="{{$product->id}}_{{$i}}">
                                            <a href="{{url('designs/show')}}/{{$product->id}}" class="card d-flex mb-3">
                                                @if($product->design_thumbnail!='')
                                                    <img src="{{url('img/designs')}}/{{$product->id}}/{{$product->design_thumbnail}}" alt="{{$product->design_pro_name}}" class="designimage img-fluid rounded">
                                                    @else
                                                    <img src="{{url('img/designs')}}/default.png" alt="{{$product->design_pro_name}}" class="designimage img-fluid rounded">
                                                @endif 
                                                <label for="" class="labelClass">{{$product->design_pro_name}}</label> 
                                            </a> 
                                            <div id="d_{{$product->id}}_{{$i}}" class="list-actions">
                                                <a href="{{url('designs/show')}}/{{$product->id}}"><i class="ik ik-eye"></i></a>
                                                <a href="{{url('designs/edit')}}/{{$product->id}}"><i class="ik ik-edit-2"></i></a>
                                                <a href="{{url('designs/delete')}}/{{$product->id}}" class="list-delete"><i class="ik ik-trash-2"></i></a>
                                            </div>
                                        </div> 
                                    @endif 
                                 @endforeach
                        @endif 
                        </div> 
                    </div>
                </div> 
            </div>  
            @endforeach
            @endif
            <!-- Tags and products end -->
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
        <script> 
            $(".display_action").hover(function(){ 
               $(".display_action #d_"+$(this).data("id")).addClass("showAction");
            });
            $(".display_action").mouseleave(function(){ 
                $(".display_action #d_"+$(this).data("id")).removeClass("showAction");
            });
        </script>
    @endpush
@endsection