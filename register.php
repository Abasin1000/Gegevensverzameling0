<?php
// Inclusie van het databasebestand
require 'db.php';

// Start de sessie
session_start();


// checked of het registratie succesvol is verlopen
$success = false;

// hier word foutmeldingen opgeslagen
$error = '';

// Controleert verzoek
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
// Beveiliging
 $username = htmlspecialchars($_POST['username']);

    // Nogmaals beveiling maar dan met hash voor de wachtwoord
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $query = ("INSERT INTO users (username, password) VALUES (?, ?)");
        // Bereid een sql instructie voor om een nieuwe gebruiker toe te voegen
        $stmt = $conn->prepare($query);

        // Bind de gebruikersnaam en het gehashte wachtwoord aan de sql instructie
        $stmt->bind_param("ss", $username, $password);

        // Voer de sql instructie uit en controleer of het gelukt is
        if ($stmt->execute()) {
            
            $success = true;

            // Stuur de gebruiker door naar het inlogscherm na succesvolle registratie
            header('Location: login.php');

            // Stop 
            exit;
        } else {
            // Als er een fout optreedt bij het uitvoeren van de sql instructie  dan word de fout opgeslagen
            $error = "Fout: " . $stmt->error;
        }

        // Sluit de sql instructie
        $stmt->close();
    } catch (Exception $e) {
        // bij een algemeen fout word dit opgeslgaen
        $error = "Fout bij het uitvoeren van de query: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registreren</title>
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
            color: #d62828;
        }

        a {
            color: #003049;
            text-decoration: none;
        }

        a:hover {
            color: #f77f00;
        }

        button {
            background-color: #003049;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #d62828;
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
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    if ($error) {
        echo '<p class="message">' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    ?>
    <form method="post" action="register.php">
        <h1>Registreren</h1>
        Gebruikersnaam: <input type="text" name="username" required>
        Wachtwoord: <input type="password" name="password" required>
        <button type="submit">Registreren</button>
        <p>Al een account? <a href="login.php">Inloggen</a></p>
    </form>
</div>
</body>
</html>
