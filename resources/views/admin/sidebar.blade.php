<!-- Left Sidebar Menu -->
@php
    $title = app()->view->getSections()['title'];

    $locationactive = ($title == 'Manage Country') ? 'active' : (($title == 'Manage City') ? 'active' : ($title == 'Manage State' ? 'active' : ''));
    $locationCollapce = ($title == 'Manage Country') ? 'in' : (($title == 'Manage City') ? 'in' : ($title == 'Manage State' ? 'in' : ''));


   $imeiactive = '';
    if($title == 'View Unlock Category') $imeiactive = 'active';
    if($title == 'View IMEI Service') $imeiactive = 'active';
    if($title == 'View IMEI Service History(GSM)') $imeiactive = 'active';
    if($title == 'Manage State') $imeiactive = 'active';

    $imeiCollapce = '';
    if($title == 'View Unlock Category') $imeiCollapce = 'in';
    if($title == 'View IMEI Service') $imeiCollapce = 'in';
    if($title == 'View IMEI Service History(GSM)') $imeiCollapce = 'in';
    if($title == 'Manage State') $imeiCollapce = 'in';

     $reloadlyactive = '';
    if($title == 'Manage Reloadly Operators') $reloadlyactive = 'active';
    if($title == 'Manage Reloadly Country') $reloadlyactive = 'active';
    if($title == 'Manage Reloadly Discounts') $reloadlyactive = 'active';
    if($title == 'View International Reloadly History') $reloadlyactive = 'active';

    $reloadlyCollapce = '';
    if($title == 'Manage Reloadly Operators') $reloadlyCollapce = 'in';
    if($title == 'Manage Reloadly Country') $reloadlyCollapce = 'in';
    if($title == 'Manage Reloadly Discounts') $reloadlyCollapce = 'in';
    if($title == 'View International Reloadly History') $reloadlyCollapce = 'in';

    $dingconnectactive = '';
    if($title == 'View DingConnect Currency') $dingconnectactive = 'active';
    if($title == 'View DingConnect Region') $dingconnectactive = 'active';
    if($title == 'View DingConnect Provider') $dingconnectactive = 'active';
    if($title == 'View International Dingconnect History') $dingconnectactive = 'active';

    $dingconnectCollapce = '';
    if($title == 'View DingConnect Currency') $dingconnectCollapce = 'in';
    if($title == 'View DingConnect Region') $dingconnectCollapce = 'in';
    if($title == 'View DingConnect Provider') $dingconnectCollapce = 'in';
    if($title == 'View International Dingconnect History') $dingconnectCollapce = 'in';

    $blstoreactive = '';
    if($title == 'View BLCategory') $blstoreactive = 'active';
    if($title == 'View Product Type') $blstoreactive = 'active';
    if($title == 'View Sub Categories') $blstoreactive = 'active';
    if($title == 'View BLStore Brands') $blstoreactive = 'active';
    if($title == 'View BLStore Products') $blstoreactive = 'active';
    if($title == 'View BLOrders') $blstoreactive = 'active';
    if($title == 'BLOrder Report') $blstoreactive = 'active';
    if($title == 'BLStore Dashboard') $blstoreactive = 'active';
    if($title == 'View BLSlide') $blstoreactive = 'active';
    if($title == 'Manage BLShipping Method') $blstoreactive = 'active';

    $blstoreCollapce = '';
    if($title == 'View BLCategory') $blstoreCollapce = 'in';
    if($title == 'View Product Type') $blstoreCollapce = 'in';
    if($title == 'View Sub Categories') $blstoreCollapce = 'in';
    if($title == 'View BLStore Brands') $blstoreCollapce = 'in';
    if($title == 'View BLStore Products') $blstoreCollapce = 'in';
    if($title == 'View BLOrders') $blstoreCollapce = 'in';
    if($title == 'BLOrder Report') $blstoreCollapce = 'in';
    if($title == 'BLStore Dashboard') $blstoreCollapce = 'in';
    if($title == 'View BLSlide') $blstoreCollapce = 'in';
    if($title == 'Manage BLShipping Method') $blstoreCollapce = 'in';

    $blogsActive = '';
    if($title == 'Manage Blog') $blogsActive = 'active';
    if($title == 'View Blog Category') $blogsActive = 'active';

    $blogsCollapse = '';
    if($title == 'Manage Blog') $blogsCollapse = 'in';
    if($title == 'View Blog Category') $blogsCollapse = 'in';

    $prodattribute = $title == 'Manage UOM' || 'Action UOM' ? 'active' :  '';
    $prodattributeCollapse = $title == 'Manage UOM' || 'Action UOM' ? 'in' : '';

@endphp
<div class="fixed-sidebar-left">
    <ul class="nav navbar-nav side-nav nicescroll-bar">
        <li class="navigation-header">
            <span></span>
            <i class="zmdi zmdi-more"></i>
        </li>

        <li>
            <a class="{{ $title == 'Dashboard' ? 'active' :'' }}" href="{{ url(ADMINURL.'/dashboard') }}">
                <div class="pull-left">
                    <i class="fa fa-tachometer mr-20"></i>
                    <span class="right-nav-text"> Dashboard</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a class="{{ $title == 'Manage Admin' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewadmin') }}">
                <div class="pull-left">
                    <i class="fa fa-users mr-20"></i>
                    <span class="right-nav-text">Admin</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a class="{{ $title == 'Manage User' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewuser') }}">
                <div class="pull-left">
                    <i class="fa fa-users mr-20"></i>
                    <span class="right-nav-text">Users</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>



        <li>
            <a class="{{ $title == 'Manage Products' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewproduct') }}">
                <div class="pull-left">
                    <i class="fa fa-briefcase mr-20"></i>
                    <span class="right-nav-text">Products</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a class="{{ $title == 'Manage Orders' ? 'active' :'' }}" href="{{ url(ADMINURL.'/vieworder') }}">
                <div class="pull-left">
                    <i class="fa fa-shopping-cart mr-20"></i>
                    <span class="right-nav-text">Orders</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a  href="{{ url(ADMINURL.'/logout') }}">
                <div class="pull-left">
                    <i class="fa fa-power-off mr-20"></i>
                    <span class="right-nav-text">Log out</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>




    </ul>
</div>
<!-- /Left Sidebar Menu -->
