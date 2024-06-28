<?php
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

try {
    $sql = "SELECT * FROM llx_categorie_extrafields WHERE fk_category ='{$_GET['id']}'";
    $result = $db->query($sql);

    $output = "";
    if ($db->num_rows($result) > 0) {
        while ($row = $db->fetch_object($result)) {
            $output .= "<tr>
                        <td><label>{$row->fieldname}</label></td>
                        <td><input type='text' name='{$row->fieldname}'  /></td> 
            </tr>";
        }
        echo json_encode([
            'success' => true,
            'data' => $output
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' =>'Not found'
        ]);
    }
} catch (\Throwable $th) {
    echo json_encode([
        'success' => false,
        'message' => $th->getMessage()
    ]);
}
