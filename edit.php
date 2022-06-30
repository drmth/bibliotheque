<?php

require_once 'connec.php';
$pdo = new \PDO(DSN, USER, PASS);
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_POST['image_form'];
    $title = $_POST['title_form'];
    update($id, $image, $title);
    header('Location: biblio.php');
} else {
    $query = "SELECT * FROM book WHERE id = $id";
    $statement = $pdo->query($query);
    $book = $statement->fetchAll();
    $image = $book[0]['image'];
    $title = $book[0]['title'];
}

function delete() { 
    global $pdo;
    $query = "DELETE FROM book WHERE book.id = id";
    $statement = $pdo->exec($query);
}

function update($id, $image_update, $title_update) {
    global $pdo;
    $sth = $pdo->prepare("UPDATE book SET image = :image, title = :title WHERE book.id = $id");
    $sth->bindValue('image', $image_update, PDO::PARAM_STR);
    $sth->bindValue('title', $title_update, PDO::PARAM_STR);
    $sth->execute();
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
        <p style="text-align:center">Mise à jour du livre</p>
    </h1>   
    <br>

    <form action="edit.php?id=<?php echo $id; ?>" method="post">
        <div style="padding: 10px;">
            <label for="title_form">Titre :</label>
            <input type="text" id="title_form" name="title_form" value="<?php echo $title ?>">
        </div>
        <div style="padding: 10px;">
            <label for="image_form">Image :</label>
            <input type="text" id="image_form" name="image_form" value="<?php echo $image ?>">
        </div style="padding: 10px;">
        <div class="button">
            <input type="submit" value="Mettre à jour">
        </div>
    </form>

</body>

</html>