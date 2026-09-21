@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Plan Pricing</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>For</th>
                <th>Benefits</th>
                <th>Duration</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plans as $plan)
            <tr>
                <td>{{ $plan->plan_id }}</td>
                <td>{{ \App\Models\PlanPricing::decodePlanText($plan->plan_name) }}</td>
                <td>{{ $plan->plan_price }}</td>
                <td>{{ \App\Models\PlanPricing::decodePlanText($plan->plan_description) }}</td>
                <td>{{ $plan->plan_for }}</td>
                <td>{{ \App\Models\PlanPricing::decodePlanText($plan->benefits) }}</td>
                <td>{{ $plan->plan_duration }}</td>
                <td>{{ $plan->plan_time }}</td>
                <td>{{ $plan->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <!-- Add edit/delete buttons here -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
