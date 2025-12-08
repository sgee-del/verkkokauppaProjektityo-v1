<?php
header('Content-Type: application/json');
require_once "../../config/db_connect.php";


//-------------------
//search by userID
//-------------------

if (isset($_GET["user_id"])) {

    // Hae käyttäjän ID
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;

    if ($user_id <= 0) {
        echo json_encode(["error" => "user ID is required and cannot be negative"]);
        exit();
    }
    //a fetches all data
    if ($user_id === "a") {
        // SQL-kysely käyttäjille 
        $query = "
            SELECT
            u.userID,
            u.email,
            u.firstname,
            u.lastname,
            u.phone

            FROM users u
            ORDER BY u.userID;
        ";
        // Yhteys ja kyselyn suoritus
        try {
            $conn = getDBConnection();
            $stmt = $conn->prepare($query);
            $stmt->execute();
            
            // Hae kaikki tulokset
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Näytä virhe tai tilaukset
            if (empty($orders)) {
                echo json_encode(["message" => "No users found"]);
            } else {
                // Palauta tilaukset JSON-muodossa
                echo json_encode($orders);
            }
        } catch (PDOException $e) {
            // Virhenkäsittely
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
        }

        // Sulje tietokantayhteys
        $conn = null;

    } else {
        
        // SQL-kysely käyttäjille
        $query = "
            SELECT
            u.userID,
            u.email,
            u.firstname,
            u.lastname,
            u.phone

            FROM users u
            WHERE u.userID = :user_id
            ORDER BY u.userID;
        ";
        // Yhteys ja kyselyn suoritus
        try {
            $conn = getDBConnection();
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Hae kaikki tulokset
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Näytä virhe tai tilaukset
            if (empty($orders)) {
                echo json_encode(["message" => "No users found"]);
            } else {
                // Palauta tilaukset JSON-muodossa
                echo json_encode($orders);
            }
        } catch (PDOException $e) {
            // Virhenkäsittely
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
        }

        // Sulje tietokantayhteys
        $conn = null;
    } 
}
//-------------------
//search by firstname
//-------------------
elseif (isset($_GET["firstname_id"])) {
    $firstname_id = $_GET["firstname_id"];
    
    // SQL-kysely käyttäjille
    $query = "
        SELECT
        u.userID,
        u.email,
        u.firstname,
        u.lastname,
        u.phone

        FROM users u
        WHERE u.firstname = :firstname_id
        ORDER BY u.userID;
    ";
    // Yhteys ja kyselyn suoritus
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':firstname_id', $firstname_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Hae kaikki tulokset
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Näytä virhe tai tilaukset
        if (empty($orders)) {
            echo json_encode(["message" => "No users found"]);
        } else {
            // Palauta tilaukset JSON-muodossa
            echo json_encode($orders);
        }
    } catch (PDOException $e) {
        // Virhenkäsittely
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }

    // Sulje tietokantayhteys
    $conn = null;
}
//-------------------
//search by lastname
//-------------------
elseif (isset($_GET["lastname_id"])) {
    $lastname_id = $_GET["lastname_id"];
    
    // SQL-kysely käyttäjille
    $query = "
        SELECT
        u.userID,
        u.email,
        u.firstname,
        u.lastname,
        u.phone

        FROM users u
        WHERE u.lastname = :lastname_id
        ORDER BY u.userID;
    ";
    // Yhteys ja kyselyn suoritus
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':lastname_id', $lastname_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Hae kaikki tulokset
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Näytä virhe tai tilaukset
        if (empty($orders)) {
            echo json_encode(["message" => "No users found"]);
        } else {
            // Palauta tilaukset JSON-muodossa
            echo json_encode($orders);
        }
    } catch (PDOException $e) {
        // Virhenkäsittely
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }

    // Sulje tietokantayhteys
    $conn = null;
}
//-------------------
//search by email
//-------------------
elseif (isset($_GET["email_id"])) {
    $email_id = $_GET["email_id"];
    
    // SQL-kysely käyttäjille
    $query = "
        SELECT
        u.userID,
        u.email,
        u.firstname,
        u.lastname,
        u.phone

        FROM users u
        WHERE u.email = :email_id
        ORDER BY u.userID;
    ";
    // Yhteys ja kyselyn suoritus
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email_id', $email_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Hae kaikki tulokset
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Näytä virhe tai tilaukset
        if (empty($orders)) {
            echo json_encode(["message" => "No users found"]);
        } else {
            // Palauta tilaukset JSON-muodossa
            echo json_encode($orders);
        }
    } catch (PDOException $e) {
        // Virhenkäsittely
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }

    // Sulje tietokantayhteys
    $conn = null;
}
//-------------------
//search by phone
//-------------------
elseif (isset($_GET["phone_id"])) {
    $phone_id = $_GET["phone_id"];
    
    // SQL-kysely käyttäjille
    $query = "
        SELECT
        u.userID,
        u.email,
        u.firstname,
        u.lastname,
        u.phone

        FROM users u
        WHERE u.phone = :phone_id
        ORDER BY u.userID;
    ";
    // Yhteys ja kyselyn suoritus
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':phone_id', $phone_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Hae kaikki tulokset
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Näytä virhe tai tilaukset
        if (empty($orders)) {
            echo json_encode(["message" => "No users found"]);
        } else {
            // Palauta tilaukset JSON-muodossa
            echo json_encode($orders);
        }
    } catch (PDOException $e) {
        // Virhenkäsittely
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }

    // Sulje tietokantayhteys
    $conn = null;
} else {
    
    // SQL-kysely käyttäjille
    $query = "
        SELECT
        u.userID,
        u.email,
        u.firstname,
        u.lastname,
        u.phone

        FROM users u
        ORDER BY u.userID;
    ";
    // Yhteys ja kyselyn suoritus
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        // Hae kaikki tulokset
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Näytä virhe tai tilaukset
        if (empty($orders)) {
            echo json_encode(["message" => "No users found"]);
        } else {
            // Palauta tilaukset JSON-muodossa
            echo json_encode($orders);
        }
    } catch (PDOException $e) {
        // Virhenkäsittely
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }

    // Sulje tietokantayhteys
    $conn = null;
}
?>
