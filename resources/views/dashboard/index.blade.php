<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procurement Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="container"> 

 
    <!-- SIDEBAR -->
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

                <li class="active">
                    <a href="{{ route('dashboard') }}">
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

                <li>
                    <a href="{{ url('/purchase-orders') }}">
                        <i class="fa-solid fa-file-invoice"></i>
                        Purchase Orders
                    </a>
                </li>

                <li>
                    <a href="{{ url('/purchase-orders/create') }}">
                        <i class="fa-solid fa-plus"></i>
                        Create Purchase Order
                    </a>
                </li>

            </ul>
        </nav>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- HEADER -->
        <header class="top-header">

            <div>
                <h1>Welcome back, Admin!</h1>
                <p>
                    Here's what's happening with your procurement
                    and suppliers today.
                </p>
            </div>

            <div class="header-right">

                <div class="search-box">
                    <input
                    type="text"
                    placeholder="Search parts, suppliers, orders...">
                </div>

                <i class="fa-regular fa-bell notification"></i>

            </div>

        </header>

        <!-- STATISTICS -->
        <section class="stats">

            <div class="stat-card">

                <div class="icon purple">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div>
                    <h5>Total Suppliers</h5>
                    <h2>38</h2>
                    <p>Active suppliers</p>
                </div>

            </div>

            <div class="stat-card">

                <div class="icon green">
                    <i class="fa-solid fa-receipt"></i>
                </div>

                <div>
                    <h5>Total Orders</h5>
                    <h2>156</h2>
                    <p>All purchase orders</p>
                </div>

            </div>

            <div class="stat-card">

                <div class="icon blue">
                    <i class="fa-solid fa-truck"></i>
                </div>

                <div>
                    <h5>Pending Orders</h5>
                    <h2>10</h2>
                    <p>Awaiting confirmation</p>
                </div>

            </div>

            <div class="stat-card">

                <div class="icon orange">
                    <i class="fa-solid fa-box"></i>
                </div>

                <div>
                    <h5>Delivered Orders</h5>
                    <h2>100</h2>
                    <p>Successfully delivered</p>
                </div>

            </div>

        </section>

        <!-- TABLES -->
        <section class="tables">

            <!-- SUPPLIER TABLE -->
            <div class="table-card">

                <div class="table-header">
                    <h3>
                        <i class="fa-solid fa-users"></i>
                        Supplier Table
                    </h3>

                    <a href="{{ url('/suppliers') }}" class="action-btn">
                        View All Suppliers
                    </a>
                </div>

                <table>

                    <thead>
                    <tr>
                        <th>Supplier Name</th>
                        <th>Contact Person</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>

                    <tr>
                        <td>Global Components Inc.</td>
                        <td>Jennie Kim</td>
                        <td>jennie@email.com</td>
                        <td><span class="active-status">Active</span></td>
                    </tr>

                    <tr>
                        <td>Global Components Inc.</td>
                        <td>Jennie Kim</td>
                        <td>jennie@email.com</td>
                        <td><span class="active-status">Active</span></td>
                    </tr>

                    <tr>
                        <td>Global Components Inc.</td>
                        <td>Jennie Kim</td>
                        <td>jennie@email.com</td>
                        <td><span class="pending-status">Pending</span></td>
                    </tr>

                    </tbody>

                </table>

            </div>

            <!-- PURCHASE TABLE -->
            <div class="table-card">

                <div class="table-header">
                    <h3>
                        <i class="fa-solid fa-file-invoice"></i>
                        Purchase Orders
                    </h3>

                    <a href="{{ url('/purchase-orders') }}" class="action-btn">
                        View All Orders
                    </a>
                </div>

                <table>

                    <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>

                    <tr>
                        <td>PO-2026-0011</td>
                        <td>Global Components</td>
                        <td>June 1, 2026</td>
                        <td>₱5,000</td>
                        <td><span class="delivered">Delivered</span></td>
                    </tr>

                    <tr>
                        <td>PO-2026-0012</td>
                        <td>Global Components</td>
                        <td>June 29, 2026</td>
                        <td>₱6,000</td>
                        <td><span class="delivered">Delivered</span></td>
                    </tr>

                    <tr>
                        <td>PO-2026-0014</td>
                        <td>Global Components</td>
                        <td>July 1, 2026</td>
                        <td>₱5,000</td>
                        <td><span class="pending-status">Pending</span></td>
                    </tr>

                    </tbody>

                </table>

            </div>

        </section>

        <!-- BOTTOM CARDS -->
        <section class="bottom-section">

            <!-- CHART -->
            <div class="bottom-card">

                <h3>Order Status Overview</h3>

                <div class="chart-box">

                    <div class="circle-chart"></div>

                    <div class="legend">

                        <p>
                            <span class="green-dot"></span>
                            Delivered 85%
                        </p>

                        <p>
                            <span class="yellow-dot"></span>
                            Pending 15%
                        </p>

                    </div>

                </div>

            </div>

            <!-- PRODUCTS -->
            <div class="bottom-card">

                <h3>Popular Computer Parts</h3>

                <ul class="products">

                    <li>ADATA 1TB NVMe SSD</li>
                    <li>ASUS B550M Motherboard</li>
                    <li>AMD Ryzen 5 5600G</li>
                    <li>ADATA 16GB DDR4 RAM</li>

                </ul>

            </div>

            <!-- CREATE PO -->
            <div class="create-po">

    <div class="po-icon">
        <img src="{{ asset('images/create-po.png') }}" alt="">
    </div>

    <h2>Create New<br>Purchase Order</h2>

    <p>
        Add new purchase orders
        for computer parts.
    </p>

    <!-- White Floating Box -->
    <div class="po-button-card">

        <button class="po-btn">

            <span class="plus-icon">
                <i class="bi bi-plus"></i>
            </span>

            <span>Create New PO</span>

        </button>

    </div>

</div>

        </section>

    </main>

</div>

</body>
</html>