<?php
require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
// Alter table to add columns
// Check if columns exist before adding them
$result = $db->query("SHOW COLUMNS FROM llx_product LIKE 'container_id'");
if ($result->num_rows == 0) {
    $sql = "ALTER TABLE llx_product ADD COLUMN container_id int(11)";
    if ($db->query($sql) === TRUE) {
        echo "Column container_id added successfully to llx_product table.";
    } else {
        echo "Error adding column container_id: " . $db->error;
    }
}

$result = $db->query("SHOW COLUMNS FROM llx_product LIKE 'quantity'");
if ($result->num_rows == 0) {
    $sql = "ALTER TABLE llx_product ADD COLUMN quantity int(11)";
    if ($db->query($sql) === TRUE) {
        echo "Column quantity added successfully to llx_product table.";
    } else {
        echo "Error adding column quantity: " . $db->error;
    }
}

// Create llx_categorie_extrafields table if it does not exist
$sql2 = "CREATE TABLE IF NOT EXISTS llx_categorie_extrafields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rowid INT NOT NULL,
    fk_category INT NOT NULL,
    fieldname VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($db->query($sql2) === TRUE) {
    echo "Table llx_categorie_extrafields created successfully or already exists.";
} else {
    echo "Error creating table llx_categorie_extrafields: " . $db->error;
}

// Create llx_product_categories table if it does not exist
$sql3 = "CREATE TABLE IF NOT EXISTS llx_product_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rowid INT NOT NULL,
    fk_product INT NOT NULL,
    fieldname VARCHAR(255) NOT NULL,
    fieldvalue VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($db->query($sql3) === TRUE) {
    echo "Table llx_product_categories created successfully or already exists.";
} else {
    echo "Error creating table llx_product_categories: " . $db->error;
}

// Close dbection
$db->close();