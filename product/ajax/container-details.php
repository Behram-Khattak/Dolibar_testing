<?php
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

try {
    $sql2 = "SELECT * FROM llx_containers WHERE rowid ='{$_GET['id']}'";
    $result2 = $db->query($sql2);
    $output="";
    if ($db->num_rows($result2) > 0) { 
        while($row=$db->fetch_object($result2)){
            $output .="
            <tr>
                <td><b>Container Type: </b></td>
                <td>{$row->container_type}</td>
            </tr>
            <br>
            <tr>
                <td><b>Container Date: </b></td>
                <td>{$row->arrival_date}</td>
            </tr>
            
            "; 
        } 
        echo json_encode([
           'success' => true,
            'data' => $output
        ]);
    }
} catch (\Throwable $th) {
    echo json_encode([
        'success' => false,
        'message' => $th->getMessage(),
    ]);
}
