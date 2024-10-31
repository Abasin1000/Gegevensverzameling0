<?php
require 'db.php';
session_start();
// start de sessie
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// variabel voor als het fout is
$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //checked of het post of get is
    try {
        $name = htmlspecialchars($_POST['name']); //beveiliging
        $wins = (int)$_POST['wins']; //aantal overwinningen ophalen
        $losses = (int)$_POST['losses'];//aantaal verliezen ophalen
        $kos = (int)$_POST['kos']; //aantal kos ophalen

        $qeury = "INSERT INTO boxers (name, wins, losses, kos) VALUES (?, ?, ?, ?)"; //de query

        $stmt = $conn->prepare($qeury); //prepared de query
        $stmt->bind_param("siii", $name, $wins, $losses, $kos);

        if ($stmt->execute()) { //de statement word ge execute
            $success = true; 
        } else {
            $error = "Fout: " . $stmt->error; //laat fout zien bij een error
        }
        $stmt->close(); //sluit de statement
    } catch (Exception $e) {
        $error = "Fout bij het uitvoeren van de query: " . $e->getMessage(); 
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bokser Toevoegen</title>
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

        form {
            background-color: #E3735E;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 20px;
        }

        input[type="text"],
        input[type="number"] {
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
if ($success) { //de form 
    echo '<p class="message">Bokser succesvol toegevoegd!</p>';
    echo '<a href="read_boxers.php"><button>Bekijk Boksers</button></a>';
} else {
    if ($error) {
        echo '<p class="message">' . $error . '</p>';
    }
    echo '<form method="post" action="create_boxer.php">';
    echo 'Naam: <input type="text" name="name" required>';
    echo 'Overwinningen: <input type="number" name="wins" required>';
    echo 'Verliezen: <input type="number" name="losses" required>';
    echo 'KOs: <input type="number" name="kos" required>';
    echo '<button type="submit">Bokser Toevoegen</button>';
    echo '</form>';
    echo '<a href="read_boxers.php"><button>Bekijk Boksers</button></a>';
}
?>

</div>
</body>
</html>
