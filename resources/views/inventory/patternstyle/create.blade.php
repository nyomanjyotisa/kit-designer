@extends('inventory.layout')
@section('title', 'Add Style')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Style</h5>
                            <span>Add new style in inventory</span>
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
                                <a href="{{url('designs/show')}}/{{$designid}}">Product</a>
                            </li>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{url('designs/pattern/edit')}}/{{$patternid}}">Edit pattern</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Add/Edit Style</a>
                            </li>
                            @if(!empty($gender))
                            <li class="breadcrumb-item">
                                <a href="#">
                                @switch($gender)
                                    @case(1)
                                       Mens
                                        @break 
                                    @case(2)
                                       Womens
                                        @break

                                        @case(3)
                                       Kids
                                        @break

                                        @case(4)
                                       Unisex
                                        @break

                                    @default
                                     
                                @endswitch
                                </a>
                            </li>
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body"> 
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>{!! \Session::get('success') !!}</li>
                                </ul>
                            </div>
                        @endif 

                        @if (\Session::has('failed'))
                            <div class="alert alert-danger">
                                <ul>
                                    <li>{!! \Session::get('failed') !!}</li>
                                </ul>
                            </div>
                        @endif 
                        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ route('store-patternStyle') }}">
                            @csrf                            
                            <div class="row"> 
                                <input type="hidden" value="{{$patternid}}" name="patternid">
                                <input type="hidden" value="{{$designid}}" name="designid">
                                <input type="hidden" value="@if($gender=='') 1 @endif {{$gender}}" name="gender" id="gender">
                                <div class="col-md-6">
                                    <ul class="nav justify-content-end float-left">
                                        <li class="nav-item">
                                            <a class="nav-link @if($gender==1 or $gender=='')  btn-primary active @endif" data-id="1" aria-current="page" href="{{url('designs')}}/{{$designid}}/{{$patternid}}/add/1">Mens</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link @if($gender==2)  btn-primary active @endif" data-id="2" href="{{url('designs')}}/{{$designid}}/{{$patternid}}/add/2">Womens</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link @if($gender==3)  btn-primary active @endif" data-id="3" href="{{url('designs')}}/{{$designid}}/{{$patternid}}/add/3">Kids</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link @if($gender==4)  btn-primary active @endif" data-id="4"  href="{{url('designs')}}/{{$designid}}/{{$patternid}}/add/4">Unisex</a>
                                        </li> 
                                    </ul>
                                </div>
                                @php $stylename =  ""; @endphp
                                @if (\Session::has('stylename'))
                                        @php $stylename =  Session::get('stylename'); @endphp
                                 @endif
                                <div class="col-sm-12"> 
                                    <div class="form-group">
                                        <label for="title">Name<span class="text-red">*</span></label>
                                        <input type="text" name="styleName" id="styleName" value="{{$stylename}}" class="form-control w-40 hm-30">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Pattern</label>
                                        <select name="patternid" id="patternid" class="form-control w-40 hm-30">
                                                <option value="">Select Pattern</option>
                                                @if($patterns)
                                                    @foreach($patterns as $patern)
                                                        <option @if($patternid==$patern->id) selected="selected" @endif value="{{$patern->id}}">{{$patern->patternName}}</option>
                                                    @endforeach
                                                @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">SVG File<span class="text-red">*</span></label> 
                                        @if (\Session::has('filename')) 
                                            <br><a class="" type="image/svg+xml; length=142295" target="_blank" href="{{url('img/temporary')}}/{!! \Session::get('filename') !!}"><i class="ik ik-file"></i> {!! \Session::get('filename') !!}</a> 
                                            <input type="hidden" name="svgfile" id="svgfile" value="{!! \Session::get('filename') !!}">
                                        @else
                                            <input type="file" required name="svgfile" id="svgfile" class="form-control w-40 hm-30">
                                        @endif    
                                    </div>
                                    @if (\Session::has('filename')) 
                                        <div class="form-group">
                                            <input type="hidden" name="removefile" value="{!! \Session::get('filename') !!}">
                                            <input type="submit" name="remove" value="Remove" class="btn btn-primary">
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <input type="submit" name="upload" value="Upload" class="btn btn-primary">
                                        </div>
                                    @endif 
                                    
                                </div> 
                                <div class="col-sm-12"> 
                                    <div class="form-group text-left w-40 hm-30">
                                        <button type="submit" class="btn btn-primary saveContinue" name="savecontinue" value="savecontinue">Save & Continue</button>
                                        <a href="{{url('designs/show')}}/{{$designid}}" class="btn btn-primary">Cancel</a>
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
        $(document).ready(function(){ 
            $(".saveContinue").click(function(){ 
                $("#styleName").attr("required",true) 
            });
        });
    </script>
@endsection
 