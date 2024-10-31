<?php
require 'db.php';
session_start(); //start de sessie

if (!isset($_SESSION['username'])) { //controleert of de gebruikersnaam in de sessie is ingesteld
    header('Location: login.php');
    exit;
}

$id = (int)$_GET['id']; //de id van de bokser uit de querystring halen



try {
    $query = ("DELETE FROM boxers WHERE id = ?"); //query aangemaakt
    $stmt = $conn->prepare($query); //prepared query
    $stmt->bind_param("i", $id); //paramater word gebind

    if ($stmt->execute()) { //statement word ge execute
        echo "Bokser succesvol verwijderd!";
    } else {
        echo "Fout: " . $stmt->error; //je krijgt fout te zien bij een error
    }
    $stmt->close(); //sluit de statement
} catch (Exception $e) {
    echo "Fout bij het uitvoeren van de query: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bokser Verwijderen</title>
    <style>
       
       body {
            font-family: Arial, sans-serif;
            background-image: url('img/boxing.jpg');
            background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center; 
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }


        h1 {
            color: #d62828; /* Donkerrood */
        }

        a {
            color: #003049; /* Donkerblauw */
            text-decoration: none;
        }

        a:hover {
            color: #f77f00; /* Oranje */
        }

        button {
            background-color: #003049; /* Donkerblauw */
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #d62828; /* Donkerrood */
        }

        .container {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="read_boxers.php">
    <button>Terug naar lijst</button></a>
</div>
</body>
</html>
