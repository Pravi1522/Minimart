@extends('layouts.adminLayout.app')

@section('content')
<div class="container">
    <div class="card p-4 shadow-sm">
        <h4 class="fw-bold text-primary mb-3">Dashboard Overview</h4>
        <p class="text-muted">A quick summary of system statistics</p>
       <div class="">
        <div class="mb-3">Total Users : {{$data['user_count']}}</div>
        <div class="mb-3">Total Products : {{$data['product_count']}}</div>
        <div class="mb-3">Total Order Count : {{$data['order_count']}}</div>
       </div>
    </div>
</div>
@endsection
