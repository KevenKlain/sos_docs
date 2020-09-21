<?php
require '../model/database.php';
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, X-Auth-Token, Accept");
header ("Access-Control-Allow-Headers: *");
// Extract, validate and sanitize the id.
if($_GET['id_marca'] != null && $_GET['id_marca'] > 0){
    $id_marca = pg_escape_string($conn, TRIM((int)$_GET['id_marca']));
}else{
    $id_marca = false;
}
if(!$id_marca){
  return http_response_code(400);
}
$response = [];
if(!empty($id_marca) && $id_marca > 0){
  $sql_beforeDelete = "SELECT COUNT(1) as qtd FROM tb_patrimonio WHERE id_marca = $id_marca ";
  if($result = pg_query($conn, $sql_beforeDelete)){
    while($row2 = pg_fetch_assoc($result)) {
      $result_sql = $row2['qtd'];              
    }
  }
  if($result_sql > 0){
    $response = [
      'resposta' => '400',
      'mensagem' => 'Não foi possível excluir registro, pois o mesmo está sendo referenciado em um ou mais registro(s).'
    ];
    echo json_encode($response);
  }else{  
    // Delete.
    $sql = "DELETE FROM tb_marca WHERE id_marca = $id_marca";
    if(pg_query($conn, $sql))
    {      
      $response = [
        'resposta' => '200',
        'mensagem' => 'Registro deletado com sucesso!'     
      ];  
      echo json_encode($response);      
    }else{
      return http_response_code(422);
    }
  }  
}
session_write_close();
?>