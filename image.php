<?php
require_once 'autoload.php'
?>

<?php
$image = Database::getImageFromUrl();
$thumbnails = Database::getThumbnailsByImage($image['name']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload</title>
    <link rel='stylesheet' type='text/css' href='css/stylesheet.css'>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
</head>
<body>
    <div class="wrapper">
        <img src="/../uploads/<?=$image['directory']?>/<?=$image['name']?>">

        <div class="description">
            Name: <?=$image['name']?> <br>

            <label>Img link: <input type="text" value="localhost/uploads/<?=$image['directory']?>/<?=$image['name']?>" onclick="this.select()"></label><br>
            Thumbnails: <br>
            <?php foreach ($thumbnails as $key => $value) :?>
                <label><?=$value['width']?>x<?=$value['height']?>: <input type="text" value="localhost/thumbnails/<?=$value['directory']?>/<?=$value['name']?>" onclick="this.select()"></label><br>
            <?php endforeach; ?>
        </div>
        <a class="delete" href="delete.php?name=<?=$image['name']?>">Delete</a>
    </div>
</body>
</html>
