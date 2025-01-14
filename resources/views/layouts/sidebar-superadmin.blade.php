<div class="sidebar bg-white p-3 radius-20 row">
    <div class="customer-avatar-box text-center col-12 mb-5">
        <div class="customer-avatar text-center">
            <img class="w-100" src="{{asset('images/super-admin.png')}}" alt="">
            <a href="#" class="settings-icon xy-center">
                <i class="fas fa-cog"></i>
            </a>
        </div>
        <h4 class="customer-name font-18 mt-4 fw-bold font-accent">Admin</h4>
        <h4 class="customer-position text-primary font-14 fw-bold font-accent">Super Admin</h4>
    </div>

    <div class="col-lg-12">
        <a href="{{route('admin_clients')}}">
            <div class="number-boxes radius-20 py-2 px-1">
                <div class=" inline count bg-primary xy-center">
                    <img src="{{asset('images/svg/clients-white.png')}}" class="icon-size-medium" alt="">
                </div>
                <div class="inline text-left xy-center">
                    <h5 class="font-18 fw-bold mt-2 text-black">Client</h5>
                </div>
                <div class="inline float-end mt-2">
                    <h6 class="font-18 fw-bold mt-2 accent-color-2 font-accent">{{countCustomer()}} &nbsp;</h6>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-12 mt-3">
        <a href="{{route('admin_attornies')}}">
            <div class="number-boxes radius-20 py-2 px-1">
                <div class="inline count bg-primary xy-center">
                    <img src="{{asset('images/svg/attorney.svg')}}" class="icon-size-medium" alt="">
                </div>
                <div class="inline text-left xy-center">
                    <h5 class="font-18 fw-bold mt-2 text-black">Attorney</h5>
                </div>
                <div class="inline float-end mt-2">
                    <h6 class="font-18 fw-bold mt-2 accent-color-2 font-accent pl-2">{{countAttorney()}} &nbsp;</h6>
                </div>
            </div>
        </a>
    </div>

    {{-- <ul class="customer-portal-menu mb-5 list-unstyled col-12 mt-5 d-flex flex-column gap-4">
        <li class="single-menu {{request()->route()->getName() === 'admin_dashboard' ? 'active' : ''}}"><a class="accent-color-3 fw-bold font-18" href="{{route('admin_dashboard')}}"><i class="fa-solid fa-table-cells-large me-2 me-md-4"></i>Dashboard</a></li>
        <li class="single-menu {{request()->route()->getName() === 'admin_attornies' ? 'active' : ''}}"><a class="accent-color-3 fw-bold font-18" href="{{route('admin_attornies')}}"><i class="fa-solid fa-scale-balanced me-2 me-md-4"></i>Attornies</a></li>
        <li class="single-menu {{request()->route()->getName() === 'admin_clients' ? 'active' : ''}}"><a class="accent-color-3 fw-bold font-18" href="{{route('admin_clients')}}"><i class="fa-solid fa-users me-2 me-md-4"></i>Clients</a></li>
        <li class="single-menu {{request()->route()->getName() === 'admin_application' ? 'active' : ''}}"><a class="accent-color-3 fw-bold font-18" href="{{route('admin_application')}}"><i class="fa-solid fa-file-signature me-2 me-md-4"></i>Applications</a></li>
        <li class="single-menu {{request()->route()->getName() === 'admin_cases' ? 'active' : ''}}"><a class="accent-color-3 fw-bold font-18" href="{{route('admin_cases')}}"><i class="fa-solid fa-folder-tree me-2 me-md-4"></i>Cases</a></li>
        <li class="single-menu {{request()->route()->getName() === 'admin_media' ? 'active' : ''}}"><a class="accent-color-3 fw-bold font-18" href="{{route('admin_media')}}"><i class="fa-solid fa-photo-film me-2 me-md-4"></i>Media</a></li>
        <li class="single-menu {{request()->route()->getName() === 'admin_faqs' ? 'active' : ''}}"><a class="accent-color-3 fw-bold font-18" href="{{route('admin_faqs')}}"><i class="fa-solid fa-circle-question me-2 me-md-4"></i>FAQ's</a></li>
        <li class="single-menu {{request()->route()->getName() === 'admin_payment_transactions' ? 'active' : ''}}"><a class="accent-color-3 fw-bold font-18" href="{{route('admin_payment_transactions')}}"><i class="fa-solid fa-money-bill-transfer me-2 me-md-4"></i>Payment Transaction</a></li>
        <li class="single-menu {{request()->route()->getName() === 'admin_schedule' ? 'active' : ''}}"><a class="accent-color-3 fw-bold font-18" href="{{route('admin_schedule')}}"><i class="fa-solid fa-calendar-days me-2 me-md-4"></i>Schedule</a></li>
        <li class="single-menu {{request()->route()->getName() === 'admin_invite' ? 'active' : ''}}"><a class="accent-color-3 fw-bold font-18" href="{{route('admin_invite')}}"><i class="fa-solid fa-people-group me-2 me-md-4"></i>Invite</a></li>
        <li class="single-menu {{request()->route()->getName() === 'admin_contract' ? 'active' : ''}}"><a class="accent-color-3 fw-bold font-18" href="{{route('admin_contract')}}"><i class="fa-solid fa-handshake me-2 me-md-4"></i>Contract</a></li>
        <li class="single-menu {{request()->route()->getName() === 'admin_profile' ? 'active' : ''}}"><a class="accent-color-3 fw-bold font-18" href="{{route('admin_profile')}}"><i class="fa-regular fa-circle-user me-2 me-md-4"></i>My Profile</a></li>
    </ul> --}}
    <ul class="customer-portal-menu mb-5 list-unstyled col-12 mt-5 d-flex flex-column gap-4">
        <a class="accent-color-2 fw-bold font-18" href="{{route('admin_dashboard')}}">
            <li class="single-menu {{request()->route()->getName() === 'admin_dashboard' ? 'active' : ''}}"><img src="{{asset('images/svg/dashboard.svg')}}" class="sidebar-icon-default-color" alt=""> Dashboard </li>
        </a>
        <a class="accent-color-2 fw-bold font-18" href="{{route('admin_profile')}}">
            <li class="single-menu {{ in_array(request()->route()->getName(), ['admin_profile', 'admin_profile_edit']) ? 'active' : '' }}"><img src="{{asset('images/svg/profile.svg')}}" class="sidebar-icon-default-color" alt=""> My Profile </li>
        </a>
        <a class="accent-color-2 fw-bold font-18" href="{{route('admin_application')}}">
            <li class="single-menu {{request()->route()->getName() === 'admin_applications' ? 'active' : ''}}"><img src="{{asset('images/svg/application.svg')}}" class="sidebar-icon-default-color" alt=""> Application</li>
        </a>
        {{-- <li class="single-menu {{request()->route()->getName() === 'admin_cases' ? 'active' : ''}}"><a class="accent-color-2 fw-bold font-18" href="{{route('admin_cases')}}"><img src="{{asset('images/svg/cases.svg')}}" class="sidebar-icon-default-color" alt=""> Cases</a></li> --}}
        {{-- <li class="single-menu {{request()->route()->getName() === 'admin_attornies' ? 'active' : ''}}"><a class="accent-color-2 fw-bold font-18" href="{{route('admin_attornies')}}"><i class="fa-solid fa-scale-balanced me-2 me-md-4"></i>Attornies</a></li>
        <li class="single-menu {{request()->route()->getName() === 'admin_media' ? 'active' : ''}}"><a class="accent-color-2 fw-bold font-18" href="{{route('admin_media')}}"><i class="fa-solid fa-photo-film me-2 me-md-4"></i>Media</a></li> --}}


        <a class="accent-color-2 fw-bold font-18" href="{{route('admin_cases')}}">
            <li class="single-menu {{request()->route()->getName() === 'admin_cases' ? 'active' : ''}}">
                <img src="{{asset('images/svg/cases.svg')}}" class="sidebar-icon-default-color" alt="">
                Cases
            </li>
        </a>

        <a class="accent-color-2 fw-bold font-18" href="{{route('admin_payment_transactions')}}">
            <li class="single-menu {{request()->route()->getName() === 'admin_payment_transactions' ? 'active' : ''}}">
                <img src="{{asset('images/svg/payment.svg')}}" class="sidebar-icon-default-color" alt="">
                Payment Transaction
            </li>
        </a>

        <a class="accent-color-2 fw-bold font-18" href="{{route('admin_contract',['Accepted'])}}">
            <li class="single-menu {{request()->route()->getName() === 'admin_contract' ? 'active' : ''}}">
                <img src="{{asset('images/svg/Contract.svg')}}" class="sidebar-icon-default-color" alt="">
                Contract
            </li>
        </a>

    </ul>

    {{-- <div class="notification-box radius-20 p-3 col-12 mt-5">
        <div class="bell-icon bg-primary xy-center">
            <i class="fa-regular fa-bell"></i>
        </div>
        <h6 class="fw-bold font-14 text-primary text-center my-4">
            <span class="accent-color-3 font-accent">Notification</span>
        </h6>
        <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10">View</a>
        <!-- <a href="register.php" class="btn-primary w-100 d-block text-center p-1 radius-20">Activate</a> -->
    </div>

    <div class="mt-4">
        <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"><i class="fa-solid fa-headset" ></i> Support</a>
    </div> --}}
</div>
<style>
    .customer-avatar{
        position: relative;
        max-width: 111px;
        margin: auto;
    }
    .customer-avatar img{
        height: 111px;
        border-radius: 111px;
        object-fit: cover;
        object-position: center;
        display: block;
        margin: auto;
    }
    .settings-icon{
        color:#fff;
        border-radius: 33px;
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: var(--color-primary);
        width:33px;
        height: 33px;
    }
    .settings-icon:hover{
        color:#fff;
        opacity: .9;
    }
    .notification-box{
        background: var(--color-df22g);
    }
    .notification-box .bell-icon{
        margin: auto;
        width:94px;
        height: 94px;
        border-radius: 100px;
        font-size:60px;
        color:#fff;
        margin-top:-50px;
    }
    .number-boxes{
        background-color: var(--color-df22g);
    }
    .number-boxes .count {
        width: 50px;
        height: 50px;
        color: #fff;
        border-radius: 100px;
        display: inline-flex;
    }
    /* .customer-portal-menu .single-menu:hover a{
        color: var(--color-primary) !important;
    }
    .customer-portal-menu .active a{
        color:var(--color-primary) !important;
    }
    .customer-portal-menu .active{
        position: relative;
    }
    .customer-portal-menu .active::after{
        content: '';
        width:10px;
        height: 100%;
        background-color: var(--color-primary);
        position: absolute;
        right: 0;
        border-radius: 10px 0px 0px 10px;
    } */
    .sidebar-icon-default-color {
        filter: invert(56%) sepia(59%) saturate(251%) hue-rotate(348deg) brightness(94%) contrast(85%);
        width: 24px;
        padding: 0px;
        margin-right: 3px;
    }
    li.single-menu:hover {
        background-color: #e3e3e4;
        padding: 5px;
        border-radius: 5px;
    }
    li.single-menu{
        padding: 5px;
        border-radius: 5px;
    }
    li.single-menu.active{
        background-color: #e3e3e4;
        padding: 5px;
        border-radius: 5px;
    }
</style>

