<?php
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

try {
    if (isset($_POST['name'])) {
        $is_rack_sql = "SELECT * FROM racks where name = {$_POST['name']}";
        $is_rack = $db->query($is_rack_sql);
        if ($is_rack) {
            echo json_encode([
                'success' => false,
                'message' => 'Rack name already exists',
            ]);
        } else {
            $sql = "INSERT INTO racks (`name`) VALUES ('{$_POST['name']}')";
            $reuslt = $db->query($sql);
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => $sql,
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Rack create failed',
                ]);
            }
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Rack name is required',
        ]);
    }
} catch (\Throwable $th) {
    echo json_encode([
        'success' => false,
        'message' => 'Rack create failed',
    ]);
}
