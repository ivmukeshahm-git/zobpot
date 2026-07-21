@extends('website.layout.layout')
@section('website-content')
    <main class="main">
        <section class="pt-50 login-register" id="RegisterEmployeeArea1">
            <div class="container">
                <div class="row  pb-50" id="PreferenceSelectEmp">
                    <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                        <div class="text-center">
                            <h2 class="mt-10 mb-5 text-brand-1">Choose Your Preference</h2>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                                <a title="UnSkilled-Employee" href="{{ route('register', ['preference_type' => 'non-skill','type' => $type]) }}">
                                    <div class="card-grid-2 hover-up text-center">
                                        <img src="{{ asset('assets/imgs/noneskill.png') }}" alt="None Skill">
                                        <h5 class="mb-3">UnSkilled</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                                <a title="Skilled-Employee" href="{{ route('register', ['preference_type' => 'skill','type' => $type]) }}">
                                    <div class="card-grid-2 hover-up text-center">
                                        <img src="{{ asset('assets/imgs/skill.png') }}" alt="Skill">
                                        <h5 class="mb-3">Skilled</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

    </main>
@endsection
