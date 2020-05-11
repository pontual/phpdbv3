<?php
require("../../db_cls.php");

$crud_action = $_POST['crud_action'];

echo $crud_action;
$dbh = getdbh();

if ($crud_action == "create") {

    $nome = $_POST['nome'];
    $detalhes = $_POST['detalhes'] ?? "";
    $publico = $_POST['publico'] ?? "0";

    $publico = (int) $publico;
    
    echo "Insert $nome, $detalhes";
    $sql = "insert into v3_categoriadeproduto (nome, detalhes, publico) values (:nome, :detalhes, :publico)";
    
    $sth = $dbh->prepare($sql);

    try {
        $sth->execute([':nome' => $nome,
                       ':detalhes' => $detalhes,
                       ':publico' => $publico]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

} elseif ($crud_action == "update") {
    echo "Update nome";
} else {
    echo "Ação desconhecida: $crud_action";
}



