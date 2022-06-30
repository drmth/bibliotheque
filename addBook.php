<?php

require_once 'connec.php';
$pdo = new \PDO(DSN, USER, PASS);
$query = "SELECT * FROM author";
$statement = $pdo->query($query);
$authors = $statement->fetchAll();
sort($authors);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $pdo;
    $author_id = $_POST['authors_list'];
    $image = $_POST['image'];
    $title = $_POST['title'];
    $sth = $pdo->prepare("INSERT INTO book (title, image, author_id) VALUES (:title, :image, $author_id)");
    $sth->bindValue('image', $image, PDO::PARAM_STR);
    $sth->bindValue('title', $title, PDO::PARAM_STR);
    $sth->execute();
    header('Location: biblio.php');
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
        <p style="text-align:center">Ajout d'un livre</p>
    </h1>
    <br>
    <form  action ="addBook.php" method="post" style="justify-content: center;">
        <div style="padding: 10px;">
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title">
        </div>
        <div style="padding: 10px;">
            <label for="image">Image :</label>
            <input type="text" id="image" name="image">
        </div>
        <div style="padding: 10px;">
            <label for="authors">Auteur: </label>
            <select id="authors_list" name="authors_list">
                <?php foreach ($authors as $author) : ?>
                    <option value="<?php echo $author['id']?>">
                        <?php echo $author['first_name'] . ' ' . $author['last_name']?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="button" style="padding: 10px;">
            <input type="submit" name="action" value="Ajouter"></input>
        </div>
    </form>
</body>

</html>