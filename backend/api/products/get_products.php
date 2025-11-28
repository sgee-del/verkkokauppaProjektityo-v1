<?php
header("Content-Type: application/json");

require_once "../../config/db_connect.php";

$pdo = getDBConnection();

// Tehdän SQL-kysely, joka hakee kaikki kategoriat ja tueotteet kerralla
// SELECT valitsee kaikki tarvittavat tiedot.
// LEFT JOIN yhdistää categories taulut p ja c ja pi yhdistää productimage taulun t uotteeeseen ID:n mukaan
// Järjestetään kategorianmukaan sitten tuottee nnimen muakan aakkosjärjestyksessä
$stmt = $pdo->query("
    SELECT 
        c.categoryID,
        c.categoryName,
        p.productID,
        p.name AS productName,
        p.price,
        pi.imagePath,
        p.stock
    FROM categories c
    LEFT JOIN products p ON p.categoryID = c.categoryID
    LEFT JOIN product_images pi ON p.productID = pi.productID
    ORDER BY c.categoryName, p.name;
");

// Haetaan kaikki kyselyn palauttamat rivit ja tallennetaan ne `$rows`-muuttujaan.
$rows = $stmt->fetchAll();

// Alustetaan tyhjä taulukko mihin tallennetaan tietokannasta asaadut kategorian tiedot
$categories = [];

// Käydään läpi jokainen tietokannasta saatu rivi
foreach ($rows as $row) {

    // Otetaan talteen nykyisen rivin kategorian ID.
    $catId = $row['categoryID'];

    // Tarkistetaan, onko tätä kategoriaa jo lisätty $categories-taulukkoon.
    if (!isset($categories[$catId])) {
        // Jos kategoriaa ei vielä ole, luodaan sille uusi alitaulukko.
        // Tähän tallennetaan kategorian tiedot ja alustetaan tyhjä products-taulukko tuotteita varten.
        $categories[$catId] = [
            'categoryID' => $row['categoryID'],
            'categoryName' => $row['categoryName'],
            'products' => []
        ];
    }
    
    // Tarkistetaan, onko rivillä tuotetietoja ettei left join  palauta tyhjää riviä 
    if ($row['productID']) {
        // Jos tuotetietoja on, lisätään tuote oikean kategorian 'products'-taulukkoon.
        $categories[$catId]['products'][] = [
            'productID' => $row['productID'],
            'name' => $row['productName'],
            'price' => $row['price'],
            'stock' => $row['stock'],
            'imagePath' => $row['imagePath'] // Kuvapolku tulee suoraan tietokannasta.
        ];
    }
}

// Lähettää vastauksen json muodossa
echo json_encode([
    "success" => true,
    "categories" => array_values($categories)
]);
?>
