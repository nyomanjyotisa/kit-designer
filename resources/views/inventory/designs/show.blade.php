@extends('inventory.layout')
@section('title', 'View product')
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-headphones bg-blue"></i>
                    <div class="d-inline">
                        <h5>Product</h5>
                        <span>View product design inventory</span>
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
                            <a href="{{url('designs')}}">Designs</a>
                        </li>
                        <li class="breadcrumb-item">
                        <a href="{{url('designs/show')}}/{{$design->id}}">Product</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-md-12"><hr></div>
		    <!-- list layout 2 --> 
		    <!-- <div class="col-md-12"> 
                <div class="mb-2 clearfix"> 
                    <div class="collapse d-md-block display-options" id="displayOptions"> 
                        </div>
                        <div class="float-md-right"> 
                            <a href="{{url('/designs/pattern/create')}}/{{$design->id}}" class="btn btn-outline-primary btn-rounded-20">
                            	Add Pattern
                            </a>
                        </div>
                    </div>
                </div>
                <div class="separator mb-20"></div> 
            </div>  -->
        <div class="col-md-12">
            <div class="card ">
            <div class="card-header row"> 
                    <div class="col col-sm-12">
                    <ul class="nav justify-content-end float-left">
                        <li class="nav-item">
                            <a href="{{url('designs/show')}}/{{$design->id}}" class="nav-link btn-primary active " aria-current="page">View</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('designs/edit')}}/{{$design->id}}" class="nav-link" aria-current="page">Edit</a>
                        </li>
                    </ul>
                        <div class="text-right"> 
                            <!-- <a href="http://127.0.0.1:8000/fabrics/create"
                                class="btn btn-outline-primary btn-semi-rounded">Add Category</a> -->
                                <a href="{{url('/designs/pattern/create')}}/{{$design->id}}" class="btn btn-outline-primary btn-rounded-20">
                            	Add Pattern
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            @if($design->design_thumbnail!='')
                            <img src="{{url('img/designs')}}/{{$design->id}}/{{$design->design_thumbnail}}"
                                                alt="" class="" width="100%">
                            @else
                            <img src="{{url('img/designs')}}//default.png"  alt="" class=" " width="100%">

                            @endif
                        </div>
                        <div class="col-md-10">
                            <table>
                                <tbody>
                                    <tr> 
                                        <td>
                                            <strong>{{$design->design_pro_name}}</strong>
                                            <br>Groups: @php echo ($tag)?implode(',',$tag):"" @endphp
                                            <!-- <br>Sports:@php echo ($sports)?implode(',',$sports):"" @endphp  -->
                                            <br>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>  
                    <div class="row">
                        <div class="col-md-12"></div>
                    </div> 
                </div>
            </div>
        </div>

        @if($patterns)
        @foreach($patterns as $pattern)
        <!-- Product pattern list start -->
        <div class="col-md-12"> <h4>{{$pattern->patternName}}  <span><a href="{{url('designs')}}/{{$design->id}}/{{$pattern->id}}/add" class="btn btn-outline-primary btn-rounded-20 float-right">Add style</a>&nbsp;
        <a href="{{url('designs/pattern/edit')}}/{{$pattern->id}}" class="btn btn-outline-primary btn-rounded-20 float-right">Edit</a></span></h4><hr>
            <div class="card "> 
                <div class="card-body">
                    <div class="row"> 
                        @if($styles)
                            @foreach($styles as $style)
                                @if($pattern->id == $style->pattern_id)
                                    <div class="col-md-2 text-center">
                                        <a href="{{url('designs/style/edit/')}}/{{$design->id}}/{{$pattern->id}}/{{$style->id}}">
                                            <img src="{{url('img/designs')}}/{{$design->id}}/patterns/{{$pattern->id}}/style/{{$style->styleImage}}" alt="" class="list-thumbnail responsive border-0"> <div class="text-center" style="padding:1px;">{{$style->styleName}}</div><div class="separator mb-20"></div> 
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        @endif 
                    </div>  
                    <div class="row">
                        <div class="col-md-12"></div>
                    </div> 
                </div>
            </div>
        </div>
        @endforeach
        @endif
        <!-- Product pattern list end -->  
</div> 
@endsection