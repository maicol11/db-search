<?php
    $host = "localhost";
    $dbname = "university_first_work";
    $username = "root";
    $password = "";

    $conection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $query = $conection->prepare("SELECT id, name FROM users");
    $query->execute();
    $users = $query->fetchAll();
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
        <h2>Crear foro</h2>
        <br>
        <form action="saveForum.php" method="post">
            <label for="title">Titulo</label>
            <br>
            <input id="title" type="text" name="title" value="">
            <br>
            <br>
            <label for="description">Description</label>
            <br>
            <textarea name="description" rows="8" cols="80"></textarea>
            <br>
            <br>
            <label for="user">Usuario que publica</label>
            <br>
            <select id="user" name="user_id">
                <option value="">Seleccione...</option>
                <?php foreach ($users as $key => $value): ?>
                    <option value="<?php echo $value["id"] ?>"><?php echo $value["name"] ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <br>
            <button type="submit">Guardar foro</button>
        </form>
    </div>
</body>
</html>
