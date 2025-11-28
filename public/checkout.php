<?php
session_start();
include "header_footer/header.php";
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Vahvista tilaus</title>

    <link rel="stylesheet" href="assets/css/root.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/cart.css"> 

</head>

<body>

<div class="container">
    <h1 class="page-title">Vahvista tilaus</h1>

    <div class="cart-box">

        <h2 style="margin-bottom:10px;">Tilauksesi tuotteet</h2>
        <div id="orderItems">Ladataan tuotteet...</div>

        <hr style="margin:25px 0; border-color:rgba(255,255,255,0.2)">

        <h2>Toimitusosoite</h2>

        <input id="street" class="checkout-input" placeholder="Katuosoite">
        <input id="zip" class="checkout-input" placeholder="Postinumero">
        <input id="city" class="checkout-input" placeholder="Kaupunki">

        <button class="checkout-btn" onclick="confirmOrder()" style="margin-top:20px;">
            Vahvista tilaus
        </button>
    </div>
</div>

<script>
/* toast */
function toast(message) {
    const t = document.createElement("div");
    t.className = "toast-notification";
    t.innerText = message;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 2000);
}

/* Lataa ostoskori */
async function loadCart() {
    const res = await fetch("../backend/api/cart/get_cart.php");
    const data = await res.json();

    const area = document.getElementById("orderItems");

    if (!data.success || data.items.length === 0) {
        area.innerHTML = "<p>Ostoskori on tyhjä.</p>";
        return;
    }

    let html = "";

    data.items.forEach(item => {
        html += `
            <div class="cart-item">
                <img src="${item.imagePath}" class="item-image">

                <div class="item-info">
                    <div class="item-name">${item.name}</div>
                    <div class="item-price">${(item.total).toFixed(2)} €</div>
                </div>

                <div style="color:white; font-size:16px;">
                    x ${item.quantity}
                </div>
            </div>
        `;
    });

    html += `
        <div class="summary">
            <div class="summary-row total">
                <span>Yhteensä</span>
                <span>${parseFloat(data.total).toFixed(2)} €</span>
            </div>
        </div>
    `;

    area.innerHTML = html;
}

/* hae tallennettu sosoite TODO ei toimi */
async function loadAddress() {
    const res = await fetch("../backend/api/user/get_address.php");
    const data = await res.json();

    if (data.success && data.address) {
        street.value = data.address.street;
        zip.value = data.address.zip;
        city.value = data.address.city;
    }
}

loadCart();
loadAddress();

/* Tilausken vahvistus TODO lisää nappi taaksepäin */
async function confirmOrder() {
    const streetVal = street.value.trim();
    const zipVal = zip.value.trim();
    const cityVal = city.value.trim();

    if (!streetVal || !zipVal || !cityVal) {
        toast("Täytä kaikki osoitetiedot");
        return;
    }

    const res = await fetch("../backend/api/orders/create_order.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            street: streetVal,
            zip: zipVal,
            city: cityVal
        })
    });

    const data = await res.json();
    toast(data.message);

    if (data.success) {
        setTimeout(() => window.location.href = "my_orders.php", 2000);
    }
}
</script>

</body>
</html>
