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
            <h1>Hallintapaneeli / Tilaukset</h1>
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
                            TilausID
                        </p>
                    </div>
                    <div>
                        <p>
                            TilaajaID
                        </p>
                    </div>
                    <div>
                        <p>
                            TilausPVM
                        </p>
                    </div>
                    <div>
                        <p>
                            Kokonaishinta
                        </p>
                    </div>
                    <div>
                        <p>
                            Tilauksen tila
                        </p>
                    </div>
                    <div>
                        <p>
                            Maksun tila
                        </p>
                    </div>
                </div>
                <div class="output-row rowJS" style="padding-inline:5px" id="row1">
                    <div>
                        <p class="item" data-value="1">
                        1
                        </p>
                    </div>
                    <div>
                        <p>
                        1
                        </p>
                    </div>
                    <div>
                        <p>
                            25-11-2025
                        </p>
                    </div>
                    <div>
                        <p>
                            11
                        </p>
                    </div>
                    <div>
                        <p>
                            paid
                        </p>
                    </div>
                    <div>
                        <p>
                            Paid
                        </p>
                    </div>
                </div>
                <div class="output-row rowJS" style="padding-inline:5px" id="row2">
                    <div>
                        <p>
                        2
                        </p>
                    </div>
                    <div>
                        <p>
                        2
                        </p>
                    </div>
                    <div>
                        <p>
                            25-11-2025
                        </p>
                    </div>
                    <div>
                        <p>
                            15
                        </p>
                    </div>
                    <div>
                        <p>
                            paid
                        </p>
                    </div>
                    <div>
                        <p>
                            Paid
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="middle-popup" id="popup">
        <div class="row space-between" style="background-color:#2b2b2b">
            <h1 id="popupHeader">Tilaus 1</h1>
            <button id="btnClose" class="btn-exit">X</button>
        </div>
        <div>
            <p>
                Tilauksen tiedot
            </p>
        </div>
    </div>

    <script>
        const btnClose = document.getElementById("btnClose");
        const popup = document.getElementById("popup");
        const btnOpen = document.getElementById("btnInfo");

        const popupHeader = document.getElementById("popupHeader");

        //close function
        btnClose.addEventListener("click", function() {
            popup.style.display = "none";
        });
        document.querySelectorAll('.rowJS').forEach(row => {
            row.addEventListener('click', function (e) {
                popup.style.display = "block";
                
            });
            console.log("added eventlistener");
        });
    </script>
</body>
</html>