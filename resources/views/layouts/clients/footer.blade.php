        <!-- Support Area Start Here -->
        <div class="support-area bdr-top">
            <div class="container">
                <div class="d-flex flex-wrap text-center">
                    <div class="single-support">
                        <div class="support-icon">
                            <i class="lnr lnr-car"></i>
                        </div>
                        <div class="support-desc">
                            <h6>{{ __('Free Shipping') }}</h6>
                            <span>{{ __('Worlwide Delivery') }}</span>
                        </div>
                    </div>
                    <div class="single-support">
                        <div class="support-icon">
                           <i class="lnr lnr-lock"></i>
                        </div>
                        <div class="support-desc">
                            <h6>{{ __('Safe Payment') }}</h6>
                            <span>{{ __('Ship COD, Cashless payment') }}.</span>
                        </div>
                    </div>
                    <div class="single-support">
                        <div class="support-icon">
                           <i class="lnr lnr-laptop"></i>
                        </div>
                        <div class="support-desc">
                            <h6>{{ __('Prestige & Quality.') }}</h6>
                            <span>{{ __('Credibility and quality of each service.') }}</span>
                        </div>
                    </div>
                    <div class="single-support">
                        <div class="support-icon">
                           <i class="lnr lnr-enter-down"></i>
                        </div>
                        <div class="support-desc">
                            <h6>{{ __('Shop Confidence') }}</h6>
                            <span>{{ __('Buy with confidence') }}</span>
                        </div>
                    </div>
                    <div class="single-support">
                        <div class="support-icon">
                           <i class="lnr lnr-users"></i>
                        </div>
                        <div class="support-desc">
                            <h6>{{ __('24/7 Help Center') }}</h6>
                            <span>{{ __('Online support to answer all your questions') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container End -->
        </div>
        <!-- Support Area End Here -->

        <!-- them so sanh -->
        <div class="modal" id="sosanhsp">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title"></h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                  <div class="container">

                      <table class="table table-hover" id="row_compare" >
                        <thead>
                          <tr style="text-align: center;">
                            <th>{{ __('Product name') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Delete') }}</th>
                            <th>{{ __('Details') }}</th>
                          </tr>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                </div>

              </div>
            </div>
        </div>

        <!-- Footer Area Start Here -->
        <footer class="off-white-bg2 pt-95 bdr-top pt-sm-55">
            <!-- Footer Top Start -->
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <!-- Single Footer Start -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="single-footer mb-sm-40">
                                <h3 class="footer-title">{{ __('Information') }}</h3>
                                <div class="footer-content">
                                    <ul class="footer-list">
                                        <li><a href="about.html">{{ __('About Us') }}</a></li>
                                        <li><a href="#">{{ __('Delivery Information') }}</a></li>
                                        <li><a href="#">{{ __('Privacy Policy') }}</a></li>
                                        <li><a href="contact.html">{{ __('Terms & Conditions') }}</a></li>
                                        <li><a href="login.html">{{ __('FAQs') }}</a></li>
                                        <li><a href="login.html">{{ __('Return Policy') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Single Footer Start -->
                        <!-- Single Footer Start -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="single-footer mb-sm-40">
                                <h3 class="footer-title">{{ __('Customer Service') }}</h3>
                                <div class="footer-content">
                                    <ul class="footer-list">
                                        <li><a href="contact.html">{{ __('Contact Us') }}</a></li>
                                        <li><a href="#">{{ __('Returns') }}</a></li>
                                        <li><a href="{{ route('user.orderhistory') }}">{{ __('Order History') }}</a></li>
                                        <li><a href="wishlist.html">{{ __('Wish List') }}</a></li>
                                        <li><a href="#">{{ __('Site Map') }}</a></li>
                                        <li><a href="#">{{ __('Gift Certificates') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Single Footer Start -->
                        <!-- Single Footer Start -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="single-footer mb-sm-40">
                                <h3 class="footer-title">{{ __('Extras') }}</h3>
                                <div class="footer-content">
                                    <ul class="footer-list">
                                        <li><a href="#">{{ __('Newsletter') }}</a></li>
                                        <li><a href="#">{{ __('Brands') }}</a></li>
                                        <li><a href="#">{{ __('Gift Certificates') }}</a></li>
                                        <li><a href="#">{{ __('Affiliate') }}</a></li>
                                        <li><a href="#">{{ __('Specials') }}</a></li>
                                        <li><a href="#">{{ __('Site Map') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Single Footer Start -->
                        <!-- Single Footer Start -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="single-footer mb-sm-40">
                                <h3 class="footer-title">{{ __('My Account') }}</h3>
                                <div class="footer-content">
                                    <ul class="footer-list">
                                        <li><a href="contact.html">{{ __('Contact Us') }}</a></li>
                                        <li><a href="#">{{ __('Returns') }}</a></li>
                                        <li><a href="#">{{ __('My Account') }}</a></li>
                                        <li><a href="#">{{ __('Order History') }}</a></li>
                                        <li><a href="wishlist.html">{{ __('Wish List') }}</a></li>
                                        <li><a href="#">{{ __('Newsletter') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Single Footer Start -->
                        <!-- Single Footer Start -->
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="single-footer mb-sm-40">
                                <h3 class="footer-title">{{ __('My Store') }}</h3>
                                <div class="footer-content">
                                    <ul class="footer-list address-content">
                                        <li><i class="lnr lnr-map-marker"></i> {{ __('Address') }}: Số 7, Ngõ 92 đường Nguyễn Khánh Toàn, Cầu Giấy, Hà Nội</li>
                                        <li><i class="lnr lnr-envelope"></i><a href="#"> {{ __('Email') }}: support@nam.name.vn </a></li>
                                        <li>
                                            <i class="lnr lnr-phone-handset"></i> {{ __('Phone') }}: (+84) 899.179.992)
                                        </li>
                                    </ul>
                                    <div class="payment mt-25 bdr-top pt-30">
                                        <a href="#"><img class="img" src="{{ asset('themes/images/paymentmethod.png') }}" alt="payment-image"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single Footer Start -->
                    </div>
                    <!-- Row End -->
                </div>
                <!-- Container End -->
            </div>
            <!-- Footer Top End -->
            <!-- Footer Middle Start -->
            <div class="footer-middle text-center">
                <div class="container">
                    <div class="footer-middle-content pt-20 pb-30">
                            <ul class="social-footer">
                                <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="https://plus.google.com/"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="https://www.linkedin.com/"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                    </div>
                </div>
                <!-- Container End -->
            </div>
            <!-- Footer Middle End -->
            <!-- Footer Bottom Start -->
            <div class="footer-bottom pb-30">
                <div class="container">

                     <div class="copyright-text text-center">
                        <p>Copyright © 2022 <a target="_blank" href="#">{{ config('app.name', 'Ben Computer') }}</a> All Rights Reserved.</p>
                     </div>
                </div>
                <!-- Container End -->
            </div>
            <!-- Footer Bottom End -->
        </footer>
        <!-- Footer Area End Here -->
    </div>
    <!-- Main Wrapper End Here -->

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">{{ __('Sign out') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">{{ trans('Are you sure you want to sign out?') }}</div>
                <div class="modal-footer">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button class="btn btn-primary" type="submit">{{ __('Sign out') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery 3.2.1 -->
     <script src="{{ asset('js/modernizr.js') }}"></script>
    <script src="{{ asset('templates/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.3.2/jquery-migrate.min.js"></script>
    <!-- Countdown js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
    <!-- Mobile menu js -->
    <script src="{{ asset('templates/jquery.meanmenu/jquery.meanmenu.min.js') }}"></script>
    <!-- ScrollUp js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/scrollup/2.4.1/jquery.scrollUp.min.js"></script>
    <!-- Nivo slider js -->
    <script src="{{ asset('templates/nivo-slider/jquery.nivo.slider.js') }}"></script>
    <!-- Fancybox js -->
    <script src="{{ asset('templates/fancybox/dist/jquery.fancybox.min.js') }}"></script>
    <!-- Jquery nice select js -->
    <script src="{{ asset('templates/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    <!-- Jquery ui price slider js -->
    <script src="{{ asset('templates/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Owl carousel -->
    <script src="{{ asset('templates/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <!-- Bootstrap popper js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>

    <!-- Notification -->
    <script src="{{ asset('templates/toastr/toastr.min.js') }}"></script>

    <!-- Bootstrap js -->
    <script src="{{ asset('templates/bootstrap/dist/js/bootstrap.js') }}"></script>
    <!-- Plugin js -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <!-- Main activaion js -->
    <script src="{{ asset('js/main.js') }}"></script>

    @if(Session::has('success') || Session::has('info')
    || Session::has('warning') || Session::has('error'))
        <script>
            $(function(){
                @if(Session::has('success'))
                    toastr.success("{{ Session::get('success') }}");
                @endif

                @if(Session::has('info'))
                    toastr.info("{{ Session::get('info') }}");
                @endif

                @if(Session::has('warning'))
                    toastr.warning("{{ Session::get('warning') }}");
                @endif

                @if(Session::has('error'))
                    toastr.error("{{ Session::get('error') }}");
                @endif
            });
        </script>
    @endif
    @yield('addjs')
