<?php
spl_autoload_register(function ($className) {
    if(file_exists('Classes/' . $className . '.php')) {
        require_once __DIR__ . '/Classes/' . $className . '.php';

        return true;
    } else {
        return false;
    }
});
?>

<form method="post" action="upload.php" enctype="multipart/form-data">
    <label>Name: <input type="file" name="file"></label> Size: <input type="text" name="width">x<input type="text" name="height"><br>
    <input type="submit" name="submit" value="Submit">
</form>