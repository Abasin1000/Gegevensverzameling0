<?php
require 'db.php';
session_start();
// start de sessie
if (!isset($_SESSION['username'])) { 
    header('Location: login.php');
    exit;
}

$query = ("SELECT * FROM boxers"); //de query 
$stmt = $conn->prepare($query); // prepared de query
$stmt->execute(); //statement word ge execute
$result = $stmt->get_result(); //het resultaat halen van de statement
$boxers = $result->fetch_all(MYSQLI_ASSOC);  //Alle rijen uit het resultaat ophalen als array en maken als variabel
$stmt->close(); //sluit de statement 
?>

<!DOCTYPE html> 
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recensie</title>
    <style>
        /* Algemene stijlen voor de pagina */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background-image: url('img/boxing.jpg');
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: space-between;
        }

        header {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 10px 0;
            margin-bottom: 40%;
        }

        .navbar {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #333;
            padding: 10px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo-nav {
            display: flex;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 50px;
            margin-right: 15px;
        }

        .logo span {
            font-size: 1.8em;
            font-weight: bold;
            color: #fff;
        }

        .nav-list {
            display: flex;
            justify-content: center;
            list-style: none;
        }

        .nav-item {
            margin: 0 20px;
        }

        .nav-link {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            padding: 10px;
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        .nav-link:hover {
            color: #ffcc00;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .nav-link:active {
            color: #ff9900;
        }

        @media (max-width: 768px) {
            .nav-list {
                flex-direction: column;
                text-align: center;
            }

            .nav-item {
                margin: 10px 0;
            }
        }

        .container1 {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            flex-grow: 1; /* Ensures the container grows to fill space, pushing footer down */
        }

        .header1 {
            text-align: center;
        
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #003049;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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

        a {
            color: #003049;
            text-decoration: none;
        }

        a:hover {
            color: #f77f00;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.75);
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo-nav">
                <div class="logo">
                    <img src="logo.png" alt="Logo">
                    <span>Boksers</span>
                </div>
                
                <nav class="navbar">
                    <ul class="nav-list">
                        <li class="nav-item"><a href="read_boxers.php" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="activiteiten.html" class="nav-link">Bekende boksers</a></li>
                        <li class="nav-item"><a href="create_boxer.php" class="nav-link">Voeg je eigen bokser toe!</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="container1">
        <div class="header1">
            <h1>Boksers</h1>
            <a href="create_boxer.php"><button>Bokser toevoegen</button></a>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Overwinningen</th>
                <th>Verliezen</th>
                <th>KOs</th> 
                <th>Acties</th>
            </tr> 
            <?php foreach ($boxers as $boxer): ?> 
            <tr>
                <td><?php echo htmlspecialchars($boxer['id']); ?></td> 
                <td><?php echo htmlspecialchars($boxer['name']); ?></td>
                <td><?php echo htmlspecialchars($boxer['wins']); ?></td> 
                <td><?php echo htmlspecialchars($boxer['losses']); ?></td>
                <td><?php echo htmlspecialchars($boxer['kos']); ?></td>
                <td>
                    <a href="update_boxer.php?id=<?php echo $boxer['id']; ?>">Bewerken</a>
                    <a href="delete_boxer.php?id=<?php echo $boxer['id']; ?>">Verwijderen</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <footer>
        <p>© 2024 Tilburgse Wandeling. Alle rechten voorbehouden.</p>
    </footer>
</body>
</html>
