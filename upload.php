<?php
/**
 * This is just an example of how a file could be processed from the
 * upload script. It should be tailored to your own requirements.
 */

// Only accept files with these extensions
$whitelist = array('jpg', 'jpeg', 'png', 'gif');
$name      = null;
$error     = 'No file uploaded.';
$ext       = '';

if (isset($_FILES)) {
	if (isset($_FILES['file'])) {
		$tmp_name = $_FILES['file']['tmp_name'];
		$name     = basename($_FILES['file']['name']);
		$error    = $_FILES['file']['error'];
		$ext = strtolower(end((explode(".", $name))));
		if ($error === UPLOAD_ERR_OK) {
			$extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

			if (!in_array($extension, $whitelist)) {
				$error = 'Invalid file type uploaded.';
			} else {
				// BUG FIX: Cookie-based path injection â $_COOKIE["IMG"] was used directly as filename.
				// Attacker could set cookie to "../../config/database" to overwrite sensitive files.
				// Fix: sanitize cookie value â allow only alphanumeric, underscore, hyphen
				$img_name = isset($_COOKIE["IMG"]) ? $_COOKIE["IMG"] : '';
				$img_name = preg_replace('/[^a-zA-Z0-9_\-]/', '', $img_name);
				if (empty($img_name)) {
					$error = 'Invalid upload target.';
				} else {
					move_uploaded_file($tmp_name, 'ho/' . $img_name . '.' . $ext);
				}
			}
		}
	}
}

// BUG FIX: Same cookie sanitization for output â prevent XSS via cookie value
$img_name_out = isset($_COOKIE["IMG"]) ? preg_replace('/[^a-zA-Z0-9_\-]/', '', $_COOKIE["IMG"]) : '';
echo json_encode(array(
	'name'  => $img_name_out . '.' . $ext,
	'error' => $error,
));
die();
<?php
/**
 * This is just an example of how a file could be processed from the
 * upload script. It should be tailored to your own requirements.
 */

// Only accept files with these extensions
$whitelist = array('jpg', 'jpeg', 'png', 'gif');
$name      = null;
$error     = 'No file uploaded.';

if (isset($_FILES)) {
	if (isset($_FILES['file'])) {
		$tmp_name = $_FILES['file']['tmp_name'];
		$name     = basename($_FILES['file']['name']);
		$error    = $_FILES['file']['error'];
		$ext = end((explode(".", $name))); 
		if ($error === UPLOAD_ERR_OK) {
			$extension = pathinfo($name, PATHINFO_EXTENSION);

			if (!in_array($extension, $whitelist)) {
				$error = 'Invalid file type uploaded.';
			} else {
				move_uploaded_file($tmp_name,'ho/'.$_COOKIE["IMG"].'.'.$ext);
			}
		}
	}
}

echo json_encode(array(
	'name'  => $_COOKIE["IMG"].'.'.$ext,
	'error' => $error,
));
die();
