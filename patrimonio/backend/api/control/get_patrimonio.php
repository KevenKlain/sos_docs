<?php

require '../model/database.php';

$patrimonio = [];
$sql = "SELECT 
            id_tombo,
            id_marca,
            descricao,
            tx_marca
        FROM tb_patrimonio
        ORDER BY id_tombo";

if($result = pg_query($conn, $sql)){
    $i = 0;    
    while($row = pg_fetch_assoc($result)) {
        $patrimonio[$i]['id_tombo']  = $row['id_tombo'];
        $patrimonio[$i]['id_marca']  = $row['id_marca'];
        $patrimonio[$i]['descricao'] = $row['descricao']; 
        $patrimonio[$i]['tx_marca']  = $row['tx_marca'];            
        $i++;
   }
    echo json_encode($patrimonio);
}else{
    http_response_code(404);
}
session_write_close();
?>