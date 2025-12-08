<?php
    require_once("includes/fetchDomain.php");
$is_getId = false;
//get method of ID
if (isset($_GET["type"]) && isset($_GET["text"])) {
    
    //api path. $domain being the root folder where files exist
    
    $apiPath = $domain . "backend/api/users/get_user.php?";

    switch ($_GET["type"]) {
        case 'val1':
            $apiPath = $apiPath. "user_id=a";
            break;
        case 'id':
            $getId = $_GET["text"];
            if ($getId === "kaikki" || $getId === "all") {
                $getId = "a";
            }
            $apiPath = $apiPath. "user_id=".$getId;
            break;
        case 'name':
            $getId = $_GET["text"];
            $apiPath = $apiPath. "firstname_id=".$getId;
            break;
        case 'lastname':
            $getId = $_GET["text"];
            $apiPath = $apiPath. "lastname_id=".$getId;
            break;
        case 'email':
            $getId = $_GET["text"];
            $apiPath = $apiPath. "email_id=".$getId;
            break;
        case 'phoneNum':
            $getId = $_GET["text"];
            if (!is_numeric($_GET["text"])) {
                header("location: users.php");
                exit;
            }
            $apiPath = $apiPath. "phone_id=".$getId;
            break;
        default:
            header("location: users.php");
            exit;
            break;
    }
    //fetches content of api

    $is_getId = true;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $apiPath);

    $result = curl_exec($ch);
    curl_close($ch);

    // Decode JSON to associative array
    $data = json_decode($result, true);

    // Check if decoding worked
    if (!$data) {
        echo "Invalid JSON or empty response";
        exit;
    }
} else {
    $apiPath = $domain . "backend/api/users/get_user.php?";
    //fetches content of api
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $apiPath);

    $result = curl_exec($ch);
    curl_close($ch);

    // Decode JSON to associative array
    $data = json_decode($result, true);

    // Check if decoding worked
    if (!$data) {
        echo "Invalid JSON or empty response";
        exit;
    }
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
            <h1>Hallintapaneeli / Käyttäjät</h1>
            <form method="get">
                <div class="search-nav">
                    <div class="search">
                        <input type="text" name="text" class="textInput" required>
                        <select name="type" class="select-type">
                            <option value="val1">Tyyppi</option>
                            <option value="id">ID</option>
                            <option value="name">Nimi</option>
                            <option value="lastname">Sukunimi</option>
                            <option value="email">Email</option>
                            <option value="phoneNum">PuhNro</option>
                        </select>
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
                        etunimi
                        </p>
                    </div>
                    <div>
                        <p>
                        Sukunimi
                        </p>
                    </div>
                    <div>
                        <p>
                        Email
                        </p>
                    </div>
                    <div>
                        <p>
                        PuhNro
                        </p>
                    </div>
                </div>
                <div id="fetchOutput">
                    <?php
                        foreach ($data as $row):
                    ?>
                    <div class="output-row rowJS" style="padding-inline:5px" id="r<?=$row["userID"]?>">
                        <div>
                            <p id="r<?=$row["userID"]?>-userID">
                                <?=$row["userID"]?>
                            </p>
                        </div>
                        <div>
                            <p id="r<?=$row["userID"]?>-firstname">
                                <?=$row["firstname"]?>
                            </p>
                        </div>
                        <div>
                            <p id="r<?=$row["userID"]?>-lastname">
                                <?=$row["lastname"]?>
                            </p>
                        </div>
                        <div>
                            <p id="r<?=$row["userID"]?>-email">
                                <?=$row["email"]?>
                            </p>
                        </div>
                        <div>
                            <p id="r<?=$row["userID"]?>-puhnro">
                                <?=$row["phone"]?>
                            </p>
                        </div>
                    </div>
                    <?php
                        endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-bg" id="popup" style="display:none">
        <div class="middle-popup col">
            <div class="row space-between">
                <h1>Käyttäjän <span id="rowName"></span> tiedot</h1>
                <button type="button" class="btn-exit" id="btnClose">X</button>
            </div>
            <div class="col">
                <div class="row space-between">
                    <p>userID</p>
                    <p id="userID"></p>
                </div>
                <div class="row space-between">
                    <p>firstname</p>
                    <p id="firstname"></p>
                </div>
                <div class="row space-between">
                    <p>lastname</p>
                    <p id="lastname"></p>
                </div>
                <div class="row space-between">
                    <p>Email</p>
                    <p id="email"></p>
                </div>
                <div class="row space-between">
                    <p>Phone</p>
                    <p id="phone"></p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/users.js"></script>
</body>
</html>