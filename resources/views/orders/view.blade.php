@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Order History</h2>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Currency</th>
                        <th>Total Price</th>
                        <th>Payment Method</th>
                        <th>Transaction ID</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                        <td>{{ $order->currency_code }}</td>
                        <td>{{ number_format($order->total_price, 2) }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>{{ $order->transaction_id }}</td>
                        <td>
                            <span class="badge 
                                {{ $order->status == 'pending' ? 'bg-warning' : 
                                   ($order->status == 'completed' ? 'bg-success' : 'bg-danger') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Show message if no orders -->
            @if($orders->isEmpty())
                <p class="text-center mt-3">No orders found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
