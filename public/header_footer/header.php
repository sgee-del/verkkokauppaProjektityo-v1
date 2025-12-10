<?php
// Varmistetaan, että sessio on käynnissä, jotta voimme käyttää sessiomuuttujia.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="row space-between top-nav">
    <div class="row nav-align">
        <button class="mob-show mob-nav-btn" id="btnNav">=</button>
        <a href="index.php" class="nav-link mob-hidden"><h1>Ruoka</h1></a>
        <a href="items.php" class="nav-products mob-hidden"><h2>Tuotteet</h2></a>
    </div>
    <div class="row nav-align">
        <?php if (isset($_SESSION['userID']) && isset($_SESSION['firstname'])): ?>
            <!-- Näytetään, kun käyttäjä on kirjautunut sisään -->
             <a href="my_orders.php" class="nav-link mob-hidden">Ostoshistoria</a>
            <span class="nav-greeting mob-hidden">Hei, <?php echo htmlspecialchars($_SESSION['firstname']); ?>!</span>
            <a href="logout.php" class="nav-link mob-hidden" title="Kirjaudu ulos">
                <img src="assets/images/logout.svg" class="nav-icon">
            </a>
            
        <?php else: ?>
            <!-- Näytetään, kun käyttäjä EI ole kirjautunut sisään -->
            <a href="register.php" class="nav-link mob-hidden" title="Rekisteröidy">
                <img src="assets/images/nav-adduser.svg" class="nav-icon">
            </a>
            <a href="login.php" class="nav-link mob-hidden" title="Kirjaudu sisään">
                <img src="assets/images/nav-login.svg" class="nav-icon">
            </a>
        <?php endif; ?>
        <a href="cart.php" class="nav-link link-shopping-cart"><img src="assets/images/nav-shoppingcart.svg" class="nav-icon"></a>
    </div>
</header>
<div class="mob-show" style="display:none;" id="btnNavUi">
    <div class="col navUi">
        <a href="index.php" alt="etusivulle"><p>Etusivu</p></a>
        <a href="items.php" alt="tuotteet"><p>Tuotteet</p></a>
        <a href="login.php" alt="Kirjaudu sisään"><p>Kirjaudu</p></a>
        <a href="register.php" alt="rekisteröidy"><p>Luo tili</p></a>
    </div>
</div>
<script>
    const btnNav = document.getElementById("btnNav");
    const btnNavUi = document.getElementById("btnNavUi");

    //click function to nav open button
    btnNav.addEventListener("click", function() {
        if (btnNavUi.style.display === "none") {
            btnNavUi.style.display = "block";
        } else {
            btnNavUi.style.display = "none";
        }
    })
    //closes mobile nav ui if screen fits the original nav
    window.addEventListener("resize", function() {
        const windowWidth = window.innerWidth;
        if (windowWidth > 600) {
            btnNavUi.style.display = "none";
        }
    });
</script>