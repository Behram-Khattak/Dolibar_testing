<?php
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

try {
    $container_name = htmlspecialchars(trim($_POST['container_name']));
    $container_type = htmlspecialchars(trim($_POST['container_type']));
    $arrival_date = htmlspecialchars(trim($_POST['arrival_date']));
    $container_id = htmlspecialchars(trim($_POST['container_id']));
    if(isset($container_name) && isset($container_type) && isset($container_id) && isset($arrival_date)){
        $sql = "SELECT * FROM llx_containers WHERE container_id ='{$container_id}'";
        $result = $db->query($sql);
        if ($db->num_rows($result) > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Container ID already exists'
            ]);
            exit();
        } else {
            $sql = "INSERT INTO llx_containers (`container_id`,`container_name`,`container_type`,`arrival_date`) VALUES ('{$container_id}','{$container_name}','{$container_type}','{$arrival_date}')";
            $result = $db->query($sql);
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Container add successfully'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'container not add successfully'
                ]);
            }
        }
    }else{
        echo json_encode([
            'success' => false,
           'message' => 'Please fill all fields'
        ]);
    }
    
} catch (\Throwable $th) {
    echo json_encode([
        'success' => false,
        'message' => $th->getMessage()
    ]);
}
