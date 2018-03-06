ALTER TABLE `fmj_categoria` ADD `genero` VARCHAR(1) NOT NULL DEFAULT 'M' AFTER `idClasse`;
--
-- Estrutura da tabela `fmj_classe_graduacao`
--

DROP TABLE IF EXISTS `fmj_classe_graduacao`;
CREATE TABLE IF NOT EXISTS `fmj_classe_graduacao` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_classe` int(11) NOT NULL,
  `id_graduacao` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_classe` (`id_classe`),
  KEY `fk_graduacao` (`id_graduacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `fmj_classe_graduacao`
--
ALTER TABLE `fmj_classe_graduacao`
  ADD CONSTRAINT `fk_classe_classe_graduacao` FOREIGN KEY (`id_classe`) REFERENCES `fmj_classe` (`id`),
  ADD CONSTRAINT `fk_graduacao_classe_graduacao` FOREIGN KEY (`id_graduacao`) REFERENCES `fmj_graduacao` (`id`);
COMMIT;
