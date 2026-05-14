<?php
// Auteur: Dion Breur
// Functie: Functies declareren

// Initialisatie
include_once 'config.php';

// Main
// Verbinding maken met de portfolio database server
function connectDb(){
    try{
        // Verbinding maken
        $conn = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DATABASE, USERNAME, PASSWORD);

        // Error modus instellen
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Verbinding teruggeven
        return $conn;
    } catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}
?>