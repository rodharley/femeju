ALTER TABLE `fmj_pagamento` ADD `telefone` VARCHAR(30) NOT NULL, ADD `gn_url_boleto` VARCHAR(300) NOT NULL, ADD `gn_status` VARCHAR(40) NOT NULL, ADD `gn_chargeid` INT NULL AFTER `forma`;
ALTER TABLE `fmj_log` CHANGE `texto` `texto` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `fmj_pagamento` CHANGE `numeroFebraban` `numeroFebraban` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;