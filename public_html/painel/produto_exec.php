<?php
require("../../db_cls.php");

$dbh = getdbh();

$crud_action = $_POST['crud_action'];
$produto_id = (int) ($_POST['produto_id'] ?? "0");
$produto_cat = $_POST['produto_cat'] ?? null;

if ($crud_action == "create") {
    echo "Insert";

    $sql = "insert into v3_produto (codigo, nome, detalhes, peso, medidas, caixa, inativo) values (:codigo, :nome, :detalhes, :peso, :medidas, :caixa, :inativo)";
    $sql_arguments = [':codigo' => $_POST['codigo'],
                      ':nome' => $_POST['nome'],
                      ':detalhes' => $_POST['detalhes'],
                      ':peso' => $_POST['peso'],
                      ':medidas' => $_POST['medidas'],
                      ':caixa' => (int) $_POST['caixa'],
                      ':inativo' => (int) ($_POST['inativo'] ?? "0")];
    
} elseif ($crud_action == "update") {
    echo "Update $produto_id";

    $sql = "update v3_produto set codigo = :codigo, nome = :nome, detalhes = :detalhes, peso = :peso, medidas = :medidas, caixa = :caixa, inativo = :inativo where id = :id";
    $sql_arguments = [':codigo' => $_POST['codigo'],
                      ':nome' => $_POST['nome'],
                      ':detalhes' => $_POST['detalhes'],
                      ':peso' => $_POST['peso'],
                      ':medidas' => $_POST['medidas'],
                      ':caixa' => (int) $_POST['caixa'],
                      ':inativo' => (int) ($_POST['inativo'] ?? "0"),
                      ':id' => $produto_id];
    
    // delete from v3_produto_categoria
    try {
        $sth = $dbh->prepare("delete from v3_produto_categoria where produto_id = :produto_id");
        $sth->execute([":produto_id" => $produto_id]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

// run action on produto
$sth = $dbh->prepare($sql);

try {
    $sth->execute($sql_arguments);
} catch (Exception $e) {
    echo $e->getMessage();
}

// add to v3_produto_categoria
if ($produto_cat) {
    $dbh->beginTransaction();
    
    foreach ($produto_cat as $id_str) {
        $id = (int) $id_str;
        echo $id;
    }
    $dbh->commit();
}

