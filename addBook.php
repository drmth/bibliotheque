<?php

require_once 'connec.php';
$pdo = new \PDO(DSN, USER, PASS);
$query = "SELECT * FROM author";
$statement = $pdo->query($query);
$authors = $statement->fetchAll();
sort($authors);

$query = "SELECT * FROM format_source";
$statement = $pdo->query($query);
$formats = $statement->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $pdo;
    $query_format = "";
    $author_id = $_POST['authors_list'];
    $format_selected = $_POST['format'];
    $image = $_POST['image'];
    $title = $_POST['title'];
    $sth = $pdo->prepare("INSERT INTO book (title, image, author_id) VALUES (:title, :image, $author_id)");
    $sth->bindValue('image', $image, PDO::PARAM_STR);
    $sth->bindValue('title', $title, PDO::PARAM_STR);
    $sth->execute();
    $id = $pdo->lastInsertId();
    foreach ($format_selected as $format) {
        $query_format .= "INSERT INTO format_bind(book_id, format_id) VALUES ($id, $format);";
    }
    $statement = $pdo->query($query_format);
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
                <?php endforeach ?>
            </select>
        </div>
        <div style="padding: 10px; padding-top: 20px;">
            <p>Formats disponibles : </p>
        </div>
        <div style="padding: 10px;">
            <?php foreach ($formats as $format) :?>
                <input type="checkbox" id=<?php echo $format['type'] ?> value=<?php echo $format['id'] ?> name="format[]">
                <label for=<?php echo $format['type'] ?>><?php echo $format['type'] ?></label>
            <?php endforeach ?>
        </div>
        <div class="button" style="padding: 10px;">
            <input type="submit" name="action" value="Ajouter"></input>
        </div>
    </form>
</body>

</html>