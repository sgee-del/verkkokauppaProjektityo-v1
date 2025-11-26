<?php
$is_getId = false;
//get method of ID
if (isset($_GET["type"]) && $_GET["type"] === "id"  && isset($_GET["text"]) && is_numeric($_GET["text"])) {
    //fetches content of api

    //api path
    $apiPath = "../../backend/api/get_orders.php";
    $is_getId = true;
}

?>


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
                    <?php
                    if ($is_getId):
                        
                    ?>
                    <div class="output-row rowJS" style="padding-inline:5px" id="r1">
                        <div>
                            <p id="r1-reservationID">
                            <?=$_GET["text"]?>
                            </p>
                        </div>
                        <div>
                            <p id="r1-reservationDate">
                            ${order.orderDate}
                            </p>
                        </div>
                        <div>
                            <p id="r1-subtotal">
                            ${order.totalPrice}
                            </p>
                        </div>
                        <div>
                            <p id="r1-reservationState">
                            ${order.orderStatus}
                            </p>
                        </div>
                        <div>
                            <p id="r1-paymentState">
                            ${order.paymentStatus}
                            </p>
                        </div>
                    </div>
                    <?php
                    endif
                    ?>
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
                const reservationRowId = rowId + "-reservationID";
                
                fetchOrdersPopup(reservationRowId.textContent);

                popupHeader.textContent = "Tiedot riviltä: " + rowId;
                popupBg.style.display = "block";

            });
        });
    </script>
    <script src="assets/js/fetchOrdersPopup.js"></script>
</body>
</html>