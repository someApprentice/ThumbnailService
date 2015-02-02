<?php
require_once 'autoload.php'
?>

<?php
ImageManager::deleteImageAndThumbnail();


header("Location: index.php");
?>
