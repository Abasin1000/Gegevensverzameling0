<?php

require 'db.php';

session_start(); // Start de sessie

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Controleer of het een POST-verzoek is
    
    $username = htmlspecialchars($_POST['username']); // Beveiliging
    $password = htmlspecialchars($_POST['password']);

    $query = "SELECT * FROM users WHERE username = ?"; // Correcte SQL-query
    $stmt = $conn->prepare($query); // Bereid de query voor
    $stmt->bind_param("s", $username); // Bind de parameter
    $stmt->execute(); 
    $result = $stmt->get_result(); // Verkrijg het resultaat
    $user = $result->fetch_assoc(); // Haal de gebruiker op

    if ($user && password_verify($password, $user['password'])) { // Controleer of gebruiker bestaat en wachtwoord overeenkomt
        $_SESSION['username'] = $username; // Stel de sessie gebruikersnaam in
        header('Location: read_boxers.php'); // Stuur door naar de hoofdpagina
        exit; // Stop de uitvoering van het script
    } else {
        $error = 'Ongeldige inloggegevens'; // Geef een foutmelding weer
    }
    
    $stmt->close(); // Sluit de statement
}
?>

<!DOCTYPE html>
<html>
<head>
<div class="logo-container">
    <img src="img/ko.webp" alt="Logo" class="logo">
</div>

    <title>Inloggen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('img/login.jpg');
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

        form {
            background-color: #C5C5C5;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 20px;
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .container {
            text-align: center;
        }

        .message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        <style>
    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px; /* Pas aan op basis van de grootte van je logo */
        width: 100px; /* Pas aan op basis van de grootte van je logo */
        margin: 20px auto; /* Centreert de container horizontaal */
    }

    .logo {
        width: 80px; /* Pas aan naar de grootte van je logo */
        height: auto; /* Houdt de verhoudingen van de afbeelding intact */
        animation: spin 3s linear infinite;
        border-radius: 50%; /* Optioneel: voegt een ronde rand toe voor een modernere uitstraling */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optioneel: voegt een schaduw toe voor diepte */
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

    </style>
</head>
<body>
<div class="container">
<?php
// Als er een fout is, toon de foutmelding
if ($error) {
    echo '<p class="message">' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</p>';
}
?>
    <form method="post" action="login.php">
        <h1>Inloggen</h1>
        Gebruikersnaam: <input type="text" name="username" required>
        Wachtwoord: <input type="password" name="password" required>
        <button type="submit">Inloggen</button>
        <p>Nog geen account? <a href="register.php">Registreren</a></p>
    </form>
</div>
</body>
</html>
