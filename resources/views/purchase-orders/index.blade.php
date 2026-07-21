<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Orders</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="container">

    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">

        <div class="logo">
            <i class="fa-solid fa-desktop"></i>
            <h2>Procurement & Suppliers</h2>
        </div>

        <nav>

            <ul>

                <li>
                    <a href="{{ url('/') }}">
                        <i class="fa-solid fa-house"></i>
                        Home
                    </a>
                </li>

                <li>
                    <a href="{{ url('/dashboard') }}">
                        <i class="fa-solid fa-table-cells-large"></i>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ url('/suppliers') }}">
                        <i class="fa-solid fa-users"></i>
                        Suppliers
                    </a>
                </li>

                <li class="active">
                    <a href="{{ route('purchase-orders.index') }}">
                        <i class="fa-solid fa-file-invoice"></i>
                        Purchase Orders
                    </a>
                </li>

                <li>
                    <a href="{{ route('purchase-orders.create') }}">
                        <i class="fa-solid fa-plus"></i>
                        Create Purchase Order
                    </a>
                </li>

            </ul>

        </nav>

    </aside>

    <!-- ================= MAIN CONTENT ================= -->

    <main class="main-content">

        <header class="top-header">

            <div>

                <h1>Purchase Orders</h1>

                <p>Manage all procurement purchase orders.</p>

            </div>

            <div class="header-right">

                <div class="search-box">

                    <input
                        type="text"
                        id="searchOrder"
                        placeholder="Search Purchase Order...">

                </div>

                <a href="{{ route('purchase-orders.create') }}"
                   class="btn-primary">

                    <i class="fa-solid fa-plus"></i>

                    Create Order

                </a>

            </div>

        </header>

        @if(session('success'))

            <div class="alert-success">

                {{ session('success') }}

            </div>

        @endif

        <!-- ================= SUMMARY ================= -->

        <section class="stats">

            <div class="stat-card">

                <div class="icon purple">

                    <i class="fa-solid fa-file-invoice"></i>

                </div>

                <div>

                    <h5>Total Orders</h5>

                    <h2>{{ $totalOrders }}</h2>

                    <p>Purchase Orders</p>

                </div>

            </div>

            <div class="stat-card">

                <div class="icon green">

                    <i class="fa-solid fa-circle-check"></i>

                </div>

                <div>

                    <h5>Completed</h5>

                    <h2>{{ $completedOrders }}</h2>

                    <p>Completed Orders</p>

                </div>

            </div>

            <div class="stat-card">

                <div class="icon orange">

                    <i class="fa-solid fa-clock"></i>

                </div>

                <div>

                    <h5>Pending</h5>

                    <h2>{{ $pendingOrders }}</h2>

                    <p>Pending Orders</p>

                </div>

            </div>

        </section>

        <!-- ================= TABLE ================= -->

        <div class="table-card">

            <div class="table-header">

                <h3>

                    <i class="fa-solid fa-file-invoice"></i>

                    Purchase Order List

                </h3>

                <button class="btn-primary">

                    <i class="fa-solid fa-download"></i>

                    Export

                </button>

            </div>

            <div class="table-responsive">

                <table id="orderTable">

                    <thead>

                        <tr>

                            <th>PO Number</th>

                            <th>Supplier</th>

                            <th>Order Date</th>

                            <th>Delivery Date</th>

                            <th>Status</th>

                            <th>Grand Total</th>

                            <th width="170">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($purchaseOrders as $order)

                        <tr>

                            <td>{{ $order->po_number }}</td>

                            <td>{{ optional($order->supplier)->name ?? 'No Supplier' }}</td>

                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>

                            <td>

                                @if($order->delivery_date)

                                    {{ \Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') }}

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                @if($order->status == 'Completed')

                                    <span class="active-status">

                                        Completed

                                    </span>

                                @else

                                    <span class="pending-status">

                                        {{ $order->status ?? 'Pending' }}

                                    </span>

                                @endif

                            </td>

                            <td>

                                ₱{{ number_format($order->grand_total,2) }}

                            </td>

                            <td>
                                    <a href="{{ route('purchase-orders.edit', $order->id) }}"
       class="btn-edit"
       style="background:#3498db;color:#fff;padding:8px 12px;border-radius:5px;text-decoration:none;margin-right:5px;display:inline-block;">

        <i class="fa-solid fa-pen"></i> Edit

    </a>

    <form action="{{ route('purchase-orders.destroy', $order->id) }}"
          method="POST"
          style="display:inline-block;">

        @csrf
        @method('DELETE')

        <button type="submit"
                class="btn-delete"
                style="background:#e74c3c;color:white;border:none;padding:8px 12px;border-radius:5px;cursor:pointer;"
                onclick="return confirm('Are you sure you want to delete this Purchase Order?')">

            <i class="fa-solid fa-trash"></i> Delete

        </button>

    </form>

</td>

</tr>

@empty

<tr>

    <td colspan="7" class="empty">

        <i class="fa-solid fa-box-open"
           style="font-size:40px;margin-bottom:15px;"></i>

        <br>

        No Purchase Orders Found

    </td>

</tr>

@endforelse

</tbody>

</table>

</div>

<!-- ================= PAGINATION ================= -->

<div class="pagination-wrapper">

    {{ $purchaseOrders->links() }}

</div>

</div>

</main>

</div>

<script>

document.getElementById("searchOrder").addEventListener("keyup", function () {

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll("#orderTable tbody tr");

    rows.forEach(function(row){

        let text = row.innerText.toLowerCase();

        row.style.display = text.includes(value) ? "" : "none";

    });

});

</script>
                          </body>
</html>