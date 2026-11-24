@extends('website.layout.layout')
@section('website-content')
    <main class="main">
        <section class="section-box mt-90">
            <div class="container">

                <!-- Toggle Heading -->
                <div class="text-center mb-2">
                    <h2 class="mb-15 wow animate__animated animate__fadeInUp">Choose The Best Plan That's For You</h2>

                    <div class="pricing-toggle-container ">
                        <div class="toggle-switch">
                            <input type="radio" id="employee-toggle" name="pricing-type" value="employee" checked>
                            <label for="employee-toggle" class="toggle-label">For Employees</label>

                            <input type="radio" id="company-toggle" name="pricing-type" value="company">
                            <label for="company-toggle" class="toggle-label">For Companies</label>

                            <div class="toggle-slider"></div>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="user_id" value="">

                <!-- Employee Pricing -->
                <div id="employee-pricing" class="pricing-section active">
                    {{-- Job / Internship filters hidden temporarily for the employee plan --}}
                    {{--
                    <div class="filter-buttons-container">
                        <button class="filter-btn active" data-filter="job" data-type="employee">Job</button>
                        <button class="filter-btn" data-filter="internship" data-type="employee">Internship</button>
                    </div>
                    --}}

                    <div class="row d-flex justify-content-center">

                        @foreach ($pricing as $row)
                            @php
                                $benefits = $row->benefits_list;
                                $planService = \App\Models\PlanPricing::normalizeService($row->service ?? null);
                                if ($planService === 'none') {
                                    $planService = 'job';
                                }
                            @endphp

                            <div class="col-xl-4 col-lg-6 col-md-6 pricing-item"
                                data-service="{{ $planService }}">
                                <div class="pricing-card">

                                    <div class="pricing-header employee">
                                        <h3 class="text-white">{{ $row->plan_name }}</h3>
                                        <div class="price-box">
                                            <span class="price">₹{{ (int) $row->plan_price }}</span>
                                            <small>/ {{ $row->plan_time }}
                                                {{ $row->plan_duration == 'M' ? 'Months' : ($row->plan_duration == 'Y' ? 'Year' : 'Day') }}</small>
                                        </div>
                                    </div>

                                    <p class="plan-desc">
                                        {{ \App\Models\PlanPricing::decodePlanText($row->plan_description) }}</p>

                                    <ul class="plan-benefits">
                                        @foreach ($benefits as $b)
                                            <li>
                                                <span class="tick">✓</span>
                                                {{ $b }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    {{-- <ul class="plan-benefits">
                                    @foreach ($benefits as $b)

                                        @php
                                            $parts = explode('|',$b);
                                            $name = $parts[0] ?? '';
                                            $status = $parts[1] ?? 1;
                                        @endphp

                                        <li>
                                            @if ($status == 1)
                                                <span class="tick company">✓</span>
                                            @else
                                                <span class="tick cross bg-danger">✕</span>
                                            @endif

                                            {{ trim($name) }}   
                                        </li>

                                    @endforeach
                                </ul> --}}


                                    <div class="pricing-footer">
                                        <button class="choose-btnn buy-btn" data-id="{{ $row->plan_id }}"
                                            data-price="{{ $row->plan_price }}">
                                            Choose Plan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <!-- Company Pricing -->
                <div id="company-pricing" class="pricing-section">
                    <!-- Filter Buttons for Company -->
                    <div class="filter-buttons-container">
                        <!--<button class="filter-btn active" data-filter="all" data-type="company">All</button>-->
                        <button class="filter-btn active" data-filter="job" data-type="company">Job</button>
                        <button class="filter-btn" data-filter="internship" data-type="company">Internship</button>
                    </div>

                    <div class="row d-flex justify-content-center">

                        @foreach ($pricingCompany as $row)
                            @php
                                $benefits = $row->benefits_list;
                                $planService = \App\Models\PlanPricing::normalizeService($row->service ?? null);
                                if ($planService === 'none') {
                                    $planService = 'job';
                                }
                            @endphp

                            <div class="col-xl-4 col-lg-6 col-md-6 pricing-item"
                                data-service="{{ $planService }}">
                                <div class="pricing-card">
                                    @if ((int) $row->plan_price == 4999 || (int) $row->plan_price == 9999)
                                        <div class="badge-offer">
                                            🎁 FREE GIFT
                                        </div>
                                    @endif
                                    @php
                                        // Default old price (optional)
                                        $oldPrice = null;

                                        if ((int) $row->plan_price == 3500) {
                                            $oldPrice = 5999;
                                        } elseif ((int) $row->plan_price == 4999) {
                                            $oldPrice = 7499;
                                        } elseif ((int) $row->plan_price == 9999) {
                                            $oldPrice = 13498;
                                        }
                                    @endphp


                                    <div class="pricing-header company">
                                        <h3 class="text-white">{{ $row->plan_name }}</h3>
                                        {{-- <div class="price-box">
                                        <span class="price">₹{{ (int)$row->plan_price }}</span>
                                        <small>/ {{ $row->plan_time }} {{ $row->plan_duration == 'M' ? 'Months' : ($row->plan_duration == 'Y' ? 'Year':'Day') }}</small>
                                    </div> --}}
                                        <div class="price-box">
                                            @if ($oldPrice)
                                                <span class="old-price">₹{{ $oldPrice }}</span>
                                            @endif

                                            <span class="price">₹ {{ (int) $row->plan_price }}</span>

                                            <small>/ {{ $row->plan_time }}
                                                {{ $row->plan_duration == 'M' ? 'Months' : ($row->plan_duration == 'Y' ? 'Year' : 'Day') }}
                                            </small>
                                        </div>

                                    </div>

                                    <p class="plan-desc">
                                        {{ \App\Models\PlanPricing::decodePlanText($row->plan_description) }}</p>

                                    <ul class="plan-benefits">
                                        @foreach ($benefits as $b)
                                            <li>
                                                <span class="tick company">✓</span>
                                                {{ $b }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    {{-- <ul class="plan-benefits">
                                    @foreach ($benefits as $b)

                                        @php
                                            $parts = explode('|',$b);
                                            $name = $parts[0] ?? '';
                                            $status = $parts[1] ?? 1;
                                        @endphp

                                        <li>
                                            @if ($status == 1)
                                                <span class="tick company">✓</span>
                                            @else
                                                <span class="tick cross bg-danger">✕</span>
                                            @endif

                                            {{ trim($name) }}   
                                        </li>

                                    @endforeach
                                </ul> --}}


                                    <div class="pricing-footer">
                                        <button class="choose-btn buy-btn-company" data-id="{{ $row->plan_id }}"
                                            data-price="{{ $row->plan_price }}">
                                            Choose Plan
                                        </button>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection


{{-- ==================== CSS ==================== --}}
<style>
    /* .badge-offer {
    position: absolute;
    top: 15px;
    left: -35px;
    background: #22285d;
    color: white;
    font-size: 12px;
    font-weight: 800;
    padding: 6px 40px;
    transform: rotate(-45deg);
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    text-transform: uppercase;
    z-index: 10;
} */
    .badge-offer {
        position: absolute;
        top: 25px;
        right: -35px;
        background: #22285d;
        color: white;
        font-size: 12px;
        font-weight: 800;
        padding: 6px 40px;
        transform: rotate(45deg);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        text-transform: uppercase;
        z-index: 10;
    }

    .old-price {
        font-size: 16px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: line-through;
        margin-right: 8px;
    }

    /* Toggle */
    .pricing-toggle-container {
        background: #f8f9fa;
        padding: 5px;
        border-radius: 50px;
        display: inline-block;
    }

    .toggle-switch {
        display: flex;
        position: relative;
    }

    .toggle-switch input {
        display: none;
    }

    .toggle-label {
        padding: 12px 30px;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        color: #666;
        z-index: 2;
        font-size: 13px;
    }

    .toggle-slider {
        position: absolute;
        top: 5px;
        left: 5px;
        width: calc(50% - 5px);
        height: calc(100% - 10px);
        border-radius: 50px;
        background: linear-gradient(135deg, #242b62, #1a1f4d);
        transition: all .3s;
    }

    #company-toggle:checked~.toggle-slider {
        transform: translateX(100%);
    }

    #employee-toggle:checked+.toggle-label,
    #company-toggle:checked+.toggle-label {
        color: white;
    }

    /* Card */
    .pricing-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 0;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }

    /* Header */
    .pricing-header {
        padding: 20px;
        text-align: center;
        color: white;
    }

    .pricing-header.employee {
        background: linear-gradient(135deg, #242b62, #1a1f4d);
    }

    .pricing-header.company {
        background: linear-gradient(135deg, #f36825, #e55a1a);
    }

    .pricing-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .price-box {
        margin-top: 8px;
    }

    .price {
        font-size: 32px;
        font-weight: 800;
    }

    .price-box small {
        font-size: 13px;
        opacity: .8;
    }

    /* Description */
    .plan-desc {
        text-align: center;
        padding: 12px 20px;
        font-size: 14px;
        color: #555;
        border-bottom: 1px solid #eee;
    }

    /* Benefits */
    .plan-benefits {
        list-style: none;
        padding: 15px 20px;
        margin: 0;
        flex: 1;
        /* auto height */
    }

    .plan-benefits li {
        display: flex;
        align-items: flex-start;
        font-size: 14px;
        padding: 6px 0;
        color: #444;
        align-items: center;
    }

    .tick {
        background: #242b62;
        color: #fff;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        font-size: 10px;
        margin-right: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tick.company {
        background: #f36825;
    }

    /* Footer */
    .pricing-footer {
        padding: 15px;
        border-top: 1px solid #eee;
        margin-top: auto;
    }

    .choose-btnn {
        width: 100%;
        background: linear-gradient(135deg, #242b62, #1a1f4d);
        color: white;
        border: none;
        padding: 12px 18px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: .3s;
    }

    .choose-btnn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
    }

    .choose-btn {
        width: 100%;
        background: linear-gradient(135deg, #f36825, #e55a1a);
        color: white;
        border: none;
        padding: 12px 18px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: .3s;
    }

    .choose-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
    }


    /* Section toggle */
    .pricing-section {
        display: none;
    }

    .pricing-section.active {
        display: block;
    }

    /* Filter Buttons */
    .filter-buttons-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 25px;
        margin-top: -10px;
        background: #f8f9fa;
        padding: 5px;
        border-radius: 50px;
        display: inline-flex;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        position: relative;
        left: 50%;
        transform: translateX(-50%);
    }

    .filter-btn {
        padding: 8px 24px;
        border: none;
        background: transparent;
        color: #666;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        outline: none;
        position: relative;
        z-index: 2;
        min-width: 85px;
        text-align: center;
    }

    .filter-btn:hover {
        color: #242b62;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #242b62, #1a1f4d);
        color: white;
        box-shadow: 0 2px 8px rgba(36, 43, 98, 0.25);
    }

    .pricing-item {
        transition: all 0.3s ease;
    }

    .pricing-item.hidden {
        display: none !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .filter-buttons-container {
            flex-direction: column;
            width: 90%;
            padding: 5px;
            margin-top: 0;
        }

        .filter-btn {
            width: 100%;
            margin: 2px 0;
            padding: 8px 20px;
            min-width: auto;
        }
    }
</style>

{{-- ==================== SCRIPT ==================== --}}
@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let employee = document.getElementById('employee-toggle');
            let company = document.getElementById('company-toggle');

            employee.addEventListener('change', () => {
                $("#employee-pricing").addClass('active');
                $("#company-pricing").removeClass('active');
                applyPricingFilter('employee', 'all');
            });

            company.addEventListener('change', () => {
                $("#company-pricing").addClass('active');
                $("#employee-pricing").removeClass('active');
                applyPricingFilter('company', getActiveFilter('company'));
            });

            function normalizeService(service) {
                service = (service || '').toString().toLowerCase().trim();
                if (service === 'opportunity') service = 'internship';
                if (!service || service === 'none') service = 'job';
                return service;
            }

            function getActiveFilter(type) {
                const activeBtn = $(`.filter-btn[data-type="${type}"].active`);
                return activeBtn.length ? activeBtn.data('filter') : 'job';
            }

            function applyPricingFilter(type, filter) {
                filter = (filter || 'job').toString().toLowerCase();
                const pricingSection = type === 'employee' ? '#employee-pricing' : '#company-pricing';

                $(`.filter-btn[data-type="${type}"]`).removeClass('active');
                $(`.filter-btn[data-type="${type}"][data-filter="${filter}"]`).addClass('active');

                $(pricingSection).find('.pricing-item').each(function() {
                    const service = normalizeService($(this).attr('data-service'));
                    const show = filter === 'all' || service === 'all' || service === filter;
                    $(this).toggleClass('hidden', !show);
                });
            }

            // Filter button functionality
            $('.filter-btn').on('click', function() {
                const filter = $(this).data('filter');
                const type = $(this).data('type');
                applyPricingFilter(type, filter);
            });

            // Employee Job/Internship filters are hidden for now, so show every employee plan.
            applyPricingFilter('employee', 'all');
            applyPricingFilter('company', 'job');
        });

        $(".buy-btn").click(function() {
            window.location.href = "{{ route('login') }}";
        });
        $(".buy-btn-company").click(function() {
            window.location.href = "{{ route('login') }}";
        });
    </script>
@endpush
