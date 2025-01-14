<div class="sidebar bg-white p-3 radius-20 row">
    <div class="customer-avatar-box text-center col-12 mb-5">
        <div class="customer-avatar text-center">
            <img class="w-100" src="{{asset(getUser()->getUserDetails->image)}}" alt="">
            <a href="{{route('attorney_profile')}}" class="settings-icon xy-center">
                <i class="fas fa-cog"></i>
            </a>
        </div>
        <h4 class="customer-name font-18 mt-4 fw-bold font-accent">{{ucfirst(getUser()->getUserDetails->first_name)}} {{ucfirst(getUser()->getUserDetails->last_name)}}</h4>
        <h4 class="customer-position text-primary font-14 fw-bold font-accent">{{ucfirst(getUser()->user_type)}}</h4>
    </div>

    <div class="col-lg-12">
        <a href="{{route('attorney_cases')}}">
            <div class="number-boxes radius-20 py-2 px-1">
                <div class=" inline count bg-primary xy-center">
                    <img src="{{asset('images/svg/cases.svg')}}" class="icon-size-medium" alt="">
                </div>
                <div class="inline text-left xy-center">
                    <h5 class="font-18 fw-bold mt-2 text-black">Cases</h5>
                </div>
                <div class="inline float-end mt-2">
                    <h6 class="font-18 fw-bold mt-2 accent-color-2 font-accent">{{countAttorneyCases()}} &nbsp;</h6>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-12 mt-3">
        <a href="{{route('attorney_leads')}}">
            <div class="number-boxes radius-20 py-2 px-1">
                <div class="inline count bg-primary xy-center">
                    <img src="{{asset('images/svg/leads.png')}}" class="icon-size-medium" alt="">
                </div>
                <div class="inline text-left xy-center">
                    <h5 class="font-18 fw-bold mt-2 text-black">Leads</h5>
                </div>
                <div class="inline float-end mt-2">
                    <h6 class="font-18 fw-bold mt-2 accent-color-2 font-accent pl-2">{{countLeads()}} &nbsp;</h6>
                </div>
            </div>
        </a>
    </div>

    <ul class="customer-portal-menu mb-5 list-unstyled col-12 mt-5 d-flex flex-column gap-4">
        <a class="accent-color-2 fw-bold font-18" href="{{route('attorney_dashboard')}}">
            <li class="single-menu {{request()->route()->getName() === 'attorney_dashboard' ? 'active' : ''}}"><img src="{{asset('images/svg/dashboard.svg')}}" class="sidebar-icon-default-color" alt=""> Dashboard </li>
        </a>
        <a class="accent-color-2 fw-bold font-18" href="{{route('attorney_profile')}}">
            <li class="single-menu {{ in_array(request()->route()->getName(), ['attorney_profile', 'attorney_profile_edit']) ? 'active' : '' }}"><img src="{{asset('images/svg/profile.svg')}}" class="sidebar-icon-default-color" alt=""> My Profile </li>
        </a>

        <a class="accent-color-2 fw-bold font-18" href="{{route('attorney_contract_accepted')}}">
            <li class="single-menu {{in_array(request()->route()->getName(), ['attorney_contract_accepted', 'attorney_contract_new', 'attorney_contracts_details']) ? 'active' : '' }}">
                <img src="{{asset('images/svg/Contract.svg')}}" class="sidebar-icon-default-color" alt="">
                Contract
            </li>
        </a>

        <a class="accent-color-2 fw-bold font-18" href="{{route('attorney_faqs')}}">
            <li class="single-menu {{request()->route()->getName() === 'attorney_faqs' ? 'active' : ''}}">
                <img src="{{asset('images/svg/faqs.svg')}}" class="sidebar-icon-default-color" alt="">
                FAQ's
            </li>
        </a>

        <a class="accent-color-2 fw-bold font-18" href="{{route('attorney_payment_transactions')}}">
            <li class="single-menu {{request()->route()->getName() === 'attorney_payment_transactions' ? 'active' : ''}}">
                <img src="{{asset('images/svg/payment.svg')}}" class="sidebar-icon-default-color" alt="">
                Payment Transaction
            </li>
        </a>

        <a class="accent-color-2 fw-bold font-18" href="{{route('attorney_schedule')}}">
            <li class="single-menu {{request()->route()->getName() === 'attorney_schedule' ? 'active' : ''}}">
                <img src="{{asset('images/svg/calendar.png')}}" class="sidebar-icon-default-color" alt="">
                Schedule
            </li>
        </a>

        <a class="accent-color-2 fw-bold font-18" href="{{route('attorney_chat_list')}}">
            <li class="single-menu {{in_array(request()->route()->getName(), ['attorney_chat_list', 'attorney_messages']) ? 'active' : ''}}">
                <img src="{{asset('images/svg/Messenger.png')}}" class="sidebar-icon-default-color" alt="">
                Chat
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

