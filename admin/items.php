<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/assets/css/root.css">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="../admin/assets/css/admin.css">
    <title>Admin</title>
</head>
<body>
    <div class="max-1200">
        <?php
        require_once("includes/admin_nav.php");
        ?>
        <div class="main-content">
            <h1>Hallintapaneeli / Tuotteet</h1>
            <form method="get">
                <div class="search-nav">
                    <div class="search">
                        <select name="type" class="select-type">
                            <option value="val1">Tyyppi</option>
                            <option value="id">ID</option>
                            <option value="item">Tuote</option>
                            <option value="type">Tyyppi</option>
                            <option value="stock">Varasto</option>
                            <option value="added">Lisätty</option>
                        </select>
                        <input type="text" name="text" class="textInput" required>
                    </div>
                    <div class="btn-search">
                        <button type="submit">Hae</button>
                    </div>
                </div>
            </form>
            <div class="output-div">
                <div class="output-headers">
                    <div>
                        <p>
                            id
                        </p>
                    </div>
                    <div>
                        <p>
                            Kuva
                        </p>
                    </div>
                    <div>
                        <p>
                            Tuote
                        </p>
                    </div>
                    <div>
                        <p>
                            Tyyppi
                        </p>
                    </div>
                    <div>
                        <p>
                            Varasto
                        </p>
                    </div>
                    <div>
                        <p>
                            Lisätty
                        </p>
                    </div>
                    <div>
                        <p>
                            Tiedot
                        </p>
                    </div>
                </div>
                <div class="output-row" style="padding-inline:5px">
                    <div>
                        <p>
                        1
                        </p>
                    </div>
                    <div>
                        <img src="../public/assets/images/cart.png" style="height:100%">
                    </div>
                    <div>
                        <p>
                            Coop
                        </p>
                    </div>
                    <div>
                        <p>
                            Säilyke
                        </p>
                    </div>
                    <div>
                        <p>
                            12
                        </p>
                    </div>
                    <div>
                        <p>
                            24-11-2025
                        </p>
                    </div>
                    <div>
                        <a href="">Muokkaa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>