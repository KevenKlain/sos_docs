<?php
require '../model/database.php';
// Get the posted data.
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata))
{
  // Extract the data.  
  $request = json_decode($postdata);  
  // Validate.
  if ($request->id_marca < 0 || trim($request->tx_marca) == '') {
    return http_response_code(400);
  }
  // Sanitize.
  $response = [];
  $var_id_marca   = pg_escape_string($conn, (int)$request->id_marca);
  $var_tx_marca   = pg_escape_string($conn, $request->tx_marca);  
  // Update.
  $sql = "UPDATE tb_marca SET tx_marca='{$var_tx_marca}' WHERE id_marca = {$var_id_marca}";

  pg_send_query($conn, $sql);
  $res = pg_get_result($conn);  
  if(pg_result_error_field($res, PGSQL_DIAG_SQLSTATE) == '23505'){      
    $response = [
      'resposta' => '400',      
      'mensagem' => 'Já existe um marca cadastrado com a descrição "'. $var_tx_marca .'".'
    ];
    echo json_encode($response);
    //http_response_code(422);
  }else{
    //Se for der tudo certo
    $response = [
      'resposta'     => '200',
      'mensagem'     => 'Registro atualizado com sucesso!',
      'id_marca'     => $var_id_marca,
      'tx_marca'     => $var_tx_marca
    ];
    echo json_encode($response);
  }
  pg_close();
}
session_write_close();
?>