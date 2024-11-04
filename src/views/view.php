<?php
use Vidamrr\Notas\models\Note;

if(count($_POST)>0 ){
    $title=isset($_POST["title"])?$_POST["title"]:'';
    $content=isset($_POST["content"])?$_POST["content"]:'';
    $uuid=$_POST['id'];

    $note=Note::get($uuid);
    $note->setTitle($title);
    $note->setContent($content);

    $note->update();

}

if(isset($_GET['id'])){
$note=Note::get($_GET['id']);

}else{
    header('location:http://localhost:67/dashboard/notas/?view=home');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view</title>
</head>
<body>
    <h1>view</h1>
    <a href="?view=home"><button>volver a home</button></a>
    <form action="?view=view&id=<?php echo $note->getUUID()?>" method="POST">
        <input type="text" name="title"  placeholder="<?php echo $note->getTitle()?>">
        <input type="hidden" name="id" value="<?php echo $note->getUUID()?>">
        <textarea name="content" id="" cols="30" rows="10" placeholder="<?php echo $note->getContent()?>"></textarea>
        <input type="submit" value="Update note">
    </form>
</body>
</html>