<div class="sidebar col-lg-3 res-margin bg-light card h-50 pattern3">
    <div class="widget-area">
        <h5 class="sidebar-header">My Account</h5>
        <div class="list-group">
            <a href="{{url(FRONTENDURL.'dashboard')}}" class="list-group-item list-group-item-action {{request()->segment(1) == 'dashboard' ? 'active' : ''}}">
                Shipping Address
            </a>
            <a href="{{url(FRONTENDURL.'pets_master')}}" class="list-group-item list-group-item-action {{request()->segment(1) == 'pets_master' ? 'active' : ''}}">Pet Master Details</a>

            <a href="{{url(FRONTENDURL.'myorders')}}" class="list-group-item list-group-item-action {{request()->segment(1) == 'myorders' ? 'active' : ''}}">My Orders</a>
            <a href="{{url(FRONTENDURL.'upcoming_delivery')}}" class="list-group-item list-group-item-action {{request()->segment(1) == 'upcoming_delivery' ? 'active' : ''}}">Upcoming Delivery</a>
            <a href="{{url(FRONTENDURL.'user_subscription')}}" class="list-group-item list-group-item-action {{request()->segment(1) == 'user_subscription' ? 'active' : ''}}">My Subscription</a>

            <a href="{{url(FRONTENDURL.'change_password')}}" class="list-group-item list-group-item-action {{request()->segment(1) == 'change_password' ? 'active' : ''}}">Change Password</a>
            <a href="{{url(FRONTENDURL.'logout')}}" class="list-group-item list-group-item-action">Logout</a>
        </div>
        <!-- /list-group -->
    </div>
    <!-- /widget-area -->
</div>
