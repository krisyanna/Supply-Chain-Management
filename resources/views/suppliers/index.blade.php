<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .alert-success{
            background:#d4edda;
            color:#155724;
            padding:12px 18px;
            border-radius:8px;
            margin-bottom:20px;
        }

        .modal{
            display:none;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,.45);
            justify-content:center;
            align-items:center;
            z-index:999;
        }

        .modal-content{
            background:#fff;
            width:450px;
            padding:25px;
            border-radius:10px;
            box-shadow:0 10px 30px rgba(0,0,0,.2);
        }

        .modal-content h2{
            margin-bottom:20px;
        }

        .modal-content input,
        .modal-content select{
            width:100%;
            padding:12px;
            margin-bottom:15px;
            border:1px solid #ddd;
            border-radius:6px;
            box-sizing:border-box;
        }

        .close{
            float:right;
            font-size:26px;
            cursor:pointer;
        }

        .btn-save{
            width:100%;
            background:#2d7a46;
            color:#fff;
            border:none;
            padding:12px;
            border-radius:6px;
            cursor:pointer;
            font-size:15px;
        }

        .btn-save:hover{
            background:#25653a;
        }
    </style>

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
                    <a href="{{ route('suppliers.index') }}">
                        <i class="fa-solid fa-users"></i>
                        Suppliers
                    </a>
                </li>

                <li>
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

    <!-- ================= MAIN ================= -->

    <main class="main-content">

        <header class="top-header">

            <div>
                <h1>Suppliers</h1>
                <p>Manage your supplier directory.</p>
            </div>

            <div class="header-right">

                <div class="search-box">
                    <input
                        type="text"
                        id="searchSupplier"
                        placeholder="Search Supplier...">
                </div>

                <button
                    class="btn-primary"
                    onclick="document.getElementById('supplierModal').style.display='flex'">

                    <i class="fa-solid fa-user-plus"></i>

                    Add Supplier

                </button>

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

                    <i class="fa-solid fa-users"></i>

                </div>

                <div>

                    <h5>Total Suppliers</h5>

                    <h2>{{ $totalSuppliers }}</h2>

                    <p>Registered Suppliers</p>

                </div>

            </div>

            <div class="stat-card">

                <div class="icon green">

                    <i class="fa-solid fa-circle-check"></i>

                </div>

                <div>

                    <h5>Active</h5>

                    <h2>{{ $activeSuppliers }}</h2>

                    <p>Currently Active</p>

                </div>

            </div>

            <div class="stat-card">

                <div class="icon orange">

                    <i class="fa-solid fa-clock"></i>

                </div>

                <div>

                    <h5>Pending</h5>

                    <h2>{{ $pendingSuppliers }}</h2>

                    <p>Awaiting Approval</p>

                </div>

            </div>

        </section>

        <!-- ================= TABLE ================= -->

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

@forelse($suppliers as $supplier)

<tr>

    <td>{{ $supplier->name }}</td>

    <td>{{ $supplier->contact_person }}</td>

    <td>{{ $supplier->email }}</td>

    <td>{{ $supplier->phone_number }}</td>

    <td>

        @if($supplier->status == 'Active')

            <span class="active-status">

                {{ $supplier->status }}

            </span>

        @else

            <span class="pending-status">

                {{ $supplier->status }}

            </span>

        @endif

    </td>

</tr>

@empty

<tr>

    <td colspan="5" class="empty">

        <i class="fa-solid fa-users"
           style="font-size:40px;margin-bottom:15px;"></i>

        <br>

        No Suppliers Found

    </td>

</tr>

@endforelse

</tbody>

</table>

</div>

</main>

</div>

<!-- ================= ADD SUPPLIER MODAL ================= -->

<div id="supplierModal" class="modal">

    <div class="modal-content">

        <span class="close"
              onclick="closeModal()">

            &times;

        </span>

        <h2>Add Supplier</h2>

        <form action="{{ route('suppliers.store') }}" method="POST">

            @csrf

            <input
                type="text"
                name="name"
                placeholder="Supplier Name"
                required>

            <input
                type="text"
                name="contact_person"
                placeholder="Contact Person"
                required>

            <input
                type="email"
                name="email"
                placeholder="Email Address"
                required>

            <input
                type="text"
                name="phone_number"
                placeholder="Phone Number"
                required>

            <select name="status" required>

                <option value="Active">Active</option>

                <option value="Pending">Pending</option>

            </select>

            <button
                type="submit"
                class="btn-save">

                <i class="fa-solid fa-floppy-disk"></i>

                Save Supplier

            </button>

        </form>

    </div>

</div>

<script>

// ================= SEARCH =================

const search = document.getElementById("searchSupplier");

search.addEventListener("keyup", function(){

    let filter = this.value.toUpperCase();

    let rows = document.querySelectorAll("#supplierTable tbody tr");

    rows.forEach(function(row){

        let text = row.innerText.toUpperCase();

        row.style.display = text.includes(filter) ? "" : "none";

    });

});

// ================= MODAL =================

function closeModal(){

    document.getElementById("supplierModal").style.display = "none";

}

window.onclick = function(event){

    let modal = document.getElementById("supplierModal");

    if(event.target == modal){

        modal.style.display = "none";

    }

}

</script>

</body>
</html>