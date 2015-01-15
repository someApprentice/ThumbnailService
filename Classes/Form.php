<?php
class Form {
	public fuction validateForm($name, $size, $temp) {
		if (!preg_match(('/^[\\w\\.]+$/', $name)) $errors['name'] = "Incorrect name.";
		if ($size > 20000000) $errors['size'] = "Incorrect size";
		if (!isset($temp)) $errors['temp'] = "No temp";

		return $errors;
	}
}
?>