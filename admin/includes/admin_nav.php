<div class="side-nav">
    <div class="side-nav-top">
        <a href="reservations.php">
            <div class="side-nav-content">
                Tilaukset
            </div>
        </a>
        <a href="items.php">
            <div class="side-nav-content">
                Tuotteet
            </div>
        </a>
        <a href="users.php">
            <div class="side-nav-content">
                Käyttäjät
            </div>
        </a>
    </div>
    <div class="side-nav-bot">
        <?php if (isset($_SESSION['email'])):?>
        <div class="side-nav-content">
            <?=$_SESSION['email']?>
        </div>
        <?php endif?>
    </div>
</div>