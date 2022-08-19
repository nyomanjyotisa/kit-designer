@extends('inventory.layout')
@section('title', 'Edit Style')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Style</h5>
                            <span>Edit new style in inventory</span>
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
                                <a href="{{url('designs/show')}}/{{$designid}}">Product</a>
                            </li>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{url('designs/pattern/edit')}}/{{$patternid}}">Edit pattern</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Add / Edit Style</a>
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
                        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ route('update-patternStyle') }}">
                            @csrf                            
                            <div class="row"> 
                            <input type="hidden" value="{{$designid}}" name="designid">
                                <input type="hidden" value="{{$styleid}}" name="styleid">
                                <input type="hidden" value="{{$gender}}" name="ngender">
                                <input type="hidden" value="{{$Patternstyle->id}}" name="stylepatternid">
                                <input type="hidden" value="{{$Patternstyle->gender}}" name="gender" id="gender">
                                <div class="col-md-6">
                                    <ul class="nav justify-content-end float-left">
                                        <li class="nav-item">
                                            <a class="nav-link Getgender @if($gender==1) btn-primary active @endif" data-id="1" aria-current="page" href="{{url('designs/style/edit')}}/{{$designid}}/{{$patternid}}/{{$styleid}}/1">Mens</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link Getgender @if($gender==2) btn-primary active @endif" data-id="2" href="{{url('designs/style/edit')}}/{{$designid}}/{{$patternid}}/{{$styleid}}/2">Womens</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link Getgender @if($gender==3) btn-primary active @endif" data-id="3" href="{{url('designs/style/edit')}}/{{$designid}}/{{$patternid}}/{{$styleid}}/3">Kids</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link Getgender @if($gender==4) btn-primary active @endif" data-id="4"  href="{{url('designs/style/edit')}}/{{$designid}}/{{$patternid}}/{{$styleid}}/4">Unisex</a>
                                        </li> 
                                    </ul>
                                </div>
                                <div class="col-sm-12"> 
                                    <div class="form-group">
                                        <label for="title">Name<span class="text-red">*</span></label>
                                        <input type="text" name="styleName" value="{{$Patternstyle->styleName}}" id="styleName" require="" class="form-control w-40 hm-30">
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
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">SVG</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="2"><label for="title">SVG File </label> 
                                                        @if($Patternstyle->st_Image)
                                                        (<a href="{{url('/img/designs')}}/{{$designid}}/patterns/{{$patternid}}/style/{{$Patternstyle->st_Image}}" target="_blank">Download</a>)
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">
                                                    @if($Patternstyle->st_Image && $Patternstyle->gender==$gender)
                                                        <input type="submit" name="changeSvg" id="changeSvg" value="Change SVG" class="btn-primary btn">
                                                        @else
                                                        @if (\Session::has('filename')) 
                                                        <br><a class="" type="image/svg+xml; length=142295" target="_blank" href="{{url('img/temporary')}}/{!! \Session::get('filename') !!}"><i class="ik ik-file"></i> {!! \Session::get('filename') !!}</a> 
                                                        <input type="hidden" name="svgfile" value="{!! \Session::get('filename') !!}">
                                                        @else
                                                        <div class="form-group"> 
                                                            <input type="file" required name="svgfile" id="svgfile" class="form-control w-80 hm-30 svgfile" >
</div>
                                                        @endif 


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
                                                    @endif
                                                @if($Patternstyle->gender==$gender)
                                                    <div>
                                                        @if($Patternstyle->st_Image) 
                                                            <object type="image/svg+xml" id="svgFileObject" data="{{url('/img/designs')}}/{{$designid}}/patterns/{{$patternid}}/style/{{$Patternstyle->st_Image}}"></object> 
                                                            @endif  
                                                    </div> 
                                                    @endif
                                                    </td>
                                                    <td style="vertical-align:baseline;">
                                                    @if($Patternstyle->st_Image) 
                                                    <div style="float:left;margin-left:10px;">Thumbnail<div style="margin-top:2px;border:solid 1px #999;"><img src="{{url('/img/designs')}}/{{$designid}}/patterns/{{$patternid}}/style/{{$Patternstyle->st_Image}}" width="100px" height="100px"></div></div>
                                                    @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        <br>
                                       
                                    </div>
                                </div>  
                                @if(!empty($colorSelection) && $Patternstyle->gender==$gender)
                                 <div class="col-sm-12">
                                     <table class="table">
                                        <thead>
                                            <tr>
                                                <td colspan="4">Colour Sections</td>
                                            </tr> 
                                        </thead> 
                                        <tbody>
                                        <tr>
                                            <td>Id</td>
                                            <td>Name</td>
                                            <td>Fabric</td>
                                            <td>Sublimated</td>
                                        </tr>
                                        @foreach($colorSelection as $color_selection)      
                                            <tr>
                                                <th>{{$color_selection->svg_g_id}}</th>
                                                <th> <input type="text" name="svgstyle[{{$color_selection->svg_g_id}}][svg_g_id][{{$color_selection->id}}]" id="" class="form-control w-40" value="{{$color_selection->svg_name}}"></th>
                                                <th>
                                                    <select required name="svgstyle[{{$color_selection->svg_g_id}}][fabric][{{$color_selection->id}}]" id="fabric[{{$color_selection->id}}]" class="form-control">
                                                        <option value=""></option>
                                                        @if($fabric)
                                                            @foreach($fabric as $fbric)
                                                                <option @if($fbric->id==$color_selection->svgfabric) selected='selected' @endif value="{{$fbric->id}}">{{$fbric->fabric}}</option>
                                                            @endforeach
                                                        @endif
                                                        <option value=""></option>
                                                    </select>
                                                </th>
                                                <th>
                                                   <input type="checkbox"  @if($color_selection->svgsublimated==1) checked='checked' @endif  name="svgstyle[{{$color_selection->svg_g_id}}][svgsublimated][{{$color_selection->id}}]">
                                                   
                                               </th>
                                            </tr>
                                        @endforeach
                                        </tbody> 
                                     </table>
                                 </div>
                                @endif
                                <div class="col-sm-6"> 
                                    <div class="form-group text-left">
                                        <button type="submit" name="saveClose" value="saveClose" class="btn btn-primary">Save & Close</button>
                                        <button type="submit" class="btn btn-primary saveContinue">Save & Continue</button>
                                       
                                        <a href="{{url('designs/show')}}/{{$designid}}" class="btn btn-primary">Cancel</a>
                                    </div>
                                   
                                </div>
                                <div class="col-sm-6">
                                <div class="form-group text-right ">
                                       <button type="submit" name = "deletestyle" value="deletestyle" class="btn btn-danger deletestyle">Delete Style</button>
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



    //    alert($("#svgFile svg g").lenq2qz3wqezerzewzerwxn,n,mhgth);
        $(".Getgender").click(function(){  
            var gender = $(this).data('id'); 
            for(var i=1 ; i<=4 ; i++){
                if(i!=gender){
                    $(".Getgender").removeClass('active btn-primary'); 
                }
            }
             $(this).addClass('active btn-primary'); 
            $("#gender").val(gender);
        });
        $(document).ready(function(){ 
            $(".saveContinue").click(function(){
                $("#styleName").attr("required",true)
            });
            $(".deletestyle").click(function(){
                $("#styleName").attr("required",false)
                $("#svgfile").attr("required",false)
            });
        });
 
    </script>
@endsection
 
