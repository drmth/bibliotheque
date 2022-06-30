<?php
require_once 'connec.php';
$pdo = new \PDO(DSN, USER, PASS);
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM book WHERE id = $id";
    $statement = $pdo->query($query);
    $book = $statement->fetchAll();
    $image = $book[0]['image'];
    $title = $book[0]['title'];
} else {
    global $pdo;
    $query = "DELETE FROM book WHERE book.id = $id";
    $statement = $pdo->exec($query);
    header("Location: biblio.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>
        <p style="text-align:center">Mettre à la corbeille</p>
    </h1>
    <br>
    <div style="display: inline-block; margin: 10px; padding:10px; border:1px solid black; border-radius:10px;">
        <img src="<?php echo $image ?>">
        <div style="display: flex; flex-direction: row;">
            <div>
                <p><?php echo $title ?></p>
            </div>
        </div>
        <form action="delete.php?id=<?php echo $id; ?>" method="post">
            <div class="button">
                <input type="submit" value="Mettre à la corbeille">
            </div>
    </form>
    </div>
    </div>
    </div>
</body>

</html>