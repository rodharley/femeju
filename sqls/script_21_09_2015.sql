ALTER TABLE `fmj_graduacao` ADD `faixa` VARCHAR(50) NULL , ADD `idadeMin` TINYINT NULL , ADD `carenciaMin` TINYINT NULL ;
ALTER TABLE `fmj_graduacao` ADD `imagem` VARCHAR(255) NOT NULL ;
INSERT INTO `fmj_graduacao` (`id`, `descricao`, `faixa`, `idadeMin`, `carenciaMin`, `imagem`) 
VALUES 
(NULL, 'Iniciante', 'Branca', '0', '0', '#ffffff'), 
(NULL, '11� Ki�', 'Branca e Cinza', '4', '3', 'repeating-linear-gradient( 90deg, #999999, #999999 10px, #FFFFFF 10px, #FFFFFF 20px )'), 
(NULL, '10� Ki�', 'Cinza', '4', '3', '#999999'),
(NULL, '9� Ki�', 'Cinza e Azul', '4', '3', 'repeating-linear-gradient( 90deg, #999999, #999999 10px, #0099FF 10px, #0099FF 20px )'), 
(NULL, '8� Ki�', 'Azul', '7', '6', '#0099FF'),
(NULL, '7� Ki�', 'Azul e Amarela', '4', '3', 'repeating-linear-gradient( 90deg, #FFCC33, #FFCC33 10px, #0099FF 10px, #0099FF 20px )'), 
(NULL, '6� Ki�', 'Amarela', '9', '6', '#FFCC33'),
(NULL, '5� Ki�', 'Amarela e Laranja', '4', '3', 'repeating-linear-gradient( 90deg, #FFCC33, #FFCC33 10px, #FF6600 10px, #FF6600 20px )'), 
(NULL, '4� Ki�', 'Laranja', '11', '12', '#FF6600'),
(NULL, '3� Ki�', 'Verde', '13', '12', '#339966'),
(NULL, '2� Ky�', 'Roxa', '13', '12', '#682268'), (NULL, '1� Ki�', 'Marrom', '14', '12', '#683231'),
(NULL, '1� Dan', 'Preta', '16', '12', '#000000'), (NULL, '2� Dan', 'Preta', '20', '48', '#000000'),
(NULL, '3� Dan', 'Preta', '25', '60', '#000000'), (NULL, '4� Dan', 'Preta', '31', '72', '#000000'),
(NULL, '5� Dan', 'Preta', '37', '72', '#000000'), 
(NULL, '6� Dan', 'Vermelha e Branca', '44', '84', 'repeating-linear-gradient( 90deg, #CC0000, #CC0000 10px, #FFFFFF 10px, #FFFFFF 20px )'),
(NULL, '7� Dan', 'Vermelha e Branca', '52', '96', 'repeating-linear-gradient( 90deg, #CC0000, #CC0000 10px, #FFFFFF 10px, #FFFFFF 20px )'),
(NULL, '8� Dan', 'Vermelha e Branca', '60', '96', 'repeating-linear-gradient( 90deg, #CC0000, #CC0000 10px, #FFFFFF 10px, #FFFFFF 20px )'),
(NULL, '9� Dan', 'Vermelha', '69', '108', '#CC0000'),
(NULL, '10� Dan', 'Vermelha', '78', '108', '#CC0000');
update fmj_pessoa set foto = 'pessoa.png' where foto = 'avatar.png';