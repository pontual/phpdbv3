<?php
require("../../db_cls.php");

include("header.php");

$produto_id = (int) ($_GET['produto_id'] ?? '0');
$dbh = getdbh();

if ($produto_id != 0) {
    $crud_action = 'update';
    $sql = "select codigo, nome, detalhes, peso, medidas, caixa, sufixo_jpg, inativo from v3_produto where id = :id";
    $sth = $dbh->prepare($sql);
    $sth->execute([":id" => $produto_id]);

    $row = $sth->fetch();
} else {
    $crud_action = 'create';
    $row = null;
}

$codigo = $row['codigo'] ?? "";
$nome = $row['nome'] ?? "";
$detalhes = $row['detalhes'] ?? "";
$peso = $row['peso'] ?? "";
$medidas = $row['medidas'] ?? "";
$caixa = $row['caixa'] ?? "";
$sufixo_jpg = $row['sufixo_jpg'] ?? "";

// existing categorias
$categorias = [];

?>
<div class="columns">
    <div class="column is-three-quarters">
        <h3 class="title is-3">Produto</h3>
        <form method="post" action="produto_exec.php" class="pure-form pure-form-aligned">
	    <input type="hidden" name="crud_action" value="<?= $crud_action ?>">
	    <input type="hidden" name="produto_id" value="<?= $produto_id ?>">

            <fieldset>
                <h5 class="title is-5">Informações do produto</h5>

                <div class="field">
                    <label class="label">Código</label>
                    <div class="control">
                        <input class="input" name="codigo" value="<?= $codigo ?>">
                    </div>
                </div>

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
                    <label class="label">Peso</label>
                    <div class="control">
                        <input class="input" name="peso" value="<?= $peso ?>">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Medidas</label>
                    <div class="control">
                        <input class="input" name="medidas" value="<?= $medidas ?>">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Qtde. por caixa grande</label>
                    <div class="control">
                        <input class="input" name="caixa" value="<?= $caixa ?>">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Foto</label>
                    <div class="control">
                        <?php
                        if ($sufixo_jpg) {
                        ?>
                            <img src="/fotos/<?= $codigo ?>_<?= $sufixo_jpg ?>_thumb.jpg" alt="foto">
                        <?php
                        }
                        ?>
                        <input class="input" type="file" name="arquivo_foto">
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

                <hr>
                
                <h5 class="title is-5">Categorias do produto</h5>
                <h6 class="title is-6">Importante: se for necessário criar uma categoria nova, esta página precisa ser recarregada</h6>
                <?php
                // check for existing categorias
                if ($crud_action == "update") {
                    $sql = "select categoriadeproduto_id from v3_produto_categoria where produto_id = :produto_id";
                    $sth = $dbh->prepare($sql);
                    $sth->execute([":produto_id" => $produto_id]);
                    foreach ($sth->fetchAll() as $row) {
                        $categorias[] = (int) $row['categoriadeproduto_id'];
                    }
                }
                
                foreach ($dbh->query("select id, nome, inativo from v3_categoriadeproduto order by nome") as $row) {
                ?>
                    <div class="field">
                        <label class="checkbox">
                            <input type="checkbox"
                                   name="produto_cat[]"
                                   value="<?= $row['id'] ?>"
                                   <?= in_array($row['id'], $categorias) ? "checked" : "" ?>
                            >
                            <?= $row['nome'] ?> <?= $row['inativo'] == 1 ? "(inativo)" : "" ?>
                        </label>
                    </div>
                <?php
                }
                ?>
                <br>
                
	        <input type="submit" class="button is-primary">
            </fieldset>
        </form>
    </div>
</div>

<?php
include("footer.php");
