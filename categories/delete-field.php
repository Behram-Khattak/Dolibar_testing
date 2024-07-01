<?php
require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

try {
    $sql2 = "DELETE FROM llx_categorie_extrafields WHERE rowid ='{$_GET['id']}'";
    $result2 = $db->query($sql2);
    if($result2){
        echo json_encode([
           'success' => true,
           'message' => 'Delete Success'
        ]);
    }else{
        echo json_encode([
           'success' => false,
           'message' => 'Delete Failed'
        ]);
    }
    
} catch (\Throwable $th) {
    echo json_encode([
        'success' => false,
        'message' => $th->getMessage()
    ]);
}
