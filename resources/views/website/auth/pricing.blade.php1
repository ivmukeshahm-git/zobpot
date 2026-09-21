@extends('website.layout.layout')
@section('website-content')
    <main class="main">
        <section class="section-box mt-90">
            <div class="container">
                <h2 class="text-center mb-15 wow animate__animated animate__fadeInUp">Choose The Best Plan That’s For You
                </h2>

                <input type="hidden" name="user_id" id="user_id" value="{{ $user_id ?? '' }}">

                <!-- <div class="font-lg color-text-paragraph-2 text-center wow animate__animated animate__fadeInUp">Choose The Best Plan That&rsquo;s For You</div> -->
                <div class="max-width-price">
                    <div class="block-pricing mt-70">
                        <!-- <div class="row">
                            @foreach ($pricing as $row)
                                <div class="col-xl-4 col-lg-6 col-md-6 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                                    <div class="box-pricing-item" style="border:1px solid">
                                        <h3>{{ $row->plan_name }}</h3>
                                        <div class="box-info-price"><span class="text-price color-brand-2">₹
                                                {{ (int) $row->plan_price }}</span><span class="text-month">/
                                                {{ $row->plan_time }}
                                                {{ $row->plan_duration == 'M' ? 'Month' : ($row->plan_duration == 'Y' ? 'Year' : 'Day') }}</span>
                                        </div>
                                        <div class="border-bottom mb-30">
                                            <p class="text-desc-package font-sm color-text-paragraph mb-30">
                                                {{ $row->plan_description }}</p>
                                        </div>
                                        @php
                                            $benefitsArray = $row->benefits ? explode(',', $row->benefits) : [];
                                        @endphp
                                        <ul class="list-package-feature">
                                            @foreach ($benefitsArray as $benefit)
                                                <li>{{ trim($benefit) }}</li>
                                            @endforeach
                                        </ul>
                                        <div><button class="btn btn-border buy-btn" type="button" data-id="{{$row->plan_id}}"
                                               >Choose plan</button></div>
                                    </div>
                                </div>
                            @endforeach
                        </div> -->
                        @php
                            use Illuminate\Support\Facades\Auth;
                            use Illuminate\Support\Facades\DB;

                            $user = Auth::user();
                            $usedFreePlan = false;

                            if($user){
                                $usedFreePlan = DB::table('tbl_plan_history as h')
                                    ->join('tbl_plan_pricing as p','h.plan_id','=','p.plan_id')
                                    ->where('h.user_id',$user->id)
                                    ->where('p.plan_price',0)
                                    ->exists();
                            }
                        @endphp

                        <div class="row">
                            @foreach ($pricing as $row)
                                @php
                                    $benefitsArray = $row->benefits ? explode(',', $row->benefits) : [];
                                    $totalBenefits = count($benefitsArray);
                                    $showMore = $totalBenefits > 3;
                                @endphp
                                
                                <div class="col-xl-4 col-lg-6 col-md-6 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                                    <div class="box-pricing-item custom-pricing-card p-0" style="background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(36, 43, 98, 0.1); border: 1px solid #e0e0e0; overflow: hidden; transition: all 0.3s ease; height: 100%; position: relative; display: flex; flex-direction: column; min-height: 450px; max-height: 450px;">
                                        @if((int)$row->plan_price == 4999 || (int)$row->plan_price == 9999)
                                            <div class="badge-offer">🎁 FREE GIFT</div>
                                        @endif

                                        
                                        <!-- Header with gradient -->
                                        <div class="custom-pricing-header" style="background: linear-gradient(135deg, #242b62, #1a1f4d); color: white; padding: 20px 15px; text-align: center; position: relative; flex-shrink: 0;">
                                            <h3 class="custom-plan-name" style="font-size: 20px; font-weight: 700; margin-bottom: 10px; color: white; line-height: 1.2;">{{ $row->plan_name }}</h3>
                                            <div class="custom-price-section" style="position: relative;">
                                                @php
                                                    // Static OLD price mapping (ONLY FOR UI)
                                                    $oldPriceMap = [
                                                        3500 => 5999, // plan_price => old price
                                                        4999 => 7499,
                                                        9999 => 13498,
                                                    ];

                                                    $oldPrice = $oldPriceMap[(int)$row->plan_price] ?? null;
                                                @endphp

                                                <div class="custom-discounted-price" style="display: flex; align-items: baseline; justify-content: center; gap: 6px; margin-bottom: 8px; flex-wrap: wrap;">

                                                    @if($oldPrice)
                                                        <span style="font-size:14px; font-weight:600; color:#e0e0e0; text-decoration: line-through;">
                                                            ₹{{ $oldPrice }}
                                                        </span>
                                                    @endif

                                                    <span class="custom-current-price" style="font-size: 32px; font-weight: 800; color: white;">
                                                        ₹ {{ (int) $row->plan_price }}
                                                    </span>

                                                    <span class="custom-duration" style="font-size: 14px; color: #e0e0e0; font-weight: 500;">
                                                        /&nbsp;{{ $row->plan_time }} 
                                                        {{ $row->plan_duration == 'M' ? 'Months' : ($row->plan_duration == 'Y' ? 'Year' : 'Day') }}
                                                    </span>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="custom-plan-description" style="padding: 15px; border-bottom: 1px solid #f0f0f0; flex-shrink: 0;">
                                            <p class="custom-description-text" style="color: #666; text-align: center; margin: 0; font-size: 13px; line-height: 1.4;">{{ $row->plan_description }}</p>
                                        </div>

                                        <!-- Benefits List - Scrollable Container -->
                                        <div class="custom-benefits-container" style="flex: 1; display: flex; flex-direction: column; overflow: hidden;">
                                            <ul class="custom-benefits-list benefits-scroll" style="list-style: none; margin: 0; padding: 15px; flex: 1; overflow-y: auto; max-height: 180px;">
                                                @foreach ($benefitsArray as $benefit)
                                                    <li class="custom-benefit-item" style="display: flex; align-items: flex-start; padding: 8px 0; color: #555; font-size: 13px; line-height: 1.3;">
                                                        <span class="custom-check-icon" style="background: #242b62; color: white; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; margin-right: 10px; flex-shrink: 0; margin-top: 2px;">✓</span>
                                                        <span style="flex: 1;">{{ trim($benefit) }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            {{-- <ul class="custom-benefits-list benefits-scroll" 
                                                style="list-style: none; margin: 0; padding: 15px; flex: 1; overflow-y: auto; max-height: 180px;">

                                                @foreach ($benefitsArray as $benefit)

                                                @php
                                                    $parts = explode('|',$benefit);
                                                    $name = $parts[0] ?? '';
                                                    $status = $parts[1] ?? 1;
                                                @endphp

                                                <li class="custom-benefit-item" 
                                                style="display:flex;align-items:flex-start;padding:8px 0;color:#555;font-size:13px;line-height:1.3;">

                                                    @if($status==1)
                                                        <span class="custom-check-icon" 
                                                        style="background:#242b62;color:white;width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;margin-right:10px;flex-shrink:0;margin-top:2px;">
                                                        ✓
                                                        </span>
                                                    @else
                                                        <span class="custom-check-icon" 
                                                        style="background:#e74c3c;color:white;width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;margin-right:10px;flex-shrink:0;margin-top:2px;">
                                                        ✕
                                                        </span>
                                                    @endif

                                                    <span style="flex:1;">{{ trim($name) }}</span>

                                                </li>
                                                @endforeach

                                                </ul> --}}
                                            
                                        </div>

                                        <!-- Choose Plan Button -->
                                         @if(!((float)$row->plan_price == 0 && $usedFreePlan))

                                        <div class="custom-pricing-footer" style="padding: 15px; flex-shrink: 0;">
                                            <button class="custom-choose-plan-btn buy-btn" data-id="{{ $row->plan_id }}" data-price="{{$row->plan_price}}" style="background: linear-gradient(135deg, #f36825, #e55a1a); color: white; border: none; padding: 12px 20px; border-radius: 6px; font-size: 14px; font-weight: 600; width: 100%; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px;">
                                                Choose Plan
                                            </button>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

<style>
.badge-offer { position: absolute; top: 11px; right: -45px; background: #e95e1d; color: white; font-size: 12px; font-weight: 800; padding: 6px 40px; transform: rotate(45deg); box-shadow: 0 4px 12px rgba(0,0,0,0.25); text-transform: uppercase; z-index: 10; }

/* CARD AUTO HEIGHT */
.custom-pricing-card {
    height: 550px !important;
    min-height: auto !important;
    max-height: none !important;
}

/* BENEFITS FULL SHOW */
.benefits-scroll {
    max-height: none !important;
    overflow: visible !important;
}


.benefits-scroll.expanded {
    max-height: 250px !important;
}

/* Scrollbar Styling */
.benefits-scroll::-webkit-scrollbar {
    width: 4px;
}

.benefits-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.benefits-scroll::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.benefits-scroll::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.custom-pricing-card:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 8px 25px rgba(36, 43, 98, 0.15) !important;
}

.custom-choose-plan-btn:hover {
    background: linear-gradient(135deg, #e55a1a, #d44c0f) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 3px 10px rgba(243, 104, 37, 0.3) !important;
}

.custom-show-more-btn:hover {
    background: #f36825 !important;
    transform: translateY(-1px) !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    /* .custom-pricing-card {
        margin-bottom: 20px !important;
        min-height: 420px !important;
        max-height: 420px !important;
    }
    
    .benefits-scroll {
        max-height: 150px !important;
    } */
    
    /* .benefits-scroll.expanded {
        max-height: 200px !important;
    } */
    
    .custom-current-price {
        font-size: 28px !important;
    }
    
    .custom-plan-name {
        font-size: 18px !important;
    }
}
</style>
@push('script')
{{--    <script>--}}
{{--        function choosePlan(plan_id) {--}}
{{--            let url = "{{ route('choose-plan-action') }}";--}}

{{--            var user_id = $("#user_id").val();--}}
{{--            var data = {--}}
{{--                plan_id: plan_id,--}}
{{--                user_id: user_id--}}
{{--            };--}}


{{--            $.ajaxSetup({--}}
{{--                headers: {--}}
{{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                }--}}
{{--            });--}}

{{--            LoaderShow();--}}

{{--            $.ajax({--}}
{{--                type: "POST",--}}
{{--                url: url,--}}
{{--                data: data,--}}
{{--                success: function(response) {--}}
{{--                    LoaderHide();--}}
{{--                    if (response.status === 1) {--}}
{{--                        setTimeout(function() {--}}
{{--                            window.location.href = "{{ route('home') }}";--}}
{{--                        }, 500);--}}
{{--                    } else {--}}
{{--                        Swal.fire({--}}
{{--                            icon: 'error',--}}
{{--                            title: 'Error!',--}}
{{--                            text: response.message,--}}
{{--                        });--}}
{{--                    }--}}
{{--                },--}}
{{--                error: function(xhr) {--}}
{{--                    LoaderHide();--}}
{{--                    console.log(xhr.responseText);--}}

{{--                    let errorMsg = "Something went wrong";--}}
{{--                    try {--}}
{{--                        const res = JSON.parse(xhr.responseText);--}}
{{--                        errorMsg = res.message || errorMsg;--}}
{{--                    } catch (e) {}--}}

{{--                    console.log(errorMsg)--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}



{{--    </script>--}}

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>

       $(document).on('click', '.buy-btn', function() {

        let planId = $(this).data('id');
        let planPrice = $(this).data('price');
        var user_id = $("#user_id").val();

        if (planPrice > 0) {
            fetch("{{ route('choose-plan-action') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        plan_id: planId,
                        user_id: user_id,
                        flag: "A"
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('data', data);
                    var options = {
                        "key": data.key,
                        "amount": data.amount,
                        "currency": data.currency,
                        "name": "ZobPot",
                        "description": data.plan.name,
                        "order_id": data.order_id,
                        "handler": function(response) {
                            fetch("{{ route('choose-plan-action') }}?flag='B'&&hid=" + data.history_id, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify(response)
                                })
                                .then(res => res.json())
                                .then(msg => {
                                    // console.log(res);
                                    if (msg.status === 'success') {
                                        alert("Payment Successful! Plan Activated ✅");
                                        window.location.href = "{{route('home')}}";
                                    } else {
                                        alert("Payment Failed ❌");
                                    }
                                });
                        },
                        "theme": {
                            "color": "#242a62"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                });
        } else {
            var data = {
                plan_id: planId,
                user_id: user_id,
                flag: "FREE"
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            LoaderShow();

            $.ajax({
                type: "POST",
                url: "{{ route('choose-plan-action') }}",
                data: data,
                success: function(response) {
                    LoaderHide();
                    if (response.status === 1) {
                        setTimeout(function() {
                            window.location.href = "{{ route('home') }}";
                        }, 500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr) {
                    LoaderHide();
                    console.log(xhr.responseText);

                    let errorMsg = "Something went wrong";
                    try {
                        const res = JSON.parse(xhr.responseText);
                        errorMsg = res.message || errorMsg;
                    } catch (e) {}

                    console.log(errorMsg);
                }
            });
        }
    });

        {{--document.querySelectorAll('.buy-btn').forEach(btn => {--}}
        {{--    btn.addEventListener('click', function() {--}}
        {{--        let planId = this.dataset.id;--}}
        {{--        var user_id = $("#user_id").val();--}}
        {{--        fetch("{{ route('choose-plan-action') }}", {--}}
        {{--            method: 'POST',--}}
        {{--            headers: {--}}
        {{--                'Content-Type': 'application/json',--}}
        {{--                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content--}}
        {{--            },--}}
        {{--            body: JSON.stringify({ plan_id: plan_id ,user_id: user_id,flag:"A"})--}}
        {{--        })--}}
        {{--            .then(res => res.json())--}}
        {{--            .then(data => {--}}
        {{--                var options = {--}}
        {{--                    "key": data.key,--}}
        {{--                    "amount": data.amount,--}}
        {{--                    "currency": data.currency,--}}
        {{--                    "name": "My App",--}}
        {{--                    "description": data.plan.name,--}}
        {{--                    "order_id": data.order_id,--}}
        {{--                    "handler": function (response){--}}
        {{--                        fetch("{{ route('choose-plan-action') }}", {--}}
        {{--                            method: 'POST',--}}
        {{--                            headers: {--}}
        {{--                                'Content-Type': 'application/json',--}}
        {{--                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content--}}
        {{--                            },--}}
        {{--                            body: JSON.stringify(response)--}}
        {{--                        })--}}
        {{--                            .then(res => res.json())--}}
        {{--                            .then(msg => {--}}
        {{--                                console.log(msg);--}}
        {{--                                if(msg.status === 'success'){--}}
        {{--                                    alert("Payment Successful! Plan Activated ✅");--}}
        {{--                                    window.location.reload();--}}
        {{--                                } else {--}}
        {{--                                    alert("Payment Failed ❌");--}}
        {{--                                }--}}
        {{--                            });--}}
        {{--                    },--}}
        {{--                    "theme": { "color": "#3399cc" }--}}
        {{--                };--}}
        {{--                var rzp1 = new Razorpay(options);--}}
        {{--                rzp1.open();--}}
        {{--            });--}}
        {{--    });--}}
        {{--});--}}
    </script>
@endpush
