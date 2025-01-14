<footer class="bg-accent padding-section-medium">
    <div class="container-xxl">
        <div class="row">

            <div class="col-lg-4 col-md-6 col-12 text-center order-md-1 order-2">
                <h5 class="fw-bolder text-primary">Discover</h5>
                <ul class="list-unstyled d-flex flex-column gap-3 mt-4">
                    <li><a class="text-white" href="{{route('home')}}">Home</a></li>
                    <li><a class="text-white" href="{{route('customers')}}">Case Types</a></li>
                    <li><a class="text-white" href="{{route('lawyers')}}">For Lawyers</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-12  col-12 text-center order-md-2 order-1">
                <img width="100px" height="100px" src="{{asset('images/logo2.png')}}" alt="">
                <h3 class="text-primary mt-2 text-center">YourBestLawyer.com</h3>
                <p class="text-white mt-2">Empowering you through legal clarity!</p>
            </div>
            <div class="col-lg-4 col-md-6 col-12 text-center order-md-3 order-3">
                <h5 class="fw-bolder text-primary">Stay in Touch</h5>
                <ul class="list-unstyled d-flex flex-column gap-3 mt-4">
                    <li><a class="text-white" href="callto:602-264-7777"><i class="fa-solid fa-phone me-2"></i>602-264-7777</a></li>
                    <li><a class="text-white" href="mailto:help@yourbestlawyer.com"><i class="fa-solid fa-envelope me-2"></i>help@yourbestlawyer.com</a></li>
                    <li><a class="text-white" href="https://maps.app.goo.gl/CfNDajAfWcXK8Pf3A" target="__blank"><i class="fa-solid fa-location-dot me-2"></i>11201 N Tatum Blvd., Suite 300 | Phoenix, AZ | 85028</a></li>
                </ul>
                {{-- <form class="footer-newsletter d-flex" action="">
                    <input type="text" name="newsletter-email" class="w-100 bg-transparent border-0 text-white " placeholder="Enter your email address">
                    <button type="submit"><i class="fa-solid fa-chevron-right"></i></button>
                </form> --}}
            </div>
        </div>
        <div class="footer-social-icons-container mt-5">
            <div class="footer-social-icons px-4">
                <a class="footer-social-icon" href="#"><i class="fab fa-twitter"></i></a>
                <a class="footer-social-icon" href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a class="footer-social-icon" href="#"><i class="fa-brands fa-instagram"></i></i></a>
                <a class="footer-social-icon" href="#"><i class="fa-brands fa-youtube"></i></a>
                <a class="footer-social-icon" href="#"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
</footer>
{{-- <footer class="bg-accent padding-section-medium">
    <div class="container-xxl">
        <div class="row">
            <div class="col-lg-12 col-md-12  col-12 text-center">
                <img width="100px" height="100px" src="{{asset('images/logo2.png')}}" alt="">
                <p class="text-white mt-4">Your Best Lawyer</p>
            </div>
        </div>
    </div>
</footer> --}}
