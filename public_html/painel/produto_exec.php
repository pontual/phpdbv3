<?php
require("../../db_cls.php");
include("header.php");
?>

<h3 class="title is-3">Processamento de Produto</h3>
<pre>

<?php
$dbh = getdbh();

$crud_action = $_POST['crud_action'];
$produto_id = (int) ($_POST['produto_id'] ?? "0");
$produto_cat = $_POST['produto_cat'] ?? null;

$sql_arguments = [':codigo' => $_POST['codigo'],
                  ':nome' => $_POST['nome'],
                  ':detalhes' => $_POST['detalhes'],
                  ':peso' => $_POST['peso'],
                  ':medidas' => $_POST['medidas'],
                  ':caixa' => (int) $_POST['caixa'],
                  ':inativo' => (int) ($_POST['inativo'] ?? "0")];

if ($crud_action == "create") {
    echo "Criando {$_POST['codigo']}\n\n";

    $sql = "insert into v3_produto (codigo, nome, detalhes, peso, medidas, caixa, inativo) values (:codigo, :nome, :detalhes, :peso, :medidas, :caixa, :inativo)";
    
} elseif ($crud_action == "update") {
    echo "Atualizando {$_POST['codigo']}\n\n";

    $sql = "update v3_produto set codigo = :codigo, nome = :nome, detalhes = :detalhes, peso = :peso, medidas = :medidas, caixa = :caixa, inativo = :inativo where id = :id";
    $sql_arguments = array_merge($sql_arguments, [':id' => $produto_id]);
    
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

    $sql = "insert into v3_produto_categoria (produto_id, categoriadeproduto_id) values (:produto_id, :categoria_id)";
    $sth = $dbh->prepare($sql);
    
    foreach ($produto_cat as $cat_id_str) {
        $cat_id = (int) $cat_id_str;
        $sth->execute([":produto_id" => $produto_id,
                       ":categoria_id" => $cat_id]);
    }
    $dbh->commit();
}

echo "Operação concluída.\n";
echo "</pre>";

include("footer.php");
