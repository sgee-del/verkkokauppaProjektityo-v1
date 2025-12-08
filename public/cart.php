<?php
session_start();
include "header_footer/header.php";
?>
<!DOCTYPE html>
<html lang="fi">

<head>
    <meta charset="UTF-8">
    <title>Ostoskori</title>

    <link rel="stylesheet" href="assets/css/root.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/cart.css">
</head>

<body>

<div class="container">
    <h1 class="page-title">Ostoskori</h1>

    <div class="cart-box">
        <div id="cartArea">Ladataan...</div>
    </div>
</div>


<script>

    // toast
    function showToast(message, duration = 2000) {
        const toast = document.createElement("div");
        toast.className = "toast-notification";
        toast.innerText = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), duration);
    }

    // Näytä ostoskori
    async function loadCart() {
        const res = await fetch("../backend/api/cart/get_cart.php");
        const data = await res.json();

        if (!data.success) {
            document.getElementById("cartArea").innerHTML =
                `<p>${data.message}</p>`;
            return;
        }

        if (data.items.length === 0) {
            document.getElementById("cartArea").innerHTML =
                "<p>Ostoskori on tyhjä.</p>";
            return;
        }

        let html = "";

        data.items.forEach(item => {
            const cartItemID = `${item.cartID}_${item.productID}`;

            html += `
            <div class="cart-item">
                <img src="${item.imagePath}" class="item-image">

                <div class="item-info">
                    <div class="item-name">${item.name}</div>
                    <div class="item-price">${parseFloat(item.price).toFixed(2)} €</div>
                </div>

                <div class="quantity-controls">
                    <button onclick="changeQty('${cartItemID}', ${item.quantity - 1})">-</button>
                    <strong>${item.quantity}</strong>
                    <button onclick="changeQty('${cartItemID}', ${item.quantity + 1})">+</button>
                </div>

                <div class="item-price">
                    ${(item.total).toFixed(2)} €
                </div>

                <button class="remove-btn" onclick="removeItem('${cartItemID}')">×</button>
            </div>
            `;
        });

        html += `
            <div class="summary">
                <div class="summary-row total">
                    <span>Kokonaissumma</span>
                    <span>${parseFloat(data.total).toFixed(2)} €</span>
                </div>

                <a href="checkout.php">
                    <button class="checkout-btn">Siirry kassalle</button>
                </a>
            </div>
        `;

        document.getElementById("cartArea").innerHTML = html;
    }

    loadCart(); // Lataa kori


    // MNuuta määrää
    async function changeQty(cartItemID, qty) {
        if (qty < 1) return;

        const res = await fetch("../backend/api/cart/update_quantity.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ cartItemID, quantity: qty })
        });

        const data = await res.json();

        if (!data.success) {
            showToast("Määrän päivittäminen epäonnistui");
            return;
        }

        showToast("Määrä päivitetty!");
        loadCart();
    }

    // poista tuote
    async function removeItem(cartItemID) {
        const res = await fetch("../backend/api/cart/remove_item.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ cartItemID })
        });

        const data = await res.json();

        if (!data.success) {
            showToast("Poistaminen epäonnistui");
            return;
        }

        showToast("Tuote poistettu!");
        loadCart();
    }

</script>
</body>
</html>
