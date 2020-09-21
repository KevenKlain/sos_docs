<?php
require '../model/database.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
  
  $request = json_decode($postdata);  
  if ($request->id_tombo < 0 || $request->id_marca < 0 || trim($request->descricao) == ''){
    return http_response_code(400);
  }

  $response = [];
  $var_id_tombo   = pg_escape_string($conn, (int)$request->id_tombo);
  $var_descricao  = pg_escape_string($conn, $request->descricao); 
  $var_id_marca   = pg_escape_string($conn, $request->id_marca);
  $var_tx_marca   = '';

  if(!empty($var_id_marca) || $var_id_marca > 0){
      $sql_tx_marca = "
                      SELECT tx_marca
                      FROM tb_marca 
                      WHERE id_marca = $var_id_marca
                      ";
      if($result = pg_query($conn, $sql_tx_marca)){
          while($row = pg_fetch_assoc($result)) {
              $var_tx_marca = $row['tx_marca'];
          }
      }              
  }
  $sql = "UPDATE tb_patrimonio 
          SET descricao='{$var_descricao}', id_marca = {$var_id_marca}, tx_marca = '{$var_tx_marca}'
          WHERE id_tombo = {$var_id_tombo}";

  pg_send_query($conn, $sql);
  $res = pg_get_result($conn);  
  //Se for der tudo certo
  $response = [
    'resposta'     => '200',
    'mensagem'     => 'Registro atualizado com sucesso!',
    'id_marca'     => $var_id_tombo,
    'tx_marca'     => $var_descricao
  ];
  echo json_encode($response);
  pg_close();
}
session_write_close();
?>