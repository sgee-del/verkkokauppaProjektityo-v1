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
     <link rel="stylesheet" href="assets/css/footer.css">
</head>

<body>

<div class="container">
    <h2 class="top-margin">Tuotteet</h2>
    <div id="productArea"></div>
</div>

<!-- Toats dilv -->
<div id="toast"></div>

<script>

// hae tuotteet
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
        <div class="category-block">
            <h3 class="category-title">${cat.categoryName}</h3>

            <div class="product-grid">
        `;

        // Näytetään vain 3 ensimmäistä tuotetta
        cat.products.slice(0, 3).forEach(p => {
            html += `
            <div class="product-card">
                <!-- Linkki vie tuotesivulle, jossa näkyy tuote tarkemmin -->
                <a href="item.php?product_id=${p.productID}">
                    <img src="${p.imagePath ? '../' + p.imagePath : 'assets/images/placeholder.png'}"
                         class="product-img"
                         alt="${p.name}">
                </a>
                
                <div class="product-info">
                    <h2>${p.name}</h2>
                    <h4>${parseFloat(p.price).toFixed(2)} €</h4>
                </div>

                <button class="add-btn" onclick="addToCart(${p.productID})">
                    Lisää ostoskoriin
                </button>
            </div>
            `;
        });

        html += `</div></div>`;
    });

    document.getElementById("productArea").innerHTML = html;
}

loadProducts();


// Lisää ostoskoriiin
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

// toast
function showToast(msg) {
    const toast = document.getElementById("toast");
    toast.innerText = msg;
    toast.style.display = "block";

    setTimeout(() => {
        toast.style.display = "none";
    }, 2000);
}

</script>
<?php
 include "header_footer/footer.php";  // Include footer
 ?>
</body>
</html>
