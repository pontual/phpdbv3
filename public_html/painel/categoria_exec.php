<?php
require("../../db_cls.php");

$dbh = getdbh();

$crud_action = $_POST['crud_action'];
$categoria_id = (int) ($_POST['categoria_id'] ?? "0");


if ($crud_action == "create") {    
    echo "Insert";

    $sql = "insert into v3_categoriadeproduto (nome, detalhes, publico) values (:nome, :detalhes, :publico)";
    $sql_arguments = [':nome' => $_POST['nome'],
                      ':detalhes' => $_POST['detalhes'],
                      ':publico' => (int) ($_POST['publico'] ?? "0")];
    
} elseif ($crud_action == "update") {
    echo "Update $categoria_id";

    $sql = "update v3_categoriadeproduto set nome = :nome, detalhes = :detalhes, publico = :publico where id = :id";
    $sql_arguments = [':nome' => $_POST['nome'],
                      ':detalhes' => $_POST['detalhes'],
                      ':publico' => (int) ($_POST['publico'] ?? "0"),
                      ':id' => $categoria_id];
}

$sth = $dbh->prepare($sql);

try {
    $sth->execute($sql_arguments);
} catch (Exception $e) {
    echo $e->getMessage();
}
