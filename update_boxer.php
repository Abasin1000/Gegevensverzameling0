<?php
require 'db.php';
session_start();
//start de sessie
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$id = (int)$_GET['id'];
$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //checked of het een post of get is
    try {
        $name = htmlspecialchars($_POST['name']); //beveiliging
        $wins = (int)$_POST['wins']; //de variabelen voor de win verliezen en kos
        $losses = (int)$_POST['losses']; 
        $kos = (int)$_POST['kos'];
        $query = ("UPDATE boxers SET name = ?, wins = ?, losses = ?, kos = ? WHERE id = ?"); //de query word aangemaakt
        $stmt = $conn->prepare($query); //prepared de query //bescherm tegen sql-injection
        $stmt->bind_param("siiii", $name, $wins, $losses, $kos, $id); //bind de paramater

        if ($stmt->execute()) { //statement word ge execute  //finally erbij 
                                                             //beter uitleg
            $success = true;                                 //elk detail goed kunnen uitleggen
        } else {                                             //throw
                                                             
            $error = "Fout: " . $stmt->error;//je ziet fout bij een error
        }
        $stmt->close(); //sluit de statement
    } catch (Exception $e) {
        $error = "Fout bij het uitvoeren van de query: " . $e->getMessage();
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM boxers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $boxer = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bokser Bijwerken</title>
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
            background-color: #fff;
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
if ($success) { //de form wat de informatie bevat voor de bokser etc
    echo '<p class="message">Bokser succesvol bijgewerkt!</p>';
    echo '<a href="read_boxers.php"><button>Bekijk Boksers</button></a>';
} else {
    if ($error) {
        echo '<p class="message">' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    echo '<form method="post" action="update_boxer.php?id=' . $id . '">';
    echo 'Naam: <input type="text" name="name" value="' . htmlspecialchars($boxer['name'], ENT_QUOTES, 'UTF-8') . '" required>';
    echo 'Overwinningen: <input type="number" name="wins" value="' . htmlspecialchars($boxer['wins'], ENT_QUOTES, 'UTF-8') . '" required>';
    echo 'Verliezen: <input type="number" name="losses" value="' . htmlspecialchars($boxer['losses'], ENT_QUOTES, 'UTF-8') . '" required>';
    echo 'KOs: <input type="number" name="kos" value="' . htmlspecialchars($boxer['kos'], ENT_QUOTES, 'UTF-8') . '" required>';
    echo '<button type="submit">Bokser Bijwerken</button>';
    echo '</form>';
    echo '<a href="read_boxers.php"><button>Bekijk Boksers</button></a>';
}
?>
</div>
</body>
</html>
