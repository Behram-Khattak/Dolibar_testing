<?php
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';



$index_loc = DOL_URL_ROOT . '/container/index.php';

try {
    if(isset($_GET['rowid'])){
        $sql = "DELETE FROM llx_containers where rowid = {$_GET['rowid']}";
        $result=$db->query($sql);
        if($result){
            // echo json_encode([
            //    'success' => true,
            //    'message' => 'ok'
            // ]);

            echo "<script type='text/javascript'>
                    window.location.href = '$index_loc';
                  </script>";
        }else{
            echo json_encode([
               'success' => false,
               'message' => 'delete failed'
            ]);
        } 
    }  
} catch (\Throwable $th) {
    echo json_encode([
        'success' => false,
        'message' => $th->getMessage()
    ]);
}
