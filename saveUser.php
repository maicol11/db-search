<?php
    $host       = "localhost";
    $dbname     = "university_first_work";
    $username   = "root";
    $password   = "";

    $conection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $name           = $_REQUEST["name"];
    $email          = $_REQUEST["email"];
    $description    = $_REQUEST["description"];
    $role_id        = $_REQUEST["role_id"];

    $query = $conection->prepare("INSERT INTO users (id, name, email, description, role_id) VALUES(NULL, '$name', '$email', '$description', '$role_id') ");
    $query->execute();

    $q = $conection->prepare("SELECT name FROM roles WHERE id=$role_id");
    $q->execute();
    $rol = $q->fetch();
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
            <h4>Usuario guardado con exito</h4>
        </div>
        <div class="info">
            <p>Nombre: <strong><i><?php echo $name ?></i></strong></p>
            <p>Correo Electrónico: <strong><?php echo $email; ?></strong></p>
            <p>Descripción: <strong><?php echo $description; ?></strong></p>
            <p>Rol: <strong><?php echo $rol["name"]; ?></strong></p>
        </div>
        <br>
        <a href="createUser.php" class="btn-link">Crear otro usuario</a>
    </div>
</body>
</html>
