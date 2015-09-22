CREATE TABLE IF NOT EXISTS `fmj_atleta_graduacao_historico` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idAtleta` bigint(20) NOT NULL,
  `idGraduacao` tinyint(4) NOT NULL,
  `dataMudanca` date NOT NULL,
  `idResponsavel` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idAtleta` (`idAtleta`,`idGraduacao`,`idResponsavel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;