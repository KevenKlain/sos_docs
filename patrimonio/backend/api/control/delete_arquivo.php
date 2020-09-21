<?php
require '../model/database.php';
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, X-Auth-Token, Accept");
header ("Access-Control-Allow-Headers: *");

if($_GET['id_pdf'] != null && $_GET['id_pdf'] > 0){
    $id_pdf = pg_escape_string($conn, TRIM((int)$_GET['id_pdf']));
}else{
    $id_pdf = false;
}

if(!$id_pdf){
  return http_response_code(400);
}

$response = [];
if(!empty($id_pdf) && $id_pdf > 0){
  $sql = "DELETE FROM tb_arquivo WHERE id_pdf = $id_pdf";
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

session_write_close();
?>