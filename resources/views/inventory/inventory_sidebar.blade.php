<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('dashboard')}}">
            <div class="logo-img">
               <img height="30" src="{{ asset('img/Pontoon_logo_Grey.svg')}}"  width="171px" class="header-brand-img" title="RADMIN"> 
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp
    
    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ ($segment2 == 'inventory') ? 'active' : '' }}">
                    <a href="{{url('/inventory')}}"><i class="ik ik-bar-chart-2"></i><span>{{ __('Dashboard')}}</span></a>
                </div> 
                <div class="nav-item {{ ($segment1 == 'pos') ? 'active' : '' }}">
                    <a href="{{url('pos')}}"><i class="ik ik-printer"></i><span>{{ __('POS')}}</span> <span class=" badge badge-success badge-right">{{ __('New')}}</span></a>
                </div>  
                <div class="nav-item {{ ($segment1 == 'orders') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-shopping-cart"></i><span>{{ __('Production')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{url('orders/')}}" class="menu-item {{ (($segment1 == 'orders') || ($segment1 == 'orders' && $segment2 == 'create')) ? 'active' : '' }}">{{ __('Orders')}}</a>
                        <a href="{{url('sales')}}" class="menu-item {{ ($segment1 == 'sales' && $segment2 == '') ? 'active' : '' }}">{{ __('Manufacturing')}}</a>
                    </div>
                </div>
                <div class="nav-item {{ ($segment1 == 'saved-products' || $segment1 == 'quote-requests' || $segment1 == 'saved-designs') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-server"></i><span>{{ __('Saved Products')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{url('quote-requests/')}}" class="menu-item {{ ($segment1 == 'quote-requests') ? 'active' : '' }}">{{ __('Quote Requests')}}</a>
                        <a href="{{url('saved-designs/')}}" class="menu-item {{ ($segment1 == 'saved-designs') ? 'active' : '' }}">{{ __('Saved Designs')}}</a>
                    </div>
                </div>
                <div class="nav-item {{ ($segment1 == 'designs' || ($segment1 == 'designs' && $segment2 == 'create') || ($segment1 == 'fabrics') || ($segment1 == 'products' && $segment2 == 'set') || ($segment1 == 'sizes') || ($segment1 == 'tags')) ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-headphones"></i><span>{{ __('Designs')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{url('designs')}}" class="menu-item {{ ($segment1 == 'designs' || ($segment1 == 'designs' && $segment2 == 'create')) ? 'active' : '' }}">{{ __('Products')}}</a> 
                        <a href="{{url('products/set')}}" class="menu-item {{ ($segment1 == 'products' && $segment2 == 'set') ? 'active' : '' }}">{{ __('Product Set')}}</a>
                        <a href="{{url('fabrics')}}" class="menu-item {{ ($segment1 == 'fabrics') ? 'active' : '' }}">{{ __('Fabric')}}</a> 
                        
                        <a href="{{url('sizes')}}" class="menu-item {{ ($segment1 == 'sizes') ? 'active' : '' }}">{{ __('Sizes')}}</a> 
                        <a href="{{url('tags')}}" class="menu-item {{ ($segment1 == 'tags') ? 'active' : '' }}">{{ __('Tags')}}</a> 

                    </div>
                </div>    
                <!-- for future purpose start-->
                <!-- <div class="nav-item {{ ($segment1 == 'sales') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-shopping-cart"></i><span>{{ __('Sales')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{url('sales/create')}}" class="menu-item {{ ($segment1 == 'sales' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add Sale')}}</a>
                        <a href="{{url('sales')}}" class="menu-item {{ ($segment1 == 'sales' && $segment2 == '') ? 'active' : '' }}">{{ __('List Sales')}}</a>
                    </div>
                </div>
                <div class="nav-item {{ ($segment1 == 'purchases') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-truck"></i><span>{{ __('Purchases')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{url('purchases/create')}}" class="menu-item {{ ($segment1 == 'purchases' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add Purchase')}}</a>
                        <a href="{{url('purchases')}}" class="menu-item {{ ($segment1 == 'purchases' && $segment2 == '') ? 'active' : '' }}">{{ __('List Purchases')}}</a>
                    </div>
                </div>
                <div class="nav-item {{ ($segment1 == 'suppliers' || $segment1 == 'customers') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-users"></i><span>{{ __('People')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{url('suppliers')}}" class="menu-item {{ ($segment1 == 'suppliers') ? 'active' : '' }}">{{ __('Suppliers')}}</a>
                        <a href="{{url('customers')}}" class="menu-item {{ ($segment1 == 'customers') ? 'active' : '' }}">{{ __('Customers')}}</a>
                    </div>
                </div> -->
                <!-- for future purpose end-->


                <!-- end inventory pages -->

                
        </div>
    </div>
</div>