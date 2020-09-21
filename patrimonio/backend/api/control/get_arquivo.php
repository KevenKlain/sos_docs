<?php
require '../model/database.php';
$arquivo = [];
$sql = "SELECT 
            id_pdf,
            arquivo            
        FROM tb_arquivo
        ORDER BY id_pdf";

if($result = pg_query($conn, $sql)){
    $i = 0;    
    while($row = pg_fetch_assoc($result)) {
        $arquivo[$i]['id_pdf']     = $row['id_pdf'];
        $arquivo[$i]['arquivo']    = $row['arquivo'];            
        $i++;
   }
    echo json_encode($arquivo);
}else{
    http_response_code(404);
}
session_write_close();
?>