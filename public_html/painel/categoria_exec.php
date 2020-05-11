<?php
require("../../db_cls.php");
include("header.php");
?>

<h3 class="title is-3">Processamento de Categoria</h3>
<pre>

<?php
$dbh = getdbh();

$crud_action = $_POST['crud_action'];
$categoria_id = (int) ($_POST['categoria_id'] ?? "0");

$sql_arguments = [':nome' => $_POST['nome'],
                  ':detalhes' => $_POST['detalhes'],
                  ':inativo' => (int) ($_POST['inativo'] ?? "0")];

if ($crud_action == "create") {    
    echo "Criando {$_POST['nome']}\n\n";

    $sql = "insert into v3_categoriadeproduto (nome, detalhes, inativo) values (:nome, :detalhes, :inativo)";
    
} elseif ($crud_action == "update") {
    echo "Atualizando {$_POST['nome']}\n\n";

    $sql = "update v3_categoriadeproduto set nome = :nome, detalhes = :detalhes, inativo = :inativo where id = :id";
    $sql_arguments = array_merge($sql_arguments, [':id' => $categoria_id]);
}

$sth = $dbh->prepare($sql);

try {
    $sth->execute($sql_arguments);
} catch (Exception $e) {
    echo $e->getMessage();
}

echo "Operação concluída.\n";
echo "</pre>";

include("footer.php");
