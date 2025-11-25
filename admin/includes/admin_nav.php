<div class="side-nav">
    <div class="side-nav-top">
        <div class="side-nav-content">
            <a href="reservations.php">Tilaukset</a>
        </div>
        <div class="side-nav-content">
            <a href="items.php">Tuotteet</a>
        </div>
        <div class="side-nav-content">
            <a href="users.php">Käyttäjät</a>
        </div>
    </div>
    <div class="side-nav-bot">
        <?php if (isset($_SESSION['email'])):?>
        <div class="side-nav-content">
            <?=$_SESSION['email']?>
        </div>
        <?php endif?>
    </div>
</div>