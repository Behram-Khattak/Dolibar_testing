<?php
require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

$sql = "ALTER TABLE llx_product ADD COLUMN container_id int(11), ADD COLUMN quantity int(11)";

if ($db->query($sql) === TRUE) {
    echo "Table altered successfully";
} else {
    echo "Error altering table: " . $db->error;
}

// llx_categorie_extrafields
$sql2 = "CREATE TABLE llx_categorie_extrafields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rowid INT NOT NULL,
    fk_category INT NOT NULL
    fieldname VARCHAR(255) NOT NULL
    created_at TIMESTAMP NOT NULL
    updated_at TIMESTAMP NOT NULL
)";

if ($db->query($sql2) === TRUE) {
    echo "Table llx_categorie_extrafields created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// llx_product_categories    
$sql2 = "CREATE TABLE llx_product_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rowid INT NOT NULL,
    fk_product INT NOT NULL
    fieldname VARCHAR(255) NOT NULL
    fieldvalue VARCHAR(255) NOT NULL
    created_at TIMESTAMP NOT NULL
    updated_at TIMESTAMP NOT NULL
)";

if ($db->query($sql2) === TRUE) {
    echo "Table llx_product_categories created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// Close connection
$db->close();