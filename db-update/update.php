<?php
require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

$sql = "ALTER TABLE llx_product MODIFY COLUMN container_id int(11), MODIFY COLUMN quantity int(11)";

if ($db->query($sql) === TRUE) {
    echo "Table altered successfully";
} else {
    echo "Error altering table: " . $db->error;
}

// Close connection
$db->close();