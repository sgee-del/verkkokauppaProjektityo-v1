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

   
</head>

<body>

<div class="checkout-container">
    <h2>Vahvista tilaus</h2>

    <h3>Tuotteet</h3>
    <div id="orderItems">Ladataan...</div>

    <h3 style="margin-top:20px;">Toimitusosoite</h3>
    <input id="street" class="checkout-input" placeholder="Katuosoite">
    <input id="zip" class="checkout-input" placeholder="Postinumero">
    <input id="city" class="checkout-input" placeholder="Kaupunki">

    <button class="check-btn" style="margin-top:15px;" onclick="confirmOrder()">
        Vahvista tilaus
    </button>
</div>

<script>
function toast(msg) {
    const t = document.createElement("div");
    t.className = "toast";
    t.innerText = msg;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 2000);
}

// Hae ostoskori
async function loadCart() {
    const res = await fetch("../backend/api/cart/get_cart.php");
    const data = await res.json();

    const box = document.getElementById("orderItems");

    if (!data.success || data.items.length === 0) {
        box.innerHTML = "<p>Ostoskori on tyhjä.</p>";
        return;
    }

    let html = "";
    data.items.forEach(i => {
        html += `<p>${i.name} x ${i.quantity} — <strong>${i.total.toFixed(2)} €</strong></p>`;
    });

    html += `<h3>Yhteensä: ${data.total.toFixed(2)} €</h3>`;
    box.innerHTML = html;
}

// Hae osoite jos tallennettu TODO ei toimi
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

// Vahvistus
async function confirmOrder() {
    const streetVal = street.value.trim();
    const zipVal = zip.value.trim();
    const cityVal = city.value.trim();

    if (!streetVal || !zipVal || !cityVal) {
        toast("Täytä kaikki osoitekentät");
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
        setTimeout(() => window.location.href = "index.php", 2500);
    }
}
</script>

</body>
</html>
