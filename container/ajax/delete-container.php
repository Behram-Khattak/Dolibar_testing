<?php
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

try {
    if(isset($_POST['id'])){
        $sql = "DELETE FROM llx_containers where id = {$_POST['id']}";
        $result=$db->query($sql);
        if($result){
            echo json_encode([
               'success' => true,
               'message' => 'ok'
            ]);
        }

    }
    $result = $db->query($sql);
 
} catch (\Throwable $th) {
    echo json_encode([
        'success' => false,
        'message' => $th->getMessage()
    ]);
}
