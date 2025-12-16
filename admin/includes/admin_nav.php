
<div class="side-nav">
    <div class="side-nav-top">
        <a href="reservations.php" class="nav-link">
            <div class="side-nav-content">Tilaukset</div>
        </a>
        <a href="items.php" class="nav-link">
            <div class="side-nav-content">Tuotteet</div>
        </a>
        <a href="users.php" class="nav-link">
            <div class="side-nav-content">Käyttäjät</div>
        </a>
    </div>

    <div class="side-nav-bot">
        <?php if (isset($_SESSION['email'])): ?>
            <div class="side-nav-user">
                <?= htmlspecialchars($_SESSION['email']) ?>
            </div>
            <a href="../backend/api/admin/logout.php" class="logout-btn">Kirjaudu ulos</a>
        <?php endif; ?>
    </div>
</div>
