<!DOCTYPE html>
#DE TORRES 2:50pm
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Purchase Order</title>

    <link rel="stylesheet" href="{{ asset('css/purchase-order.css') }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
                    <a href="{{ url('/dashboard') }}">
                        <i class="fa-solid fa-house"></i>
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

            </ul>

        </nav>

    </aside>

    <!-- MAIN CONTENT -->

    <main class="main-content">

        <form action="{{ route('purchase-orders.update', $purchaseOrder->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            @if ($errors->any())

                <div class="alert-danger">

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <header class="top-header">

                <div>

                    <h1>Edit Purchase Order</h1>

                    <p>Update purchase order information.</p>

                </div>

            </header>

            <!-- ORDER INFORMATION -->

            <div class="table-card">

                <div class="table-header">

                    <h3>Order Information</h3>

                </div>

                <div class="form-grid">

                    <div class="form-group">

                        <label>PO Number</label>

                        <input
                            type="text"
                            name="po_number"
                            value="{{ $purchaseOrder->po_number }}"
                            readonly>

                    </div>

                    <div class="form-group">

                        <label>Supplier</label>

                        <select name="supplier_id" required>

                            @foreach($suppliers as $supplier)

                                <option value="{{ $supplier->id }}"
                                    {{ $purchaseOrder->supplier_id == $supplier->id ? 'selected' : '' }}>

                                    {{ $supplier->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">

                        <label>Order Date</label>

                        <input
                            type="date"
                            name="order_date"
                            value="{{ $purchaseOrder->order_date }}"
                            required>

                    </div>

                    <div class="form-group">

                        <label>Delivery Date</label>

                        <input
                            type="date"
                            name="delivery_date"
                            value="{{ $purchaseOrder->delivery_date }}">

                    </div>

                    <div class="form-group">

                        <label>Status</label>

                        <select name="status">

                            <option value="Pending"
                                {{ $purchaseOrder->status=='Pending'?'selected':'' }}>

                                Pending

                            </option>

                            <option value="Completed"
                                {{ $purchaseOrder->status=='Completed'?'selected':'' }}>

                                Completed

                            </option>

                        </select>

                    </div>

                </div>

            </div>

            <!-- ================= ORDER ITEMS ================= -->

<div class="table-card" style="margin-top:30px;">

    <div class="table-header">

        <h3>Order Items</h3>

        <button
            type="button"
            class="btn-primary"
            onclick="addRow()">

            <i class="fa-solid fa-plus"></i>

            Add Item

        </button>

    </div>

    <table id="itemsTable">

        <thead>

            <tr>

                <th width="35%">Computer Part</th>

                <th width="15%">Quantity</th>

                <th width="20%">Price</th>

                <th width="20%">Total</th>

                <th width="10%">Action</th>

            </tr>

        </thead>

        <tbody>

        @foreach($purchaseOrder->items as $i => $item)

            <tr>

                <td>

                    <input
                        type="text"
                        name="items[{{ $i }}][product_name]"
                        value="{{ $item->product_name }}"
                        required>

                </td>

                <td>

                    <input
                        type="number"
                        class="qty"
                        name="items[{{ $i }}][quantity]"
                        value="{{ $item->quantity }}"
                        min="1"
                        required>

                </td>

                <td>

                    <input
                        type="number"
                        class="price"
                        name="items[{{ $i }}][price]"
                        value="{{ $item->price }}"
                        step="0.01"
                        required>

                </td>

                <td class="total">

                    ₱{{ number_format($item->total,2) }}

                </td>

                <td>

                    <button
                        type="button"
                        class="btn-danger"
                        onclick="removeRow(this)">

                        <i class="fa-solid fa-trash"></i>

                    </button>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

<!-- ================= GRAND TOTAL ================= -->

<div class="table-card" style="margin-top:30px;">

    <div class="table-header">

        <h3>Grand Total</h3>

        <h2 id="grandTotal">

            ₱{{ number_format($purchaseOrder->grand_total,2) }}

        </h2>

    </div>

</div>


<!-- ================= BUTTONS ================= -->

<div style="display:flex;
            justify-content:flex-end;
            gap:15px;
            margin-top:30px;">

    <a href="{{ route('purchase-orders.index') }}"
       class="btn-warning">

        Cancel

    </a>

    <button
        type="submit"
        class="btn-primary">

        <i class="fa-solid fa-floppy-disk"></i>

        Update Purchase Order

    </button>

</div>

</form>

</main>

</div>

<script>

let index = Number('{{ $purchaseOrder->items->count() }}');

function addRow(){

    let row = `
<tr>

<td>

<input
type="text"
name="items[${index}][product_name]"
required>

</td>

<td>

<input
type="number"
class="qty"
name="items[${index}][quantity]"
value="1"
min="1"
required>

</td>

<td>

<input
type="number"
class="price"
name="items[${index}][price]"
value="0"
step="0.01"
required>

</td>

<td class="total">

₱0.00

</td>

<td>

<button
type="button"
class="btn-danger"
onclick="removeRow(this)">

<i class="fa-solid fa-trash"></i>

</button>

</td>

</tr>
`;

    document.querySelector("#itemsTable tbody")
        .insertAdjacentHTML("beforeend", row);

    index++;

    attachEvents();

    calculate();

}

function removeRow(button){

    if(document.querySelectorAll("#itemsTable tbody tr").length == 1){

        alert("At least one item is required.");

        return;

    }

    button.closest("tr").remove();

    calculate();

}

function attachEvents(){

    document.querySelectorAll(".qty").forEach(function(input){

        input.oninput = calculate;

    });

    document.querySelectorAll(".price").forEach(function(input){

        input.oninput = calculate;

    });

}

function calculate(){

    let grand = 0;

    document.querySelectorAll("#itemsTable tbody tr")
        .forEach(function(row){

            let qty = parseFloat(row.querySelector(".qty").value) || 0;

            let price = parseFloat(row.querySelector(".price").value) || 0;

            let total = qty * price;

            row.querySelector(".total").innerHTML =
                "₱" + total.toLocaleString(undefined,{
                    minimumFractionDigits:2,
                    maximumFractionDigits:2
                });

            grand += total;

        });

    document.getElementById("grandTotal").innerHTML =
        "₱" + grand.toLocaleString(undefined,{
            minimumFractionDigits:2,
            maximumFractionDigits:2
        });

}

attachEvents();

calculate();

</script>

</body>
</html>