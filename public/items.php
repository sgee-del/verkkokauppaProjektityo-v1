<?php
session_start();
include "header_footer/header.php";
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuotteet</title>

    <link rel="stylesheet" href="assets/css/root.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/items.css">
</head>
<body>

<div class="container">
    <div class="header">
        <h2 class="top-margin">Tuotteet</h2>
    </div>

    <div id="productArea"></div>
</div>

<!-- Toast-ilmoituselementti -->
<div id="toast"></div>


<script>
    
// Haetaan tuotteet API:sta 
async function loadProducts() {
    const res = await fetch("../backend/api/products/get_products.php");
    const data = await res.json();

    
    if (!data.success) {
        document.getElementById("productArea").innerHTML =
            "<p>Virhe tuotteiden lataamisessa.</p>";
        return;
    }

    

    let html = "";

    data.categories.forEach(cat => {
        html += `
        <div class="col">
            <div class="row space-between nav-align">
                <h1 class="top-margin">${cat.categoryName}</h1>
                <a href="categories.php?id=${cat.categoryID}" class="check-btn" style="width:120px">Enemmän</a>
            </div>
            <div class="categoryRow row top-margin">
        `;

        cat.products.forEach(p => {
            html += `
            <div class="col space-between box">
                <div id="row-items">
                    <!-- Tarkistetaan onko kuvaa, jos ei, käytetään placeholder-kuvaa -->
                    <img src="${p.imagePath ? '../' + p.imagePath : 'assets/images/placeholder.png'}" class="product-img" alt="${p.name}">
                    <div class="row space-between nav-align">
                        <h2>${p.name}</h2>
                        <h4>${parseFloat(p.price).toFixed(2)} €</h4>
                    </div>
                </div>
                <div class="row space-between">
                    <button class="check-btn" onclick="addToCart(${p.productID})">Lisää ostoskoriin</button>
                </div>
            </div>`;
        });

        html += `</div></div>`;
    });

    document.getElementById("productArea").innerHTML = html;
}

// Funktio lataa tuotteet sivulle
loadProducts();

// Käytetään AJAXia ja lisätään tuote ostoskoriin api:lla
async function addToCart(productID) {
    const res = await fetch("../backend/api/cart/add_to_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ productID })
    });

    const data = await res.json();

    if (data.success) {
        showToast("Tuote lisätty ostoskoriin!");
    } else {
        showToast(data.message || "Lisääminen epäonnistui.");
    }
}

// toast ilmoitus funktio
function showToast(msg) {
    const toast = document.getElementById("toast");
    toast.innerText = msg;
    toast.style.display = "block";

    setTimeout(() => {
        toast.style.display = "none";
    }, 2000);
}
</script>

</body>
</html>
