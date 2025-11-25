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
                <div id="fetchOutput">

                </div>
                <div class="output-row rowJS" style="padding-inline:5px" id="r1">
                    <div>
                        <p id="r1-reservationID">
                        1
                        </p>
                    </div>
                    <div>
                        <p id="r1-userID">
                        1
                        </p>
                    </div>
                    <div>
                        <p id="r1-reservationDate">
                            25-11-2025
                        </p>
                    </div>
                    <div>
                        <p id="r1-subtotal">
                            11
                        </p>
                    </div>
                    <div>
                        <p id="r1-reservationState">
                            paid
                        </p>
                    </div>
                    <div>
                        <p id="r1-paymentState">
                            Paid
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-div" id="popupBg" style="display:none;">
        <div class="middle-popup" id="popup">
            <div class="row space-between" style="background-color:#2b2b2b">
                <h1 id="popupHeader">Tilaus 1</h1>
                <button id="btnClose" class="btn-exit">X</button>
            </div>
            <div class="col" id="popupContent">
            </div>
        </div>
    </div>

    <script>

        window.onload = function() {
            console.log("page laoded");
        };

        const btnClose = document.getElementById("btnClose");
        const popup = document.getElementById("popup");
        const popupBg = document.getElementById("popupBg");

        const popupHeader = document.getElementById("popupHeader");

        //close function
        btnClose.addEventListener("click", function() {
            popupBg.style.display = "none";
        });
        //add onclick to each row, so they can be clicked
        document.querySelectorAll('.rowJS').forEach(row => {
            row.addEventListener('click', function (e) {

                const rowId = row.id;
                
                fetchOrdersPopup(rowId.substring(1));

                popupHeader.textContent = "Tiedot riviltä: " + rowId;
                popupBg.style.display = "block";

            });
        });
    </script>
    <script src="assets/js/fetchOrdersPopup.js"></script>
</body>
</html>