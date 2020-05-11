<?php
require("../../db_cls.php");
include("header.php");

$dbh = getdbh();

$sql = "select p.id, p.codigo, p.nome, GROUP_CONCAT(c.nome order by c.nome separator ', ') as cats from v3_categoriadeproduto as c inner join v3_produto_categoria as pc on c.id = pc.categoriadeproduto_id inner join v3_produto as p on p.id = pc.produto_id group by p.id order by p.id";
?>

<h3 class="title is-3">Produtos</h3>

<a class="button is-primary" href="produto_form.php">Criar Novo</a>
<br><br>
<table class="table is-striped">
    <thead>
        <tr>
            <th>Código</th>
            <th>Categorias</th>
        </tr>
    </thead>
    
    <tbody>

        <?php
        foreach ($dbh->query($sql) as $row) {
        ?>
            <tr>
                <td><a href="produto_form.php?produto_id=<?= $row['id'] ?>"><?= $row['codigo'] ?></a></td>
                <td><?= $row['cats'] ?></td>
            </tr>            
        <?php 
        }
        ?>

    </tbody>
</table>

<?php
include("footer.php");
