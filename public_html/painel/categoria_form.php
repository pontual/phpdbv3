<?php
require("../../db_cls.php");
include("header.php");

$categoria_id = (int) ($_GET['categoria_id'] ?? '0');

if ($categoria_id != 0) {
    $crud_action = 'update';
    $dbh = getdbh();
    $sql = "select nome, detalhes, inativo from v3_categoriadeproduto where id = :id";
    $sth = $dbh->prepare($sql);
    $sth->execute([":id" => $categoria_id]);

    $row = $sth->fetch();
} else {
    $crud_action = 'create';
    $row = null;
}

$nome = $row['nome'] ?? "";
$detalhes = $row['detalhes'] ?? "";
?>
<div class="container">
    <h3 class="title is-3">Categoria de Produto</h3>
    <form method="post" action="categoria_exec.php" class="pure-form pure-form-aligned">
	<input type="hidden" name="crud_action" value="<?= $crud_action ?>">
	<input type="hidden" name="categoria_id" value="<?= $categoria_id ?>">
        <fieldset>
            <div class="field">
                <label class="label">Nome</label>
                <div class="control">
                    <input class="input" name="nome" value="<?= $nome ?>">
                </div>
            </div>

            <div class="field">
                <label class="label">Informações adicionais</label>
                <div class="control">
                    <textarea class="textrea" name="detalhes" rows="4" cols="50"><?= $detalhes ?></textarea>
                </div>
            </div>

            <div class="field">
	        <label class="checkbox">
	            <input type="checkbox"
                           name="inativo"
                           value="1"
                           <?= $row['inativo'] == 1 ? "checked" : "" ?>
                    >
	            Inativo no site
	        </label>
	    </div>

	    <br>
	    <input type="submit" class="button is-primary">
        </fieldset>
    </form>
</div>

<?php
include("footer.php");
