ALTER TABLE `fmj_graduacao` ADD `faixa` VARCHAR(50) NULL , ADD `idadeMin` TINYINT NULL , ADD `carenciaMin` TINYINT NULL ;
ALTER TABLE `fmj_graduacao` ADD `imagem` VARCHAR(255) NOT NULL ;
INSERT INTO `fmj_graduacao` (`id`, `descricao`, `faixa`, `idadeMin`, `carenciaMin`, `imagem`) 
VALUES 
(NULL, 'Iniciante', 'Branca', '0', '0', '#ffffff'), 
(NULL, '11º Kiû', 'Branca e Cinza', '4', '3', 'repeating-linear-gradient( 90deg, #999999, #999999 10px, #FFFFFF 10px, #FFFFFF 20px )'), 
(NULL, '10º Kiû', 'Cinza', '4', '3', '#999999'),
(NULL, '9º Kiû', 'Cinza e Azul', '4', '3', 'repeating-linear-gradient( 90deg, #999999, #999999 10px, #0099FF 10px, #0099FF 20px )'), 
(NULL, '8º Kiû', 'Azul', '7', '6', '#0099FF'),
(NULL, '7º Kiû', 'Azul e Amarela', '4', '3', 'repeating-linear-gradient( 90deg, #FFCC33, #FFCC33 10px, #0099FF 10px, #0099FF 20px )'), 
(NULL, '6º Kiû', 'Amarela', '9', '6', '#FFCC33'),
(NULL, '5º Kiû', 'Amarela e Laranja', '4', '3', 'repeating-linear-gradient( 90deg, #FFCC33, #FFCC33 10px, #FF6600 10px, #FF6600 20px )'), 
(NULL, '4º Kiû', 'Laranja', '11', '12', '#FF6600'),
(NULL, '3º Kiû', 'Verde', '13', '12', '#339966'),
(NULL, '2º Kyû', 'Roxa', '13', '12', '#682268'), (NULL, '1º Kiû', 'Marrom', '14', '12', '#683231'),
(NULL, '1º Dan', 'Preta', '16', '12', '#000000'), (NULL, '2º Dan', 'Preta', '20', '48', '#000000'),
(NULL, '3º Dan', 'Preta', '25', '60', '#000000'), (NULL, '4º Dan', 'Preta', '31', '72', '#000000'),
(NULL, '5º Dan', 'Preta', '37', '72', '#000000'), 
(NULL, '6º Dan', 'Vermelha e Branca', '44', '84', 'repeating-linear-gradient( 90deg, #CC0000, #CC0000 10px, #FFFFFF 10px, #FFFFFF 20px )'),
(NULL, '7º Dan', 'Vermelha e Branca', '52', '96', 'repeating-linear-gradient( 90deg, #CC0000, #CC0000 10px, #FFFFFF 10px, #FFFFFF 20px )'),
(NULL, '8º Dan', 'Vermelha e Branca', '60', '96', 'repeating-linear-gradient( 90deg, #CC0000, #CC0000 10px, #FFFFFF 10px, #FFFFFF 20px )'),
(NULL, '9º Dan', 'Vermelha', '69', '108', '#CC0000'),
(NULL, '10º Dan', 'Vermelha', '78', '108', '#CC0000');
update fmj_pessoa set foto = 'pessoa.png' where foto = 'avatar.png';