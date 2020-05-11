<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" href="css/bulma.min.css">
    </head>
    <body>        
        <?php
        $crud_action = $_GET['crud_action'] ?? 'create';
            
        ?>
        <div class="container">

            <form method="post" action="categoria_exec.php" class="pure-form pure-form-aligned">
	        <input type="hidden" name="crud_action" value="<?= $crud_action ?>">
                <fieldset>
                    <div class="field">
                        <label class="label">Nome</label>
                        <div class="control">
                            <input class="input" name="nome">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Informações adicionais</label>
                        <div class="control">
                            <textarea class="textrea" name="detalhes" rows="4" cols="50"></textarea>
                        </div>
                    </div>

                    <div class="field">
	                <label class="checkbox">
	                    <input type="checkbox" name="publico" value="1">
	                    Visível no site
	                </label>
	            </div>
	            
	            <input type="submit" class="button is-primary">
                </fieldset>
            </form>
        </div>
    </body>
</html>
