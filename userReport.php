<?php
    $host = "localhost";
    $dbname = "university_first_work";
    $username = "root";
    $password = "";
    $conection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    $where = '';
    $rolR = "";
    $email = "";
    $name = "";
    $filter = "";

    if (isset($_REQUEST["rol"]) && $_REQUEST["rol"] != "") {
        $rolR = $_REQUEST["rol"];
        $where = "WHERE r.id='$rolR'";
    }

    if (isset($_REQUEST["email"]) && $_REQUEST["email"] != "") {
        $email = $_REQUEST["email"];
        if ($where=="") {
            $where = "WHERE u.email = '$email'";
        }else {
            $filter = $_REQUEST["filter_by"];
            $where .= " $filter u.email = '$email'";
        }
    }

    if (isset($_REQUEST["name"]) && $_REQUEST["name"] != "") {
        $name = $_REQUEST["name"];
        if ($where=="") {
            $where = "WHERE u.name LIKE '%$name%'";
        }else {
            $filter = $_REQUEST["filter_by"];
            $where .= " $filter u.name LIKE '%$name%'";
        }
    }

    $query = $conection->prepare("SELECT u.name, u.email, u.active, r.name as rol FROM users as u INNER JOIN roles as r ON u.role_id = r.id $where");
    $query->execute();
    $users = $query->fetchAll();

    $q = $conection->prepare("SELECT id, name FROM roles");
    $q->execute();
    $roles = $q->fetchAll();


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
        <h2>Reporte usuarios</h2>
        <br>
        <form action="userReport.php" method="post">
            <p>Filtrar reporte por:</p>
            <label for="rol">Rol:</label>
            <select id="rol" name="rol">
                <option value="" <?php echo ($rolR=="")?'selected':'' ?>>Seleccione...</option>
                <?php foreach ($roles as $key => $rol): ?>
                    <option value="<?php echo $rol["id"] ?>" <?php echo ($rolR==$rol["id"])?'selected':'' ?>><?php echo $rol["name"] ?></option>
                <?php endforeach; ?>
            </select>
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="<?php echo $email; ?>">
            <label for="name">Nombre</label>
            <input id="name" type="text" name="name" value="<?php echo $name; ?>">
            <br><br>
            <button type="submit" name="filter_by" value="AND">Cumplir todos los filtros</button>
            <button type="submit" name="filter_by" value="OR">Cumplir cualquier filtro</button>
        </form>
        <br><br>
        <table>
            <thead>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Rol</th>
                <th>Activo</th>
            </thead>
            <tbody>
                <?php foreach ($users as $key => $user): ?>
                    <tr>
                        <td><?php echo $user["name"] ?></td>
                        <td><?php echo $user["email"] ?></td>
                        <td><?php echo $user["rol"] ?></td>
                        <td><?php echo ($user["active"]==1)?'Activo':'Inactivo' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
