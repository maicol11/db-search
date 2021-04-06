<?php
    $host       = "localhost";
    $dbname     = "university_first_work";
    $username   = "root";
    $password   = "";

    $conection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $title          = $_REQUEST["title"];
    $description    = $_REQUEST["description"];
    $user_id        = $_REQUEST["user_id"];

    $query = $conection->prepare("INSERT INTO forums (id, title, description, user_id) VALUES(NULL, '$title', '$description', '$user_id') ");
    $query->execute();
    $q = $conection->prepare("SELECT name FROM users WHERE id=$user_id");
    $q->execute();
    $user = $q->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Citas a un solo paso</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h3>Citas App</h3>
        <div class="options">
            <a href="index.php">Crear foro</a>
            <a href="createUser.php">Crear usuario</a>
            <a href="forumReport.php">Reporte foros</a>
            <a href="userReport.php">Reporte usuarios</a>
        </div>
    </header>
    <div class="container">
        <div class="alert-success">
            <h4>Foro guardado con exito</h4>
        </div>
        <div class="info">
            <p>Publicado por: <strong><i><?php echo $user["name"] ?></i></strong></p>
            <p>Titulo: <strong><?php echo $title; ?></strong></p>
            <p>Descripción: <strong><?php echo $description; ?></strong></p>
        </div>
        <br>
        <a href="index.php" class="btn-link">Crear otro foro</a>
    </div>
</body>
</html>
