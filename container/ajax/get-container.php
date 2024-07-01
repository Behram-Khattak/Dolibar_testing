<?php
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

try {
    $sql = "SELECT * FROM llx_containers ORDER BY rowid DESC LIMIT 10";
    $result = $db->query($sql);

    // $viewURL = DOL_DOCUMENT_ROOT . '/container/ajax/view-container.php';

    // $output = "";
    // if ($db->num_rows($result) > 0) {
    //     while ($row = $db->fetch_object($result)) {
    //         $output .= "  <tr>
    //             <th scope='row'>{$row->rowid}</th>
    //             <td>{$row->container_id}</td>
    //             <td>{$row->container_name}</td>
    //             <td>{$row->container_type}</td>
    //             <td>{$row->arrival_date}</td>
    //              <td><a href='{$viewURL}' class='btn btn-success'> View </a></td>
    //             <td><button class='btn btn-success'> Edit </button></td>
    //             <td><button id='deleteContainer' class='btn btn-danger' data-id='{$row->rowid}'> Delete </button></td>
    //             </tr>";
    //     }



        $viewURL = DOL_URL_ROOT . '/container/ajax/view-container.php';

        $output = "";
        if ($db->num_rows($result) > 0) {
            while ($row = $db->fetch_object($result)) {
                $output .= "<tr>
                    <th scope='row'>{$row->rowid}</th>
                    <td>{$row->container_id}</td>
                    <td>{$row->container_name}</td>
                    <td>{$row->container_type}</td>
                    <td>{$row->arrival_date}</td>
                    <td><a href='{$viewURL}?rowid={$row->rowid}' class='btn btn-success'>View</a></td>
                    <td><button class='btn btn-success'>Edit</button></td>
                    <td><button id='deleteContainer' class='btn btn-danger' data-id='{$row->rowid}'>Delete</button></td>
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
