<?php
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

try {
    $sql2 = "SELECT * FROM llx_categorie WHERE rowid ='{$_GET['id']}'";
    $result2 = $db->query($sql2);

    if ($db->num_rows($result2) > 0) {
        $row2 = $db->fetch_object($result2);

        $sql = "SELECT * FROM llx_categorie_extrafields WHERE fk_category ='{$row2->rowid}'";
        $result = $db->query($sql);
        if ($db->num_rows($result) > 0) {
            $output = "";
            // if ($db->num_rows($result) > 0) {  
            while ($row = $db->fetch_object($result)) {
                $field_name = strtolower($row->fieldname);
                $output .= "<tr>
                            <td><label>{$row->fieldname}</label></td>
                            <td><input type='text' name='category_field[{$field_name}]'  /></td> 
                </tr>";
            }
            echo json_encode([
                'success' => true,
                'data' => $output
            ]);
        } else {
            $sql = "SELECT * FROM llx_categorie_extrafields WHERE fk_category ='{$_GET['id']}'";
            $result = $db->query($sql);

            $output = "";
            // if ($db->num_rows($result) > 0) {  
            while ($row = $db->fetch_object($result)) {
                $field_name = strtolower($row->fieldname);
                $output .= "<tr>
                            <td><label>{$row->fieldname}</label></td>
                            <td><input type='text' name='category_field[{$field_name}]'  /></td> 
                </tr>";
            }
            echo json_encode([
                'success' => true,
                'data' => $output
            ]);
        }
    }
} catch (\Throwable $th) {
    echo json_encode([
        'success' => false,
        'message' => $th->getMessage(),
    ]);
}
