<?php
// Varmistetaan, että sessio on käynnissä, jotta voimme käyttää sessiomuuttujia.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="row space-between top-nav">
    <div class="row nav-align">
        <a href="index.php" class="nav-link"><h1>Ruoka</h1></a>
        <a href="items.php" class="nav-products"><h2>Tuotteet</h2></a>
    </div>
    <div class="row nav-align">
        <?php if (isset($_SESSION['userID']) && isset($_SESSION['firstname'])): ?>
            <!-- Näytetään, kun käyttäjä on kirjautunut sisään -->
             <a href="my_orders.php" class="nav-link">Ostoshistoria</a>
            <span class="nav-greeting">Hei, <?php echo htmlspecialchars($_SESSION['firstname']); ?>!</span>
            <a href="logout.php" class="nav-link" title="Kirjaudu ulos">
                <img src="assets/images/logout.svg" class="nav-icon">
            </a>
            
        <?php else: ?>
            <!-- Näytetään, kun käyttäjä EI ole kirjautunut sisään -->
            <a href="register.php" class="nav-link" title="Rekisteröidy">
                <img src="assets/images/nav-adduser.svg" class="nav-icon">
            </a>
            <a href="login.php" class="nav-link" title="Kirjaudu sisään">
                <img src="assets/images/nav-login.svg" class="nav-icon">
            </a>
        <?php endif; ?>
        <a href="cart.php" class="nav-link link-shopping-cart"><img src="assets/images/nav-shoppingcart.svg" class="nav-icon"></a>
    </div>
</header>