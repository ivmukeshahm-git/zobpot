@extends('website.layout.layout')
@section('website-content')
    <main class="main">
        <!-- Register Type Section -->
        <section class="pt-50 login-register">
            <div class="container">
                <div class="row pb-50">
                    <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                        <div class="text-center">
                            <h2 class="mt-10 mb-5 text-brand-1">Welcome Back!</h2>
                            <h5 class="text-muted mb-30">Please select your login type to continue.</h5>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                                <a title="Employee"
                                    href="{{ $url == 'register' ? route('preference', ['login_type' => 'register', 'type' => 'employee']) : route('login', ['login_type' => 'employee']) }}">
                                    <div class="card-grid-2 hover-up text-center">
                                        <img src="{{ asset('assets/imgs/employee.png') }}" alt="">
                                        <h5 class="mb-3">Employee</h5>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                                <a title="Company"
                                    href="{{ $url == 'register' ? route('company-register') : route('login', ['login_type' => 'employee']) }}">
                                    <div class="card-grid-2 hover-up text-center">
                                        <img src="{{ asset('assets/imgs/Company.png') }}" alt="">
                                        <h5 class="mb-3">Company</h5>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- End Select Area -->
    </main>
@endsection

