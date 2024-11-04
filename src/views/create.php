<?php
use Vidamrr\Notas\models\Note;

if(count($_POST)>0){
    $title=isset($_POST["title"])?$_POST["title"]:'';
    $content=isset($_POST["content"])?$_POST["content"]:'';

    $note=new Note($title,$content);
    $note->save();
    
    header('location:http://localhost:67/dashboard/notas/?view=home');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
</head>
<body>
    <h1>create</h1>
    <a href="?view=home"><button>volver a home</button></a>
    <form action="?view=create" method="POST">
        <input type="text" name="title" placeholder="Title...">
        <textarea name="content" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="Create note">
    </form>
</body>
</html>