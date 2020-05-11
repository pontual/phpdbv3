<?php

require("db_cls.php");

$pdowrapper = new PdoWrapper();
$dbh = $pdowrapper->getConnection();


echo "<pre>";

$echo_info = "Criando (se nao existe) a tabela ";

// nome
// detalhes
// inativo
echo $echo_info . "v3_categoriadeproduto\n";
$dbh->exec("CREATE TABLE IF NOT EXISTS `v3_categoriadeproduto` (`id` integer AUTO_INCREMENT NOT NULL PRIMARY KEY, `nome` varchar(255) NOT NULL UNIQUE, `detalhes` text, `inativo` bool NOT NULL)");

// Editable

// codigo
// nome
// detalhes
// peso
// medidas
// caixa
// inativo


// Auto-generated

// normalizado
// sufixo_jpg

// cv
// cv_atualizado
// disponivel_ptl
// reservado_ptl
// disponivel_uni
// reservado_uni
echo $echo_info . "v3_produto\n";
$dbh->exec("CREATE TABLE IF NOT EXISTS `v3_produto` (`id` integer AUTO_INCREMENT NOT NULL PRIMARY KEY, `codigo` varchar(63) NOT NULL UNIQUE, `nome` varchar(255) NOT NULL, `normalizado` varchar(255), `detalhes` text, `sufixo_jpg` varchar(31), `peso` varchar(63), `medidas` varchar(63), `cv` varchar(255), `cv_atualizado` datetime(0), `disponivel_ptl` integer, `reservado_ptl` integer, `disponivel_uni` integer, `reservado_uni` integer, `caixa` integer, `inativo` bool NOT NULL)");

// produto_id
// categoriadeproduto_id
echo $echo_info . "v3_produto_categoria\n";
$dbh->exec("CREATE TABLE IF NOT EXISTS `v3_produto_categoria` (`id` integer AUTO_INCREMENT NOT NULL PRIMARY KEY, `produto_id` integer NOT NULL, `categoriadeproduto_id` integer NOT NULL)");

$alter_info = "Alterando tabela ";

echo $alter_info . "v3_produto_categoria\n\n";
$dbh->exec("ALTER TABLE `v3_produto_categoria` ADD CONSTRAINT `v3_produto_cat_uniq` UNIQUE (`produto_id`, `categoriadeproduto_id`)");

$dbh->exec("ALTER TABLE `v3_produto_categoria` ADD CONSTRAINT `v3_produto_cat_produto_id_fk` FOREIGN KEY (`produto_id`) REFERENCES `v3_produto` (`id`)");

$dbh->exec("ALTER TABLE `v3_produto_categoria` ADD CONSTRAINT `v3_produto_cat_categoriadeproduto_fk` FOREIGN KEY (`categoriadeproduto_id`) REFERENCES `v3_categoriadeproduto` (`id`)");

echo "Fim de instalação";
