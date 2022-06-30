<?php

require_once 'connec.php';
$pdo = new \PDO(DSN, USER, PASS);
$books = array();

if(isset($_GET['search']) AND !empty($_GET['search'])) {
    $search = $_GET['search'];
    $sth = $pdo->prepare("SELECT book.*, author.last_name, author.first_name FROM book LEFT JOIN author ON book.author_id = author.id WHERE title LIKE :search LEFT JOIN format_bind ON book.id = format_bind.book_id ORDER BY book.title ASC");
    $sth->bindValue('search', '%'.$search.'%', PDO::PARAM_STR);
    $sth->execute();
    $books = $sth->fetchAll();
} else {
    $query = "SELECT book.*, author.last_name, author.first_name, format_bind.book_id, format_bind.format_id FROM book LEFT JOIN author ON book.author_id = author.id LEFT JOIN format_bind ON book.id = format_bind.book_id ORDER BY book.title ASC";
    $statement = $pdo->query($query);
    $books = $statement->fetchAll();
    var_dump($books);
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
    <h1 style="padding-top: 24px;">
        <p style="text-align:center">Bienvenue à la bibliothèque</p>
    </h1>
    <br>
    <div style="display: flex; padding: 10px;">
        <a href="addBook.php">
            <img src="circle-plus-solid.svg" style="height: 50px; padding: 10px;">
        </a>
        <p style="padding: 10px;">Ajouter un nouveau livre</p>
    </div>
    <br>
    <div style="padding: 10px;">
        <form method="GET">
            <input type="search" name="search" placeholder="Recherche..." />
            <input type="submit" value="Valider" />
        </form>
    </div>
    <br>
    <?php foreach ($books as $key => $book) : ?>
        <div style="display: inline-block; margin: 10px; padding:10px; border:1px solid black; border-radius:10px; width: 20%; justify-content: center;">
            <img src="<?php echo $book['image'] ?>" style="height: 500px;">
            <div style="display: flex; flex-direction: row;">
                <div>
                    <p><b><?php echo $book['title'] ?></b></p>
                    <p>Écrit par: <?php echo $book['first_name'] . ' ' . $book['last_name'] ?></p>
                </div>
            </div>
            <a href="edit.php?id=<?php echo $book['id']; ?>">
                <img src="pen-solid.svg" style="height: 30px; padding: 10px;">
            </a>
            <a href="delete.php?id=<?php echo $book['id']; ?>">
                <img src="trash-solid.svg" style="height: 30px; padding: 10px;">
            </a>
        </div>
        </div>
        </div>
    <?php endforeach; ?>
</body>

</html>