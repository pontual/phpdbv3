<?php
require("../../db_cls.php");

$dbh = getdbh();

$sql = "select p.id, p.codigo, p.nome from v3_produto as p"; // inner join v3_produto_categoria as pc on p.id = pc.produto_id inner join v3_categoriadeproduto as c on c.id = pc.categoriadeproduto_id";

foreach ($dbh->query($sql) as $row) {
?>
    <a href="produto_form.php?produto_id=<?= $row['id'] ?>"><?= $row['codigo'] ?></a><br>
<?php 
}
?>
    
