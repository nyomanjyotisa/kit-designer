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
                        <h5>Product Set</h5>
                        <span>View, delete and update product sets</span>
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
                            <a href="#">Product sets</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row"> 
	@inject('ProductSetList','App\Http\Controllers\Productset_controller')
        <div class="container">
            <div class="col-md-12">
                <div class="panel panel-default"> 
                    <div class="panel-body">
                        
                    </div>

                </div>

            </div>
        </div> 
        <!-- list layout 1 start -->
        <div class="col-md-12">
            <div class="card">
           
                <div class="card-body">
             
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th width="25%"></th>
                            <th width="25%">Products Set</th> 
                            <th>Action</th> 
                        </tr>
                    </thead> 
                    <tbody>   
                        @if(!empty($data)) 
                            <tr data-toggle="collapse" id="p_default" data-target="#set_default" data-id="default" class="accordion-toggle p_default">
                                <td>
                                    <button class="btn btn-default btn-xs toggle_icon"><span class="ik ik-plus"></span> </button> {{$data->product_set}}
                                </td>
                                <td></td>
                                <td><a href="{{url('products/productset/create')}}/{{$data->id}}" class="btn btn-outline-primary btn-semi-rounded ">Add</a> &nbsp; <a href="{{url('products/set/edit')}}/{{$data->id}}" class="btn btn-outline-primary btn-semi-rounded">Edit</a> </td> 
                            </tr>  
                            {{$ProductSetList->getParentChild_list()}}  
                            @endif
                    </tbody>
                </table>
                  
                </div>
            </div>
        </div>
        <!-- list layout 1 end -->
        <div class="col-md-12">
            <hr>
        </div>
        <!-- list layout 2 -->

        <!-- list layout 2 end -->
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
var controller_url = "{{route('product_set')}}";

$(document).ready(function() {
    var ProductSetTable = $("#ProductSetTable").DataTable({
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        "columns": [{
                "data": "checkbox"
            },
            {
                "data": "name"
            },
            {
                "data": "description"
            },
            {
                "data": "action"
            },

        ],
        columnDefs: [{
                width: '20%',
                targets: [0],
                searchable: true,
                sortable: true
            },
            {
                width: '20%',
                targets: [1],
                searchable: true,
                sortable: true
            },
            {
                targets: [2],
                searchable: true,
                sortable: true
            },
            {
                targets: [3],
                searchable: true,
                sortable: true
            }

        ],
        order: [1, 'asc'],
        bFilter: true,
        bLengthChange: true,
        pagingType: "simple",
        "paging": true,
        "searching": true,
        "language": {
            "info": " _START_ - _END_ of _TOTAL_ ",
            "sLengthMenu": "<span class='custom-select-title'>Rows per page:</span> <span class='t'> _MENU_ </span>",
            "sSearch": "",
            "sSearchPlaceholder": "Search",
            "paginate": {
                "sNext": " Next",
                "sPrevious": " Previous"
            },
        },
        "processing": true,
        "serverSide": true,
        ajax: {
            "url": controller_url + "/loadDatatable",
            "type": "GET",
            "async": false,
            "data": function(d) {

            },
            "statusCode": {
                401: function(data) {
                    window.location.href = '{{route("product_set")}}';
                },
            }

        },
        dom: "<'pmd-card-title'<'data-table-responsive pull-right' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'pmd-card-footer' <'pmd-datatable-pagination' l i p>>", 

    });
});

$(".show_data").click(function(){    
     if($(".p_"+$(this).data("id")).hasClass('show')){
         $(".p_"+$(this).data("id")).addClass('hidden');
         $(".p_"+$(this).data("id")).removeClass('show');
     }else{ 
         $(".p_"+$(this).data("id")).removeClass('hidden').addClass("show");  
     } 
});

$("#p_default").click(function(){
      if($(".default_s").hasClass("hidden")){
        $(".default_s").removeClass("hidden");
      }else{
        $(".default_s").addClass("hidden")
      }
});
</script>
@endpush
@endsection

