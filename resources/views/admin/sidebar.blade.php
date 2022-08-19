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
            <a class="{{ $title == 'Manage Category' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewcategories') }}">
                <div class="pull-left">
                    <i class="fa fa-briefcase mr-20"></i>
                    <span class="right-nav-text">Categories</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a class="{{ $title == 'Manage Brands' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewbrands') }}">
                <div class="pull-left">
                    <i class="fa fa-sitemap mr-20"></i>
                    <span class="right-nav-text">Brands</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>


        <li>
            <a class="{{ $title == 'Manage Sub Category' ? 'active' :'' }}"  href="{{ url(ADMINURL.'/viewsubcategories') }}">
                <div class="pull-left">
                    <i class="fa fa-briefcase mr-20"></i>
                    <span class="right-nav-text">Sub Categories</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a class="{{ $locationactive }} href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_dr">
                <div class="pull-left">
                    <i class="fa fa-map-marker mr-20"></i>
                    <span class="right-nav-text">Location</span>
                </div>
                <div class="pull-right">
                    <i class="zmdi zmdi-caret-down"></i>
                </div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_dr" class="collapse collapse-level-1 {{ $locationCollapce }}">
                <li>
                    <a class="{{ $title == 'Manage City' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/viewcity') }}">City</a>
                </li>
                <li>
                    <a class="{{ $title == 'Manage State' ? 'active-page' :'' }}" href="{{ url(ADMINURL.'/viewstate') }}">State</a>
                </li>

                <li>
                    <a class="{{ $title == 'Manage Country' ? 'active-page' :'' }}" href="{{ url(ADMINURL.'/viewcountry') }}">Country</a>
                </li>
            </ul>
        </li>

        <li>
            <a class="{{ $title == 'Manage Users' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewusers') }}">
                <div class="pull-left">
                    <i class="fa fa-user mr-20"></i>
                    <span class="right-nav-text">Users</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a class="{{ $title == 'Manage Products' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewproducts') }}">
                <div class="pull-left">
                    <i class="fa fa-product-hunt mr-20"></i>
                    <span class="right-nav-text">Products</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>



        <!--<li>-->
        <!--    <a class="{{ $title == 'Manage Cart' ? 'active' :'' }}" href="#">-->
        <!--        <div class="pull-left">-->
        <!--            <i class="fa fa-shopping-cart mr-20"></i>-->
        <!--            <span class="right-nav-text">Cart Items</span>-->
        <!--        </div>-->
        <!--        <div class="clearfix"></div>-->
        <!--    </a>-->
        <!--</li>-->

        <li>
            <a class="{{ $title == 'Manage Orders' ? 'active' :'' }}" href="{{ url(ADMINURL.'/vieworders') }}">
                <div class="pull-left">
                    <i class="fa fa-shopping-bag mr-20"></i>
                    <span class="right-nav-text">Orders</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a class="{{ $title == 'Manage Shipping Method' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewshippingmethods') }}">
                <div class="pull-left">
                    <i class="fa fa-shopping-bag mr-20"></i>
                    <span class="right-nav-text">Shipping Method</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a class="{{ $title == 'Manage Payment Method' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewpaymentmethods') }}">
                <div class="pull-left">
                    <i class="fa fa-shopping-bag mr-20"></i>
                    <span class="right-nav-text">Payment Method</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a class="{{ $title == 'Manage Carrier' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewcarriers') }}">
                <div class="pull-left">
                    <i class="fa fa-product-hunt mr-20"></i>
                    <span class="right-nav-text">Carriers</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a class="{{ $title == 'Manage Voucher' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewvouchers') }}">
                <div class="pull-left">
                    <i class="fa fa-product-hunt mr-20"></i>
                    <span class="right-nav-text">Vouchers</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a class="{{ $title == 'Manage Voucher Item' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewvouchersitems') }}">
                <div class="pull-left">
                    <i class="fa fa-product-hunt mr-20"></i>
                    <span class="right-nav-text">Vouchers Item</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
          <li>
            <a class="{{ $title == 'Manage Credits' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewcreditshistory') }}">
                <div class="pull-left">
                    <i class="fa fa-product-hunt mr-20"></i>
                    <span class="right-nav-text" style="text-overflow: ellipsis;
                        white-space: nowrap;
                        overflow: hidden;
                        width: 9em;
                        display: inline-block;">Credits History</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <!--<li>-->
        <!--    <a class="{{ $title == 'Manage Voucher Item' ? 'active' :'' }}" href="{{ url(ADMINURL.'/getvoucherreport') }}">-->

        <!--        <div class="pull-left">-->
        <!--            <i class="fa fa-product-hunt mr-20"></i>-->
        <!--            <span class="right-nav-text">Vouchers Report</span>-->
        <!--        </div>-->
        <!--        <div class="clearfix"></div>-->
        <!--    </a>-->
        <!--</li>-->

        <li>
            <a class="{{ $title == 'Manage Voucher Item' ? 'active' :'' }}" href="{{ url(ADMINURL.'/getvoucherreport') }}">

                <div class="pull-left">
                    <i class="fa fa-product-hunt mr-20"></i>
                    <span class="right-nav-text">Vouchers Report</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li>
            <a class="{{ $blstoreactive }} href="javascript:void(0);" data-toggle="collapse" data-target="#blstorelist">
                <div class="pull-left">
                    <i class="fa fa-lock mr-20"></i>
                    <span class="right-nav-text">BLStore</span>
                </div>
                <div class="pull-right">
                    <i class="zmdi zmdi-caret-down"></i>
                </div>
                <div class="clearfix"></div>
            </a>
            <ul id="blstorelist" class="collapse collapse-level-1 {{ $blstoreCollapce }}">
                <li>
                    <a class="{{ $title == 'BLStore Dashboard' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/bldashboard') }}">Dashboard</a>
                </li>
                <li>
                    <a class="{{ $title == 'View BLSlide' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/viewblslide') }}">Slides</a>
                </li>

                <li>
                    <a class="{{ $title == 'View BLStore Brands' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/viewblbrands') }}">Brands</a>
                </li>
                <li>
                    <a class="{{ $title == 'View BLCategory' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/viewblcategory') }}">Categories</a>
                </li>

                 <li>
                    <a class="{{ $title == 'Manage BLShipping Method' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/viewblshippingmethods') }}">Shipping Methods</a>
                </li>

                <li>
                    <a class="{{ $title == 'View Product Type' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/viewproducttype') }}">Product Type</a>
                </li>

                <li>
                    <a class="{{ $title == 'View Sub Categories' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/viewblsubcategory') }}">Sub-Categories</a>
                </li>

                <li>
                    <a class="{{ $title == 'View BLStore Products' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/viewblproducts') }}">Products</a>
                </li>

                <li>
                    <a class="{{ $title == 'View BLOrders' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/viewblorders') }}">Orders</a>
                </li>

                <li>
                    <a class="{{ $title == 'BLOrder Report' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/getblreport') }}">Report</a>
                </li>


            </ul>
        </li>


        @if(session('admin_role') == 1)
         <li>
            <a class="{{ $imeiactive }} href="javascript:void(0);" data-toggle="collapse" data-target="#imeilist">
                <div class="pull-left">
                    <i class="fa fa-lock mr-20"></i>
                    <span class="right-nav-text">Unlock Service</span>
                </div>
                <div class="pull-right">
                    <i class="zmdi zmdi-caret-down"></i>
                </div>
                <div class="clearfix"></div>
            </a>
            <ul id="imeilist" class="collapse collapse-level-1 {{ $imeiCollapce }}">
                 <li>
                    <a class="{{ $title == 'View Unlock Category' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/viewunlockcategory') }}">IMEI Category</a>
                </li>
                <li>
                    <a class="{{ $title == 'View IMEI Service' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/getallimeiservice') }}">IMEI</a>
                </li>

                <li>
                    <a class="{{ $title == 'View IMEI Service History(GSM)' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/getallimeiservice_history') }}">IMEI History</a>
                </li>

            </ul>
        </li>


         <li>
            <a class="{{ $reloadlyactive }} href="javascript:void(0);" data-toggle="collapse" data-target="#reloadlylist">
                <div class="pull-left">
                    <i class="fa fa-map-marker mr-20"></i>
                    <span class="right-nav-text">Reloadly</span>
                </div>
                <div class="pull-right">
                    <i class="zmdi zmdi-caret-down"></i>
                </div>
                <div class="clearfix"></div>
            </a>
            <ul id="reloadlylist" class="collapse collapse-level-1 {{ $reloadlyCollapce }}">
                <li>
                    <a class="{{ $title == 'Manage Reloadly Operators' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/reloadly_country_operators') }}">Operators</a>
                </li>
                <li>
                    <a class="{{ $title == 'Manage Reloadly Country' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/reloadly_countries') }}">Country</a>
                </li>
                <li>
                    <a class="{{ $title == 'Manage Reloadly Discounts' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/reloadly_discounts') }}">Discounts</a>
                </li>
                 <li>
                    <a class="{{ $title == 'View International Reloadly History' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/getinternationalhistory?type=reloadly') }}">History(Intl)</a>
                </li>
            </ul>
        </li>

         <li>
            <a class="{{ $dingconnectactive }} href="javascript:void(0);" data-toggle="collapse" data-target="#dingconnect">
                <div class="pull-left">
                    <i class="fa fa-map-marker mr-20"></i>
                    <span class="right-nav-text">Ding Connect</span>
                </div>
                <div class="pull-right">
                    <i class="zmdi zmdi-caret-down"></i>
                </div>
                <div class="clearfix"></div>
            </a>
            <ul id="dingconnect" class="collapse collapse-level-1 {{ $dingconnectCollapce }}">
                <li>
                    <a class="{{ $title == 'View DingConnect Currency' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/dingconnect_currency') }}">Currency</a>
                </li>
                <li>
                    <a class="{{ $title == 'View DingConnect Region' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/dingconnect_region') }}">Region</a>
                </li>
                <li>
                    <a class="{{ $title == 'View DingConnect Provider' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/dingconnect_provider') }}"> Provider</a>
                </li>
                 <li>
                    <a class="{{ $title == 'View International Dingconnect History' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/getinternationalhistory?type=dingconnect') }}">History(Intl)</a>
                </li>
            </ul>
        </li>
        @endif

        <!--  <li>-->
        <!--    <a class="{{ $title == 'Manage Blog' ? 'active' :'' }}" href="{{ url(ADMINURL.'/viewblog') }}">-->
        <!--        <div class="pull-left">-->
        <!--            <i class="fa fa-product-hunt mr-20"></i>-->
        <!--            <span class="right-nav-text">Blog</span>-->
        <!--        </div>-->
        <!--        <div class="clearfix"></div>-->
        <!--    </a>-->
        <!--</li>-->

         <li>
            <a class="{{ $blogsActive }} href="javascript:void(0);" data-toggle="collapse" data-target="#blogslost">
                <div class="pull-left">
                    <i class="fa fa-lock mr-20"></i>
                    <span class="right-nav-text">Blog</span>
                </div>
                <div class="pull-right">
                    <i class="zmdi zmdi-caret-down"></i>
                </div>
                <div class="clearfix"></div>
            </a>
            <ul id="blogslost" class="collapse collapse-level-1 {{ $blogsCollapse }}">
                <li>
                    <a class="{{ $title == 'Manage Blog' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/viewblog') }}">Blog List</a>
                </li>
                <li>
                    <a class="{{ $title == 'View Blog Category' ? 'active-page' :'' }} mr-20" href="{{ url(ADMINURL.'/viewblogcategory') }}">Category</a>
                </li>
            </ul>
        </li>

        <li>
            <a class="{{ $title == 'Manage Flash News' ? 'active' :'' }}" href="{{ url(ADMINURL.'/flashnews') }}">
                <div class="pull-left">
                    <i class="fa fa-briefcase mr-20"></i>
                    <span class="right-nav-text">Flash News</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

<!--
        <li>
            <a class="{{ $title == 'Manage Cart' ? 'active' :'' }}" href="{{ url(ADMINURL.'/import') }}">
                <div class="pull-left">
                    <i class="fa fa-cloud-upload mr-20"></i>
                    <span class="right-nav-text">Import </span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li> -->

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
