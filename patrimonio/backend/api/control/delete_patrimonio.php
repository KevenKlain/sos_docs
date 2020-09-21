<?php
require '../model/database.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, X-Auth-Token, Accept");
header ("Access-Control-Allow-Headers: *");

// Extract, validate and sanitize the id.
if($_GET['id_tombo'] != null && $_GET['id_tombo'] > 0){
    $id_tombo = pg_escape_string($conn, TRIM((int)$_GET['id_tombo']));
}else{
    $id_tombo = false;
}
if(!$id_tombo){
  return http_response_code(400);
}else{  
    // Delete.
    $sql = "DELETE FROM tb_patrimonio WHERE id_tombo = $id_tombo";
    if(pg_query($conn, $sql))
    {      
      $response = [
        'resposta'       => '200',
        'mensagem'       => 'Registro deletado com sucesso!'     
      ];  
      echo json_encode($response);      
    }else{
    return http_response_code(422);
    }
}  
session_write_close();
?>
