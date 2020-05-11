<?php
require("../../db_cls.php");

$dbh = getdbh();

$sql = "select p.id, p.codigo, p.nome, GROUP_CONCAT(c.nome order by c.nome separator ', ') as cats from v3_categoriadeproduto as c inner join v3_produto_categoria as pc on c.id = pc.categoriadeproduto_id inner join v3_produto as p on p.id = pc.produto_id group by p.id order by p.id";

foreach ($dbh->query($sql) as $row) {
?>
    <a href="produto_form.php?produto_id=<?= $row['id'] ?>"><?= $row['codigo'] ?></a> <?= $row['cats'] ?><br>
<?php 
}
?>
    
