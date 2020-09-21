<?php
require '../model/database.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, X-Auth-Token, Accept");
header ("Access-Control-Allow-Headers: *");

$postdata = file_get_contents("php://input");
$response = [];
if(isset($postdata) && !empty($postdata))
{   
    $request = json_decode($postdata);
    $var_id_marca = 0;
    $array_dados_marca = [];    
    $var_tx_marca = pg_escape_string($conn, $request->tx_marca);

    if(isset($request->id_marca) && $request->id_marca > 0){
        $var_id_marca = pg_escape_string($conn, $request->id_marca);
    }   
    if(trim($request->tx_marca) != ''){
        if($var_id_marca == 0){
            $sql = "INSERT INTO tb_marca(tx_marca) VALUES ('{$var_tx_marca}') RETURNING id_marca, tx_marca";
        }else{
            //Primeiro verifico se o id_marca informado já existe no banco
            $sql_count = "SELECT COUNT(1) as qtd FROM tb_marca WHERE id_marca = $var_id_marca ";
            $row_count = 0;
            if($result_count = pg_query($conn, $sql_count)){
              while($row2 = pg_fetch_assoc($result_count)) {
                $row_count = $row2['qtd'];              
              }
            }
            if($row_count > 0){
                $array_dados_marca = [
                    'resposta'  => '400',
                    'mensagem'  => "Erro ao inserir o registro. Já existe um registro com o código informado.",
                    'id_marca'  => $var_id_marca                         
                ]; 
                echo json_encode($array_dados_marca);
                exit;
            }else{
                $sql = "INSERT INTO tb_marca(id_marca, tx_marca) VALUES ('{$var_id_marca}', '{$var_tx_marca}') RETURNING id_marca, tx_marca";
            }           
        }
        pg_send_query($conn, $sql);
        $resposta = pg_get_result($conn);  
        //Código do erro que viola a constraint do tipo unique
        if(pg_result_error_field($resposta, PGSQL_DIAG_SQLSTATE) == '23505'){           
            $array_dados_marca = [
                'resposta'  => '400',
                'mensagem'  => "Já existe um exercício cadastrado com a descrição $var_tx_marca."                          
            ]; 
            echo json_encode($array_dados_marca, JSON_UNESCAPED_UNICODE);
        }else{
            $array_dados_marca = [
                'resposta'  => '200',
                'mensagem'  => "Registro inserido com sucesso!",                           
            ]; 
            echo json_encode($array_dados_marca, JSON_UNESCAPED_UNICODE);
        }    
    }else{
        $array_dados_marca = [
            'resposta' => '400',
            'mensagem' => 'Descrição da Marca vazio ou não atingiu a quantidade mínima de caracteres!',    
          ];
          echo json_encode($array_dados_marca, JSON_UNESCAPED_UNICODE);
    }    
    session_write_close();
}
?>