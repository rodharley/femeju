ALTER TABLE `fmj_usuario` ADD `responsavel` TINYINT NOT NULL DEFAULT '0' AFTER `id`;
UPDATE `fmj_perfil` SET `nome` = 'EXTERNO' WHERE `fmj_perfil`.`id` = 3;
UPDATE fmj_usuario set responsavel = 1 where idPerfil = 3;