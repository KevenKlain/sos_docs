<?php
require '../model/database.php';
$marca = [];
$sql = "SELECT 
            id_marca,
            tx_marca            
        FROM tb_marca
        ORDER BY id_marca";

if($result = pg_query($conn, $sql)){
    $i = 0;    
    while($row = pg_fetch_assoc($result)) {
        $marca[$i]['id_marca']     = $row['id_marca'];
        $marca[$i]['tx_marca']     = $row['tx_marca'];            
        $i++;
   }
    echo json_encode($marca);
}else{
    http_response_code(404);
}
session_write_close();
?>