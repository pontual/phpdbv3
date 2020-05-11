<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" href="css/bulma.min.css">
    </head>
    <body>        
        <?php
        require("../../db_cls.php");
        
        $produto_id = (int) ($_GET['produto_id'] ?? '0');
        $dbh = getdbh();

        if ($produto_id != 0) {
            $crud_action = 'update';
            $sql = "select codigo, nome, detalhes, peso, medidas, caixa, inativo from v3_produto where id = :id";
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

        ?>
        <div class="container">
            <h3 class="title is-3">Produto</h3>
            <form method="post" action="produto_exec.php" class="pure-form pure-form-aligned">
	        <input type="hidden" name="crud_action" value="<?= $crud_action ?>">
	        <input type="hidden" name="produto_id" value="<?= $produto_id ?>">
                <fieldset>
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
                    <?php
                    foreach ($dbh->query("select id, nome from v3_categoriadeproduto order by nome") as $row) {
                    ?>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" name="produto_cat[]" value="<?= $row['id'] ?>">
                                <?= $row['nome'] ?>
                            </label>
                        </div>
                    <?php
                    }
                    ?>
	            <input type="submit" class="button is-primary">
                </fieldset>
            </form>
        </div>
    </body>
</html>
