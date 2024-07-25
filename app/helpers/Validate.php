<?php
function Validate(array $fields) {
	$validate = [];

	foreach ($fields as $field => $type) {
		switch ($type) {
			case "s": // strings
				$validate[$field] = htmlspecialchars(strip_tags($_POST[$field]));
				break;
						
			case "e": // emails
				$filteredValue = filter_var($_POST[$field], FILTER_VALIDATE_EMAIL);
				$validate[$field] = ($filteredValue !== false) ? $filteredValue : ""; // Assume string vazia ou outro valor padrão para emails inválidos
				break;

			case "p": // passwords
				$validate[$field] = password_hash($_POST[$field], PASSWORD_DEFAULT);
				break;
		}
	}
	return (object) $validate;
}