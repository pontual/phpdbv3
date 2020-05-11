<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" href="css/bulma.min.css">
    </head>
    <body>        
        <?php
        require("../../db_cls.php");
        
        $categoria_id = (int) ($_GET['categoria_id'] ?? '0');

        if ($categoria_id != 0) {
            $crud_action = 'update';
            $dbh = getdbh();
            $sql = "select nome, detalhes, publico from v3_categoriadeproduto where id = :id";
            $sth = $dbh->prepare($sql);
            $sth->execute([":id" => $categoria_id]);

            $row = $sth->fetch();
            $nome = $row['nome'];
            $detalhes = $row['detalhes'];
        } else {
            $crud_action = 'create';
            $nome = "";
            $detalhes = "";
        }
            

        ?>
        <div class="container">

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
