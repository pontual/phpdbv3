<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" href="css/bulma.min.css">
    </head>
    <body>        
        <?php
        require("../../db_cls.php");
        
        $produto_id = (int) ($_GET['produto_id'] ?? '0');

        if ($produto_id != 0) {
            $crud_action = 'update';
            $dbh = getdbh();
            $sql = "select codigo, nome, detalhes, peso, medidas, caixa, publico from v3_produto where id = :id";
            $sth = $dbh->prepare($sql);
            $sth->execute([":id" => produto_id]);

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

            <form method="post" action="produto_exec.php" class="pure-form pure-form-aligned">
	        <input type="hidden" name="crud_action" value="<?= $crud_action ?>">
	        <input type="hidden" name="produto_id" value="<?= $produto_id ?>">
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
                            <textarea class="textrea" name="detalhes" rows="4" cols="50"><?=$detalhes ?></textarea>
                        </div>
                    </div>

                    <div class="field">
	                <label class="checkbox">
	                    <input type="checkbox"
                                   name="publico"
                                   value="1"
                                   <?= $row['publico'] == 1 ? "checked" : "" ?>
                            >
	                    Visível no site
	                </label>
	            </div>
	            
	            <input type="submit" class="button is-primary">
                </fieldset>
            </form>
        </div>
    </body>
</html>
