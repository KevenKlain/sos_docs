<?php
require '../model/database.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, X-Auth-Token, Accept");
header ("Access-Control-Allow-Headers: *");

$postdata = file_get_contents("php://input");
$response = [];
if(isset($postdata) && !empty($postdata)){   
    $request = json_decode($postdata);
    $array_dados_patrimonio = [];
    $var_id_marca = pg_escape_string($conn, $request->id_marca);
    $var_descricao = pg_escape_string($conn, $request->descricao);
    $var_tx_marca = '';

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
    if(trim($request->descricao) != ''){
        $sql = "INSERT INTO tb_patrimonio(descricao, id_marca, tx_marca) VALUES ('{$var_descricao}', {$var_id_marca}, '{$var_tx_marca}') RETURNING id_tombo, descricao, id_marca, tx_marca";
        $result = pg_query($sql);        
        if($result){
            $row = pg_fetch_row($result);            
            $array_dados_patrimonio = [
                'resposta'  => '200',
                'mensagem'  => "Patrimônio inserido com sucesso!"                     
            ]; 
            echo json_encode($array_dados_patrimonio, JSON_UNESCAPED_UNICODE);
        }else{
            $array_dados_patrimonio = [
                'resposta'  => '400',
                'mensagem'  => "Erro ao inserir o registro."                        
            ]; 
            echo json_encode($array_dados_marca, JSON_UNESCAPED_UNICODE);
        }       
    }else{
        $array_dados_patrimonio = [
            'resposta' => '400',
            'mensagem' => 'Descrição do Patrimônio não pode estar vazio!'    
          ];
        echo json_encode($array_dados_patrimonio, JSON_UNESCAPED_UNICODE);
    }    
    session_write_close();
}
?>