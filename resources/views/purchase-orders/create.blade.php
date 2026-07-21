<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Purchase Order</title>

    <link rel="stylesheet" href="{{ asset('css/purchase-order.css') }}">

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

                <li class="active">
                    <a href="#">
                        <i class="fa-solid fa-circle-plus"></i>
                        Create Purchase Order
                    </a>
                </li>

            </ul>

        </nav>

    </aside>

    <!-- MAIN CONTENT -->

    <main class="main-content">

        <form action="{{ route('purchase-orders.store') }}" method="POST">

            @csrf

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <header class="top-header">

                <div>

                    <h1>Create Purchase Order</h1>

                    <p>Create a new purchase order for computer parts.</p>

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
                            value="{{ $nextPoNumber }}"
                            readonly>

                    </div>

                   <div class="form-group">

    <label>Supplier</label>

    <select name="supplier_id" required>

        <option value="">Select Supplier</option>

        <option value="1">Global Components Inc.</option>
        <option value="2">ABC Electronics</option>
        <option value="3">TechSource Ltd.</option>
        <option value="4">PC Warehouse</option>
        <option value="5">Prime IT Supply</option>
        <option value="6">Metro Computer Parts</option>
        <option value="7">Digital World Trading</option>
        <option value="8">Elite Hardware Solutions</option>
        <option value="9">NextGen Technologies</option>
        <option value="10">Innovative IT Supplies</option>
        <option value="11">MicroTech Distribution</option>
        <option value="12">Vertex Electronics</option>
        <option value="13">CoreTech Systems</option>
        <option value="14">Future PC Solutions</option>
        <option value="15">PowerHouse Computer Supplies</option>
        <option value="16">CyberZone Trading</option>
        <option value="17">Tech Haven</option>
        <option value="18">Smart Computing Inc.</option>
        <option value="19">Infinity Hardware</option>
        <option value="20">Rapid IT Solutions</option>
        <option value="21">BlueChip Electronics</option>
        <option value="22">Pinnacle Computer Store</option>
        <option value="23">Alpha Technology</option>
        <option value="24">Digital Link Systems</option>
        <option value="25">Computer Depot</option>
        <option value="26">Tech Express</option>
        <option value="27">Logic Computer Center</option>
        <option value="28">Precision IT Supplies</option>
        <option value="29">Quantum Electronics</option>
        <option value="30">Supreme Computer Parts</option>
        <option value="31">Vision Tech Trading</option>
        <option value="32">Phoenix Hardware</option>
        <option value="33">Eagle IT Distribution</option>
        <option value="34">United Computer Supplies</option>
        <option value="35">ProTech Electronics</option>
        <option value="36">Apex Computer Solutions</option>
        <option value="37">Titan Hardware Trading</option>
        <option value="38">NovaTech Computer Supplies</option>

    </select>

</div>

                   

                    <div class="form-group">

                        <label>Order Date</label>

                        <input
                            type="date"
                            name="order_date"
                            required>

                    </div>

                    <div class="form-group">

                        <label>Delivery Date</label>

                        <input
                            type="date"
                            name="delivery_date">

                    </div>

                </div>

            </div>

            <!-- ORDER ITEMS -->

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

                        <tr>
                            <td>

    <select
        name="items[0][product_name]"
        class="product"
        onchange="updatePrice(this)"
        required>

        <option value="">Select Computer Part</option>

        <option value="AMD Ryzen 5 5600G" data-price="7899">
            AMD Ryzen 5 5600G - ₱7,899
        </option>

        <option value="AMD Ryzen 7 5700X" data-price="12999">
            AMD Ryzen 7 5700X - ₱12,999
        </option>

        <option value="Intel Core i5-12400F" data-price="9999">
            Intel Core i5-12400F - ₱9,999
        </option>

        <option value="Intel Core i7-12700K" data-price="19999">
            Intel Core i7-12700K - ₱19,999
        </option>

        <option value="ASUS B550M Motherboard" data-price="6499">
            ASUS B550M Motherboard - ₱6,499
        </option>

        <option value="MSI B760M Motherboard" data-price="8999">
            MSI B760M Motherboard - ₱8,999
        </option>

        <option value="ADATA 16GB DDR4 RAM" data-price="2399">
            ADATA 16GB DDR4 RAM - ₱2,399
        </option>

        <option value="Kingston Fury 32GB DDR5" data-price="6999">
            Kingston Fury 32GB DDR5 - ₱6,999
        </option>

        <option value="ADATA 1TB NVMe SSD" data-price="3899">
            ADATA 1TB NVMe SSD - ₱3,899
        </option>

        <option value="Samsung 990 Pro 2TB SSD" data-price="9999">
            Samsung 990 Pro 2TB SSD - ₱9,999
        </option>

        <option value="Seagate 2TB HDD" data-price="3299">
            Seagate 2TB HDD - ₱3,299
        </option>

        <option value="RTX 4060 Graphics Card" data-price="19999">
            RTX 4060 Graphics Card - ₱19,999
        </option>

        <option value="RTX 4070 Super" data-price="38999">
            RTX 4070 Super - ₱38,999
        </option>

        <option value="Corsair 650W PSU" data-price="3299">
            Corsair 650W PSU - ₱3,299
        </option>

        <option value="Cooler Master 750W Gold PSU" data-price="5899">
            Cooler Master 750W Gold PSU - ₱5,899
        </option>

        <option value="DeepCool CPU Cooler" data-price="1499">
            DeepCool CPU Cooler - ₱1,499
        </option>

        <option value="NZXT H5 Flow Case" data-price="4999">
            NZXT H5 Flow Case - ₱4,999
        </option>

        <option value="24-inch Gaming Monitor" data-price="7999">
            24-inch Gaming Monitor - ₱7,999
        </option>

        <option value="Mechanical Keyboard" data-price="2499">
            Mechanical Keyboard - ₱2,499
        </option>

        <option value="Gaming Mouse" data-price="1499">
            Gaming Mouse - ₱1,499
        </option>

    </select>

</td>

<td>

    <input
        class="qty"
        type="number"
        name="items[0][quantity]"
        value="1"
        min="1"
        required>

</td>

<td>

    <input
        class="price"
        type="number"
        name="items[0][price]"
        value="0"
        readonly>

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

</tbody>

</table>

</div>

<!-- GRAND TOTAL -->

<div class="table-card" style="margin-top:30px;">

    <div class="table-header">

        <h3>Grand Total</h3>

        <h2 id="grandTotal">

            ₱0.00

        </h2>

    </div>

</div>

<!-- BUTTONS -->

<div style="display:flex;
            justify-content:flex-end;
            gap:15px;
            margin-top:30px;">

    <button
        type="button"
        class="btn-warning"
        onclick="history.back()">

        Cancel

    </button>

    <button
        type="submit"
        class="btn-primary">

        <i class="fa-solid fa-check"></i>

        Create Purchase Order

    </button>

</div>

</form>

</main>

</div>

<script>

let index = 1;

/* ================= COMPUTER PARTS ================= */

const products = `
<option value="">Select Computer Part</option>

<option value="AMD Ryzen 5 5600G" data-price="7899">AMD Ryzen 5 5600G - ₱7,899</option>
<option value="AMD Ryzen 7 5700X" data-price="12999">AMD Ryzen 7 5700X - ₱12,999</option>
<option value="Intel Core i5-12400F" data-price="9999">Intel Core i5-12400F - ₱9,999</option>
<option value="Intel Core i7-12700K" data-price="19999">Intel Core i7-12700K - ₱19,999</option>

<option value="ASUS B550M Motherboard" data-price="6499">ASUS B550M Motherboard - ₱6,499</option>
<option value="MSI B760M Motherboard" data-price="8999">MSI B760M Motherboard - ₱8,999</option>

<option value="ADATA 16GB DDR4 RAM" data-price="2399">ADATA 16GB DDR4 RAM - ₱2,399</option>
<option value="Kingston Fury 32GB DDR5" data-price="6999">Kingston Fury 32GB DDR5 - ₱6,999</option>

<option value="ADATA 1TB NVMe SSD" data-price="3899">ADATA 1TB NVMe SSD - ₱3,899</option>
<option value="Samsung 990 Pro 2TB SSD" data-price="9999">Samsung 990 Pro 2TB SSD - ₱9,999</option>

<option value="Seagate 2TB HDD" data-price="3299">Seagate 2TB HDD - ₱3,299</option>

<option value="RTX 4060 Graphics Card" data-price="19999">RTX 4060 Graphics Card - ₱19,999</option>
<option value="RTX 4070 Super" data-price="38999">RTX 4070 Super - ₱38,999</option>

<option value="Corsair 650W PSU" data-price="3299">Corsair 650W PSU - ₱3,299</option>
<option value="Cooler Master 750W Gold PSU" data-price="5899">Cooler Master 750W Gold PSU - ₱5,899</option>

<option value="DeepCool CPU Cooler" data-price="1499">DeepCool CPU Cooler - ₱1,499</option>

<option value="NZXT H5 Flow Case" data-price="4999">NZXT H5 Flow Case - ₱4,999</option>

<option value="24-inch Gaming Monitor" data-price="7999">24-inch Gaming Monitor - ₱7,999</option>

<option value="Mechanical Keyboard" data-price="2499">Mechanical Keyboard - ₱2,499</option>

<option value="Gaming Mouse" data-price="1499">Gaming Mouse - ₱1,499</option>
`;

/* ================= PRICE ================= */

function updatePrice(select){

    let option = select.options[select.selectedIndex];

    let price = option.dataset.price || 0;

    let row = select.closest("tr");

    row.querySelector(".price").value = price;

    calculate();

}

/* ================= ADD ROW ================= */

function addRow(){

    let row = `
<tr>

<td>

<select
name="items[${index}][product_name]"
class="product"
required
onchange="updatePrice(this)">

${products}

</select>

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
readonly>

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

}

/* ================= REMOVE ================= */

function removeRow(btn){

    if(document.querySelectorAll("#itemsTable tbody tr").length==1){

        alert("At least one item is required.");

        return;

    }

    btn.closest("tr").remove();

    calculate();

}

/* ================= EVENTS ================= */

function attachEvents(){

    document.querySelectorAll(".qty").forEach(function(input){

        input.oninput = calculate;

    });

}

/* ================= TOTAL ================= */

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

/* ================= START ================= */

attachEvents();

calculate();

</script>

</body>
</html>