<?php
require("../../db_cls.php");
include("header.php");

$dbh = getdbh();

$sql = "select p.id, p.codigo, p.nome, p.inativo, GROUP_CONCAT(c.nome order by c.nome separator ', ') as cats
from v3_categoriadeproduto as c
inner join v3_produto_categoria as pc on c.id = pc.categoriadeproduto_id
inner join v3_produto as p on p.id = pc.produto_id group by p.id order by p.inativo, p.codigo";

$uncategorized_sql = "select p.id, p.codigo, p.nome, p.inativo
from v3_produto as p
where p.id not in
(select distinct pc.produto_id from v3_produto_categoria as pc)
order by p.inativo, p.codigo
";

?>

<h3 class="title is-3">Produtos</h3>

<a class="button is-primary" href="produto_form.php">Criar Novo</a>
<br><br>

<?php

$uncategorized = $dbh->query($uncategorized_sql)->fetchAll();

if (count($uncategorized) > 0) {
?>
<h5 class="title is-5">Produtos não categorizados</h5>
<table class="table is-striped">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Inativo?</th>
        </tr>
    </thead>

    <tbody>
        <?php
        foreach ($uncategorized as $row) {
        ?>
            <tr>
                <td><a href="produto_form.php?produto_id=<?= $row['id'] ?>"><?= $row['codigo'] ?></a></td>
                <td><?= $row['nome'] ?></td>
                <td><?= $row['inativo'] == 1 ? "inativo" : "" ?></td>
            </tr>            
        <?php 
        }
        ?>

    </tbody>
</table>

<?php
}
?>

<h5 class="title is-5">Produtos categorizados</h5>
<table class="table is-striped">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Inativo?</th>
            <th>Categorias</th>
        </tr>
    </thead>
    
    <tbody>

        <?php
        foreach ($dbh->query($sql) as $row) {
        ?>
            <tr>
                <td><a href="produto_form.php?produto_id=<?= $row['id'] ?>"><?= $row['codigo'] ?></a></td>
                <td><?= $row['nome'] ?></td>
                <td><?= $row['inativo'] == 1 ? "inativo" : "" ?></td>
                <td><?= $row['cats'] ?></td>
            </tr>            
        <?php 
        }
        ?>

    </tbody>
</table>

<?php
include("footer.php");
