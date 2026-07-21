@extends('layouts.app')

@section('content')
<div class="dashboard-page">

    <!-- Top Navigation -->
    <header class="dashboard-top container">
        <div class="search-box">
            <input type="text" placeholder="Search">
        </div>

        <nav class="dashboard-nav">
            <a href="{{ route('dashboard') }}">HOME</a>
            <a class="active" href="{{ route('forecasting') }}">FORECASTING</a>
            <a href="#">PROCUREMENT</a>
            <a href="#">LOGISTICS</a>
            <a href="#">INVENTORY</a>
            <a href="#">REPORTS</a>
        </nav>
    </header>

    <main class="container dashboard-content">


        <!-- Success Message -->
        @if(session('success'))
            <div class="alert-success-custom">
                {{ session('success') }}
            </div>
        @endif

        <!-- Statistics -->
        <section class="welcome-row welcome-row--stats-only">

            <div class="stat-card">
                <p>Total Sales</p>
                <h3>{{ number_format($sales->sum('quantity')) }}</h3>
                <span>Items Sold</span>
            </div>

            <div class="stat-card">
                <p>Total Revenue</p>
                <h3>₱{{ number_format($sales->sum('revenue'),2) }}</h3>
                <span>Revenue</span>
            </div>

            <div class="stat-card">
                <p>Products</p>
                <h3>{{ $products->count() }}</h3>
                <span>Available Products</span>
            </div>

            <div class="stat-card stat-card--highlight">
                <p>Records</p>
                <h3>{{ $sales->total() }}</h3>
                <span>Sales Entries</span>
            </div>

        </section>

        <!-- Add Sale -->
        <section class="card standalone-card">

            <h3>Add Sales Record</h3>

            <form action="{{ route('sales.store') }}" method="POST" class="sales-form">

                @csrf

                <div class="form-group">

                    <label>Product</label>

                    <select name="product_id" required>

                        <option value="">Select Product</option>

                        @foreach($products as $product)

                            <option value="{{ $product->id }}">
                                {{ $product->name }}
                                (₱{{ number_format($product->unit_price,2) }})
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="form-group">

                    <label>Quantity Sold</label>

                    <input
                        type="number"
                        name="quantity"
                        min="1"
                        required>

                </div>

                <div class="form-group">

                    <label>Date Sold</label>

                    <input
                        type="date"
                        name="sold_at"
                        required>

                </div>

                <button type="submit" class="save-btn">
                    Add Sale
                </button>

            </form>

        </section>

        <!-- Sales Table -->
        <section class="card standalone-card">

            <h3>Sales History</h3>

            <table>

                <thead>

                    <tr>

                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Revenue</th>
                        <th>Date Sold</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($sales as $sale)

                    <tr>

                        <td>{{ $sale->product->name }}</td>

                        <td>{{ $sale->quantity }}</td>

                        <td class="success">
                            ₱{{ number_format($sale->revenue,2) }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($sale->sold_at)->format('M d, Y') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" style="text-align:center;">
                            No sales records found.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

            <div class="pagination-box">
                {{ $sales->links() }}
            </div>

        </section>

    </main>

</div>
@endsection

@push('styles')
<style>

.forecast-demand-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:18px;
}

.forecast-demand-header h2{
    margin:0;
    font-size:28px;
    font-weight:800;
    color:#0b1f3a;
}

.toggle-pills{
    display:flex;
    gap:12px;
    margin-bottom:24px;
}

.pill{
    display:inline-block;
    padding:9px 22px;
    border-radius:999px;
    border:1px solid #d7ddd8;
    background:white;
    color:#0b3d20;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
}

.pill--active{
    background:#0b3d20;
    color:white;
}

.welcome-row--stats-only{
    grid-template-columns:repeat(4,1fr);
}

.standalone-card{
    margin-top:24px;
}

.sales-form{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    align-items:end;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    margin-bottom:8px;
    font-weight:600;
    color:#374151;
}

.form-group input,
.form-group select{
    padding:12px;
    border:1px solid #d9dfda;
    border-radius:10px;
    font-size:14px;
    background:white;
}

.save-btn{
    background:#0b3d20;
    color:white;
    border:none;
    border-radius:10px;
    padding:12px 26px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.save-btn:hover{
    background:#14532d;
}

.success{
    color:#16a34a;
    font-weight:600;
}

.pagination-box{
    margin-top:20px;
}

.alert-success-custom{
    background:#dcfce7;
    color:#166534;
    border-left:5px solid #22c55e;
    padding:14px 18px;
    border-radius:10px;
    margin-bottom:20px;
}

.dashboard-content > section + section{
    margin-top:24px;
}

@media(max-width:992px){

.sales-form{
    grid-template-columns:1fr;
}

.welcome-row--stats-only{
    grid-template-columns:repeat(2,1fr);
}

}

@media(max-width:600px){

.welcome-row--stats-only{
    grid-template-columns:1fr;
}

}

</style>
@endpush