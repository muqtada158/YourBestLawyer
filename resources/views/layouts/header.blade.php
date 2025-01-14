<header>
    <div class="bg-secondary padding-left padding-right">
        <div class="container-xxl">
            <div class="row">
                <div class="col-4 col-lg-2">
                    <a class="site-logo" href="{{route('home')}}"><img width="100px" height="100px" src="{{asset('images/logo.png')}}" alt="Your Best Lawyers"></a>
                </div>
                <div class="col-8 col-lg-5 d-flex align-content-center justify-content-end justify-content-lg-center">
                    <nav class="navbar navbar-expand-lg background-primary justify-content-end">
                        <button  class="navbar-toggler p-0 hamburger text-white" id="hamburger-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                              <span class="line"></span>
                              <span class="line"></span>
                              <span class="line"></span>
                        </button>
                        <ul class="navbar-nav ml-auto w-100 gap-3 justify-content-center d-none d-lg-flex font-18">
                            <li class="nav-item">
                              <a class="nav-link text-white text-uppercase" href="{{route('home')}}">Home</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link text-white text-uppercase" href="{{route('customers')}}">Case Types</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link text-white text-uppercase" href="{{route('lawyers')}}">For Lawyers</a>
                            </li>
                            @if (auth()->check() && auth()->user()->user_type == 'customer' && auth()->user()->restricted_steps > 19)
                            <li class="nav-item">
                                <a class="nav-link text-white text-uppercase" href="{{route('customer_dashboard')}}">Dashboard</a>
                            </li>
                            @elseif (auth()->check() && auth()->user()->user_type == 'attorney' && auth()->user()->restricted_steps > 12)
                            <li class="nav-item">
                                <a class="nav-link text-white text-uppercase" href="{{route('attorney_dashboard')}}">Dashboard</a>
                            </li>
                            @elseif (auth()->check() && auth()->user()->user_type == 'admin')
                            <li class="nav-item">
                                <a class="nav-link text-white text-uppercase" href="{{route('admin_dashboard')}}">Dashboard</a>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                <div class="col-5 d-none d-lg-flex align-items-center justify-content-end">
                    @if (!auth()->check())
                        <a href="{{route('auth_index')}}#auth" class="btn btn-primary">Login/Sign Up</a>
                    @else
                        <a href="javascript:void(0)" onclick="showLoader(); event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-primary">Logout</a>
                    @endif
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
                <div class="col-12">
                    <div class="collapse navbar-collapse mt-2" id="navbarNav">
                        <ul class="navbar-nav ml-auto w-100 gap-3 justify-content-center">
                          <li class="nav-item">
                            <a class="nav-link text-white text-uppercase" href="{{route('home')}}">Home</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link text-white text-uppercase" href="{{route('customers')}}">Case Types</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link text-white text-uppercase" href="{{route('lawyers')}}">For Lawyers</a>
                          </li>
                          <li class="nav-item d-block d-lg-none">
                            @if (!auth()->user())
                            <a class="nav-link text-white text-uppercase" href="{{route('auth_index')}}">Login/Sign Up</a>
                            @else
                            <a class="nav-link text-white text-uppercase" onclick="showLoader(); event.preventDefault(); document.getElementById('logout-form').submit();" href="javascript:void(0)">Logout</a>
                            @endif
                          </li>
                        </ul>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <div class="go-top">
      <p class="go-top-text">Back To Top</p>
    </div>
</header>
