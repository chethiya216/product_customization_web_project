<?php

// database connection
$host = 'localhost';
$dbname = 'cms'; 
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

//to add a new design
function addDesign($name, $filePath) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO designs (name, file_path) VALUES (?, ?)");
    return $stmt->execute([$name, $filePath]);
}

//to remove a design and its file
function removeDesign($name) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT file_path FROM designs WHERE name = ?");
    $stmt->execute([$name]);
    $design = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($design) {
        unlink($design['file_path']); // Delete the design image from the server

        $stmt = $pdo->prepare("DELETE FROM designs WHERE name = ?");
        return $stmt->execute([$name]);
    }
    return false;
}

//to define the function to get all colors
function getAllColors() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM colors");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// function to add a new color to the database
function addColor($colorName, $colorHex) {
    global $pdo;

    $stmt = $pdo->prepare("INSERT INTO colors (name, hex) VALUES (?, ?)");

    return $stmt->execute([$colorName, $colorHex]);
}

// function to remove color from the database
function removeColor($colorName) {
    global $pdo; 

    $stmt = $pdo->prepare("DELETE FROM colors WHERE name = ?");
    

    return $stmt->execute([$colorName]);
}

//to fetch all designs from the database
function getUploadedDesigns() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM designs");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
