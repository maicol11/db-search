<?php
    $host = "localhost";
    $dbname = "university_first_work";
    $username = "root";
    $password = "";
    $conection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    $where = '';
    $state = "";
    $title = "";
    $owner = "";
    $filter = "";

    if (isset($_REQUEST["state"]) && $_REQUEST["state"] != "") {
        $state = $_REQUEST["state"];
        $where = "WHERE f.active='$state'";
    }

    if (isset($_REQUEST["title"]) && $_REQUEST["title"] != "") {
        $title = $_REQUEST["title"];
        if ($where=="") {
            $where = "WHERE f.title LIKE '%$title%'";
        }else {
            $filter = $_REQUEST["filter_by"];
            $where .= " $filter f.title LIKE '%$title%'";
        }
    }

    if (isset($_REQUEST["owner"]) && $_REQUEST["owner"] != "") {
        $owner = $_REQUEST["owner"];
        if ($where=="") {
            $where = "WHERE u.name LIKE '%$owner%'";
        }else {
            $filter = $_REQUEST["filter_by"];
            $where .= " $filter u.name LIKE '%$owner%'";
        }
    }

    $query = $conection->prepare("SELECT f.title, f.description, f.active, u.name FROM forums as f INNER JOIN users as u ON f.user_id = u.id $where");
    $query->execute();
    $forums = $query->fetchAll();


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
        <h2>Reporte foros/artículos</h2>
        <br>
        <form action="forumReport.php" method="post">
            <p>Filtrar reporte por:</p>
            <label for="state">Estado:</label>
            <select id="state" name="state">
                <option value="" <?php echo ($state=="")?'selected':'' ?>>Seleccione...</option>
                <option value="1" <?php echo ($state==1)?'selected':'' ?>>Activo</option>
                <option value="0" <?php echo ($state==0 && $state!="")?'selected':'' ?>>Inactivo</option>
            </select>
            <label for="title">Titulo</label>
            <input id="title" type="text" name="title" value="<?php echo $title; ?>">
            <label for="owner">Dueño</label>
            <input id="owner" type="text" name="owner" value="<?php echo $owner; ?>">
            <br><br>
            <button type="submit" name="filter_by" value="AND">Cumplir todos los filtros</button>
            <button type="submit" name="filter_by" value="OR">Cumplir cualquier filtro</button>
        </form>
        <br><br>
        <table>
            <thead>
                <th>Titulo</th>
                <th>Descripción corta</th>
                <th>Dueño</th>
                <th>Activo</th>
            </thead>
            <tbody>
                <?php foreach ($forums as $key => $forum): ?>
                    <tr>
                        <td><?php echo $forum["title"] ?></td>
                        <td><?php echo substr($forum["description"], 0, 50) ?>...</td>
                        <td><?php echo $forum["name"] ?></td>
                        <td><?php echo ($forum["active"]==1)?'Activo':'Inactivo' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
