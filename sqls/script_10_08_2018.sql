UPDATE `fmj_configuracoes` SET `descricao` = 'Taxa Gerência Net', `valor` = '0,00' WHERE `fmj_configuracoes`.`id` = 12;
UPDATE `fmj_configuracoes` SET `descricao` = 'Taxa Paypal', `valor` = '0,00' WHERE `fmj_configuracoes`.`id` = 13;
DELETE FROM `fmj_configuracoes` WHERE `fmj_configuracoes`.`id` = 14;
DELETE FROM `fmj_configuracoes` WHERE `fmj_configuracoes`.`id` = 15;
DELETE FROM `fmj_configuracoes` WHERE `fmj_configuracoes`.`id` = 16;
DELETE FROM `fmj_configuracoes` WHERE `fmj_configuracoes`.`id` = 17;
UPDATE `fmj_configuracoes` SET `id` = '14' WHERE `fmj_configuracoes`.`id` = 18;