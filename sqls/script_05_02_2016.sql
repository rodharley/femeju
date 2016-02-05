UPDATE `judobrasilia`.`fmj_menu` SET `nome` = 'Geral' WHERE `fmj_menu`.`id` = 40;
UPDATE `judobrasilia`.`fmj_menu` SET `nome` = 'Eventos &Competições' WHERE `fmj_menu`.`id` = 34;
ALTER TABLE `fmj_competicao` ADD `bitCompeticao` TINYINT(1) NOT NULL DEFAULT '0' ;
UPDATE `judobrasilia`.`fmj_menu` SET `nome` = 'Eventos & Competições' WHERE `fmj_menu`.`id` = 39;
ALTER TABLE `fmj_inscricao_competicao` CHANGE `idClasse` `idClasse` INT(11) NULL, CHANGE `idCategoria` `idCategoria` INT(11) NULL;