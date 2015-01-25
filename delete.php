<?php
require_once 'autoload.php'
?>

<?php
$database = new Database;
$delete = new Delete;

$image = $database->getImageFromUrl();

if (!isset($image)) exit;

if (!$delete->deleteImageFromDrive($image['name'])) exit;
$database->deleteImageFromDatabase($image['originalname']);

if(!$delete->deleteThumbnailsFromDrive($image['name'])) exit;
$database->deleteThumbnailsFromDatabase($image['originalname']);


header("Location: index.php");
?>
