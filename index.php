<?php
require_once 'autoload.php'
?>

<form method="post" action="upload.php" enctype="multipart/form-data">
    <label>Name: <input type="file" name="file"></label> Size: <input type="text" name="width">x<input type="text" name="height"> <label><input type="checkbox" name="Crop" value="Crop" />Crop</label><br>
    <input type="submit" name="submit" value="Submit">
</form>