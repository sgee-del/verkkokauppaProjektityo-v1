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
        <h2 class="top-margin">Ostoskori</h2>

        <div id="cartArea">Ladataan...</div>
    </div>

    <script>
        // Toast ilmoitus funktio
        function showToast(message, duration = 2000) {
            const toast = document.createElement("div");
            toast.className = "toast-notification";
            toast.innerText = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), duration);
        }

        // ---------------- Hae ostoskori ----------------
        async function loadCart() {
            const res = await fetch("../backend/api/cart/get_cart.php");
            const data = await res.json();

            if (!data.success) {
                document.getElementById("cartArea").innerHTML = `<p>${data.message}</p>`;
                return;
            }

            if (data.items.length === 0) {
                document.getElementById("cartArea").innerHTML = "<p>Ostoskori on tyhjä.</p>";
                return;
            }

            let html = `
        <table class="table">
            <tr>
                <th>Tuote</th>
                <th>Määrä</th>
                <th>Hinta</th>
                <th>Yhteensä</th>
                <th></th>
            </tr>
    `;

            data.items.forEach(item => {
                // luodaan yhdistelmätunniste: cartID_productID
                const cartItemID = `${item.cartID}_${item.productID}`;

                html += `
        <tr>
            <td class="cart-item-details">
                <img src="${item.imagePath}" class="cart-img">
                ${item.name}
            </td>

            <td>
                <button onclick="changeQty('${cartItemID}', ${item.quantity - 1})">-</button>
                <span class="qty">${item.quantity}</span>
                <button onclick="changeQty('${cartItemID}', ${item.quantity + 1})">+</button>
            </td>

            <td>${parseFloat(item.price).toFixed(2)} €</td>
            <td>${parseFloat(item.total).toFixed(2)} €</td>

            <td>
                <button class="remove-btn" onclick="removeItem('${cartItemID}')">Poista</button>
            </td>
        </tr>`;
            });

            html += `
        </table>
        <h3>Kokonaissumma: ${parseFloat(data.total).toFixed(2)} €</h3>
        <a href="checkout.php" class="check-btn">Siirry kassalle</a>
    `;

            document.getElementById("cartArea").innerHTML = html;
        }

        loadCart();


        // ---------------- Muuta määrää ----------------
        async function changeQty(cartItemID, qty) {
            if (qty < 1) return;

            const res = await fetch("../backend/api/cart/update_quantity.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    cartItemID,
                    quantity: qty
                })
            });

            const data = await res.json();
            if (!data.success) {
                alert(data.message || "Muutoksen tallennus epäonnistui.");
                return;
            }

            showToast("Määrä päivitetty ostoskoriin!");
            loadCart(); // Lataa kori ainakun määrää muuttetaan
        }

        // ---------------- Poista tuote ----------------
        async function removeItem(cartItemID) {
            const res = await fetch("../backend/api/cart/remove_item.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    cartItemID
                })
            });

            const data = await res.json();
            if (!data.success) {
                alert(data.message || "Tuotteen poistaminen epäonnistui.");
                return;
            }

            showToast("Tuote poistettu ostoskorista!");
            loadCart(); // Lataa kori aina kun tuote positetaan
        }
    </script>

</body>

</html>