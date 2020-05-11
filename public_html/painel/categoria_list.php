<?php
require("../../db_cls.php");
include("header.php");

$dbh = getdbh();

$sql = "select id, nome, inativo from v3_categoriadeproduto order by inativo, nome";
?>

<h3 class="title is-3">Categorias</h3>

<a class="button is-primary" href="categoria_form.php">Criar Novo</a>
<br><br>
<table class="table is-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Inativo?</th>
        </tr>
    </thead>
    
    <tbody>
        <?php
        foreach ($dbh->query($sql) as $row) {
        ?>
            <tr>
                <td><a href="categoria_form.php?categoria_id=<?= $row['id'] ?>"><?= $row['nome'] ?></a></td>
                <td><?= $row['inativo'] == 1 ? "inativo" : "" ?></a></td>
            </tr>            
        <?php 
        }
        ?>

    </tbody>
</table>

<?php
include("footer.php");
