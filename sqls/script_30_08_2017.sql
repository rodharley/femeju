ALTER TABLE `fmj_competicao` ADD `dataPagamento` DATE NULL AFTER `dataInscricao`, ADD `dataDesconto` DATE NULL AFTER `dataPagamento`, ADD `percentDesconto` INT NULL AFTER `dataDesconto`;
INSERT INTO `fmj_menu` (`id`, `idMenuPai`, `nome`, `ordem`, `url`, `icone`, `visivel`) VALUES (NULL, NULL, 'Despesas', '7', '', 'fa fa-money', '1');
INSERT INTO `fmj_menu` (`id`, `idMenuPai`, `nome`, `ordem`, `url`, `icone`, `visivel`) VALUES (NULL, '46', 'Pesquisar Despesas', '1', 'admin_despesa', '', '1'), (NULL, '46', 'Lançar', '2', 'admin_despesa-lancar', '', '1'), (NULL, '46', 'Relatórios', '2', 'admin_relatorios-despesas', '', '1');
INSERT INTO `fmj_menu` (`id`, `idMenuPai`, `nome`, `ordem`, `url`, `icone`, `visivel`) VALUES (NULL, NULL, 'Diplomas', '1', 'admin_diploma', 'fa-file-text', '1');
INSERT INTO `fmj_menu` (`id`, `idMenuPai`, `nome`, `ordem`, `url`, `icone`, `visivel`) VALUES (NULL, '50', 'Imprimir', '2', 'admin_diploma-imprimir', '', '1');
INSERT INTO `fmj_menu` (`id`, `idMenuPai`, `nome`, `ordem`, `url`, `icone`, `visivel`) VALUES (NULL, '50', 'Cadastro', '1', 'admin_diploma', '', '1');
UPDATE `fmj_menu` SET `ordem` = '9' WHERE `fmj_menu`.`id` = 19;
UPDATE `fmj_menu` SET `ordem` = '10' WHERE `fmj_menu`.`id` = 2;
UPDATE `fmj_menu` SET `ordem` = '11' WHERE `fmj_menu`.`id` = 3;
UPDATE `fmj_menu` SET `ordem` = '12' WHERE `fmj_menu`.`id` = 26;

--
-- Estrutura da tabela `fmj_despesa`
--

CREATE TABLE `fmj_despesa` (
  `id` bigint(20) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `data` date NOT NULL,
  `idGrupo` bigint(20) NOT NULL,
  `valor` decimal(10,0) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fmj_despesa_grupo`
--

CREATE TABLE `fmj_despesa_grupo` (
  `id` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `valor` decimal(10,0) NOT NULL,
  `descricao` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fmj_despesa`
--
ALTER TABLE `fmj_despesa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_descricao` (`descricao`),
  ADD KEY `idUsuario` (`idGrupo`);

--
-- Indexes for table `fmj_despesa_grupo`
--
ALTER TABLE `fmj_despesa_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_despesa_grupo` (`idUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fmj_despesa`
--
ALTER TABLE `fmj_despesa`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fmj_despesa_grupo`
--
ALTER TABLE `fmj_despesa_grupo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `fmj_despesa`
--
ALTER TABLE `fmj_despesa`
  ADD CONSTRAINT `fk_grupo_despesa_despesa` FOREIGN KEY (`idGrupo`) REFERENCES `fmj_despesa_grupo` (`id`);

--
-- Limitadores para a tabela `fmj_despesa_grupo`
--
ALTER TABLE `fmj_despesa_grupo`
  ADD CONSTRAINT `fk_usuario_despesa_chave` FOREIGN KEY (`idUsuario`) REFERENCES `fmj_usuario` (`id`);
  
ALTER TABLE `fmj_despesa_grupo` CHANGE `data_fim` `parcelas` INT NOT NULL;
ALTER TABLE `fmj_despesa` ADD `parcela` INT NOT NULL AFTER `valor`;
ALTER TABLE `fmj_despesa` DROP FOREIGN KEY `fk_grupo_despesa_despesa`; ALTER TABLE `fmj_despesa` ADD CONSTRAINT `fk_grupo_despesa_despesa` FOREIGN KEY (`idGrupo`) REFERENCES `fmj_despesa_grupo`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;