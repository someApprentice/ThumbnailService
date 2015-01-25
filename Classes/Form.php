<?php
require_once __DIR__ . '/../autoload.php';
?>

<?php
class Form {
	public function validateForm($name, $size, $temp) {
		$errors = array();

		if (!preg_match('/^[\\w\\.]+$/', $name)) $errors['name'] = "Incorrect name";
		if ($size > 20000000) $errors['size'] = "Incorrect size";
		if (!isset($temp)) $errors['temp'] = "No temp";

		return $errors;
	}
}
?>