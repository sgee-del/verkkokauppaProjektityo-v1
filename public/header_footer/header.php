<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lähiruokaa kotiovelle</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Favicon-linkit -->
    <link rel="icon" href="../public/assets/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="../public/assets/images/apple-touch-icon.png">

    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    
<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<header class="site-header">
  
  <!-- Sticky Navbar -->
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
            <a href="logout.php" class="nav-link log-out">Kirjaudu ulos</a>
        </div>
    </nav>
</header>