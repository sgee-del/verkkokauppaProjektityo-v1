<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luokkavaraus järjestelmä</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Favicon-linkit -->
    <link rel="icon" href="../public/assets/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="../public/assets/images/apple-touch-icon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    
<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<header class="site-header">
  
  <!-- Sticky Navbar, ei tarvitse olal sticky riippu sivun rakenteesta -->
    <nav class="navbar">

<!-- Vasen osuus, profiilikuva ja teksti -->
        <div class="nav-left">
            <!-- TODO hae käyttäjän kuva tietokannasta ja aseta placeholderkuva -->
            <?php
            // Käytä sessiossa olevaa profiilikuvan polkua, jos asetettu; muuten placeholder
            $profiilikuva = (isset($_SESSION['Profiilikuva']) && !empty($_SESSION['Profiilikuva']))
                ? $_SESSION['Profiilikuva']
                : "../public/assets/images/profile_placeholder.svg";
            ?>
            <img src="<?php echo htmlspecialchars($profiilikuva); ?>" alt="Kuva" class="profile-pic">
             <!-- Näyttää kirajutuneen käyttäjän nimen ja kuvan vasemmassa kulmassa navbaria-->
            <span class="user-name">Hei, <?php echo isset($_SESSION['Nimi']) ? htmlspecialchars($_SESSION['Nimi']) : 'Käyttäjä'; ?>!</span>
        </div>

        <!-- Hamburger menu pienille näytöille -->
        <button class="hamburger" id="hamburger-menu" aria-label="Avaa valikko" aria-expanded="false">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Oikea osuus, Navbarin itemit -->
        <div class="nav-right">
            <a href="index.php" class="nav-link <?php if ($current_page == 'index.php') echo 'active'; ?>">Luokat</a>
            <a href="reservations.php" class="nav-link <?php if ($current_page == 'reservations.php') echo 'active'; ?>">Varaukseni</a>
            <a href="settings.php" class="nav-link <?php if ($current_page == 'settings.php') echo 'active'; ?>">Asetukset</a>
            <a href="logout.php" class="nav-link log-out">Kirjaudu ulos</a>
        </div>
    </nav>
</header>