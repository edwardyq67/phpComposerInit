<?php
use Vidamrr\Notas\models\Note;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $uuid = $_POST['id'];
    Note::delete($uuid); 
    header('location:http://localhost:67/dashboard/notas/?view=home');

}

$notes = Note::getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
</head>
<body>
    <h1>home</h1>
    <a href="?view=create" type="submit"><button>Crear</button></a>
    <?php 
    foreach ($notes as $note) {
        ?>
        <div class="note-preview"> 
            <a href="?view=view&id=<?php echo $note->getUUID(); ?>">
                <div class="title"><?php echo $note->getTitle(); ?></div>
            </a>
            <a href="?view=view&id=<?php echo $note->getUUID(); ?>">
                <button type="submit">Actualizar</button>
            </a>
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?php echo $note->getUUID(); ?>">
                <button type="submit">Eliminar</button>
            </form>
        </div>
    <?php }
    ?>
</body>
</html>
