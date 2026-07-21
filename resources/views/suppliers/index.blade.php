<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                        <a href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-table-cells-large"></i>
                        Dashboard
                    </a>
                </li>

                <li class="active">
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

    <!-- ================= MAIN ================= -->

    <main class="main-content">

        <!-- HEADER -->

        <header class="top-header">

            <div>

                <h1>Suppliers</h1>

                <p>
                    Manage your supplier directory.
                </p>

            </div>

            <div class="header-right">

                <div class="search-box">

                    <input
                    type="text"
                    id="searchSupplier"
                    placeholder="Search Supplier...">

                </div>

                <button class="btn-primary">

                    <i class="fa-solid fa-user-plus"></i>

                    Add Supplier

                </button>

            </div>

        </header>

        <!-- SUMMARY -->

        <section class="stats">

            <div class="stat-card">

                <div class="icon purple">

                    <i class="fa-solid fa-users"></i>

                </div>

                <div>

                    <h5>Total Suppliers</h5>

                    <h2>38</h2>

                    <p>Registered Suppliers</p>

                </div>

            </div>

            <div class="stat-card">

                <div class="icon green">

                    <i class="fa-solid fa-circle-check"></i>

                </div>

                <div>

                    <h5>Active</h5>

                    <h2>31</h2>

                    <p>Currently Active</p>

                </div>

            </div>

            <div class="stat-card">

                <div class="icon orange">

                    <i class="fa-solid fa-clock"></i>

                </div>

                <div>

                    <h5>Pending</h5>

                    <h2>7</h2>

                    <p>Awaiting Approval</p>

                </div>

            </div>

        </section>

        <!-- TABLE -->

        <div class="table-card">

            <div class="table-header">

                <h3>

                    <i class="fa-solid fa-users"></i>

                    Supplier List

                </h3>

                <button class="btn-primary">

                    Export

                </button>

            </div>

            <table id="supplierTable">

                <thead>

                <tr>

                    <th>Supplier</th>

                    <th>Contact</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Status</th>


                </tr>

                </thead>

                <tbody>

                <tr>

                    <td>Global Components Inc.</td>

                    <td>Jennie Kim</td>

                    <td>global@email.com</td>

                    <td>09123456789</td>

                    <td><span class="active-status">Active</span></td>


                </tr>

                <tr>

                    <td>ABC Electronics</td>

                    <td>Mark Lee</td>

                    <td>abc@email.com</td>

                    <td>09111111111</td>

                    <td><span class="pending-status">Pending</span></td>


                </tr>

                <tr>

                    <td>TechSource Ltd.</td>

                    <td>Lisa Park</td>

                    <td>tech@email.com</td>

                    <td>09222222222</td>

                    <td><span class="active-status">Active</span></td>

                   

                </tr>

                <tr>

                    <td>PC Warehouse</td>

                    <td>John Cruz</td>

                    <td>warehouse@email.com</td>

                    <td>09333333333</td>

                    <td><span class="active-status">Active</span></td>

                    
                </tr>

                <tr>

                    <td>Prime IT Supply</td>

                    <td>Maria Santos</td>

                    <td>prime@email.com</td>

                    <td>09444444444</td>

                    <td><span class="pending-status">Pending</span></td>

                   

                </tr>

                </tbody>

            </table>

            <!-- PAGINATION -->

            <div class="pagination">

                <button>Previous</button>

                <button class="active-page">1</button>

                <button>2</button>

                <button>3</button>

                <button>4</button>

                <button>5</button>

                <button>Next</button>

            </div>

        </div>

    </main>

</div>

<script>

const search=document.getElementById("searchSupplier");

search.addEventListener("keyup",function(){

let filter=this.value.toUpperCase();

let rows=document.querySelectorAll("#supplierTable tbody tr");

rows.forEach(function(row){

let text=row.innerText.toUpperCase();

row.style.display=text.includes(filter)?"":"none";

});

});





</script>



</div>
</body>
</html>