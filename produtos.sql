-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 22/11/2024 às 08:39
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `produtos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `preco` float NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome`, `descricao`, `preco`, `imagem`) VALUES
(1, 'Arroz', 'Arroz branco tipo 1, pacote de 1kg', 5.99, 'img/produtos/arroz.jpg'),
(2, 'Feijão', 'Feijão carioca, pacote de 1kg', 6.49, 'img/produtos/feijao.jpg'),
(3, 'Macarrão', 'Macarrão espaguete, pacote de 500g', 3.29, 'img/produtos/macarrao.jpg'),
(4, 'Óleo de soja', 'Óleo de soja refinado, garrafa de 900ml', 7.89, 'img/produtos/oleo.jpg'),
(5, 'Açúcar', 'Açúcar refinado, pacote de 1kg', 3.59, 'img/produtos/acucar.jpg'),
(6, 'Sal', 'Sal refinado, pacote de 1kg', 1.99, 'img/produtos/sal.jpg'),
(7, 'Leite', 'Leite integral, caixa de 1 litro', 4.39, 'img/produtos/leite.jpg'),
(8, 'Café', 'Café torrado e moído, pacote de 500g', 9.99, 'img/produtos/cafe.jpg'),
(9, 'Farinha de trigo', 'Farinha de trigo, pacote de 1kg', 4.19, 'img/produtos/farinha.jpg'),
(10, 'Achocolatado', 'Achocolatado em pó, lata de 400g', 6.89, 'img/produtos/achocolatado.jpg'),
(11, 'Biscoito recheado', 'Biscoito de chocolate com recheio de baunilha, pacote de 140g', 2.89, 'img/produtos/biscoito.jpg'),
(12, 'Refrigerante', 'Refrigerante de cola, garrafa de 2 litros', 7.49, 'img/produtos/refrigerante.jpg'),
(13, 'Detergente', 'Detergente líquido para louça, frasco de 500ml', 2.99, 'img/produtos/detergente.jpg'),
(14, 'Sabão em pó', 'Sabão em pó para roupas, pacote de 1kg', 10.89, 'img/produtos/sabao.jpg'),
(15, 'Amaciante', 'Amaciante de roupas, frasco de 2 litros', 8.99, 'img/produtos/amaciante.jpg'),
(16, 'Desodorante', 'Desodorante aerosol, frasco de 150ml', 12.49, 'img/produtos/desodorante.jpg'),
(17, 'Papel higiênico', 'Papel higiênico, pacote com 4 rolos', 5.79, 'img/produtos/papel.jpg'),
(18, 'Shampoo', 'Shampoo para cabelos normais, frasco de 350ml', 15.39, 'img/produtos/shampoo.jpg'),
(19, 'Condicionador', 'Condicionador para cabelos normais, frasco de 350ml', 16.29, 'img/produtos/condicionador.jpg'),
(20, 'Creme dental', 'Creme dental com flúor, tubo de 90g', 4.89, 'img/produtos/creme.jpg'),
(21, 'Manteiga 200g', 'Manteiga sem sal, ideal para pães e receitas.', 12.49, 'img/produtos/manteiga.jpg'),
(22, 'Queijo Mussarela 500g', 'Queijo fatiado ideal para lanches e pizzas.', 22.99, 'img/produtos/queijo_mussarela.jpg'),
(23, 'Presunto Fatiado 200g', 'Presunto magro fatiado para sanduíches.', 8.99, 'img/produtos/presunto.jpg'),
(24, 'Iogurte Natural 170g', 'Iogurte natural sem adição de açúcares.', 3.49, 'img/produtos/iogurte.jpg'),
(25, 'Batata Chips 100g', 'Batata frita crocante com sal.', 5.99, 'img/produtos/batata_chips.jpg'),
(26, 'Frango Congelado 1kg', 'Frango congelado sem tempero.', 18.99, 'img/produtos/frango_congelado.jpg'),
(27, 'Peito de Peru Fatiado 200g', 'Peito de peru defumado para lanches.', 10.99, 'img/produtos/peito_peru.jpg'),
(28, 'Cenoura 1kg', 'Cenoura fresca, rica em vitamina A.', 4.29, 'img/produtos/cenoura.jpg'),
(29, 'Alface Crespa', 'Alface crespa fresca e crocante.', 3.79, 'img/produtos/alface.jpg'),
(30, 'Tomate 1kg', 'Tomates frescos e suculentos.', 6.99, 'img/produtos/tomate.jpg'),
(31, 'Cebola 1kg', 'Cebolas frescas, ideais para temperos.', 4.49, 'img/produtos/cebola.jpg'),
(32, 'Alho 200g', 'Alho fresco, perfeito para temperos.', 6.79, 'img/produtos/alho.jpg'),
(33, 'Filé de Peixe Congelado 1kg', 'Filé de peixe empanado.', 25.99, 'img/produtos/file_peixe.jpg'),
(34, 'Salsicha 500g', 'Salsicha para hot dogs e receitas.', 7.49, 'img/produtos/salsicha.jpg'),
(35, 'Hambúrguer Congelado 500g', 'Hambúrgueres prontos para assar.', 15.99, 'img/produtos/hamburguer.jpg'),
(36, 'Pizza Congelada 400g', 'Pizza sabor calabresa.', 12.99, 'img/produtos/pizza.jpg'),
(37, 'Sorvete 2L', 'Sorvete sabor chocolate.', 19.99, 'img/produtos/sorvete.jpg'),
(38, 'Bolo de Cenoura 300g', 'Bolo pronto com cobertura de chocolate.', 9.99, 'img/produtos/bolo_cenoura.jpg'),
(39, 'Chá de Camomila 10 Saquinhos', 'Chá calmante de camomila.', 4.99, 'img/produtos/cha_camomila.jpg'),
(40, 'Bolacha Água e Sal 400g', 'Bolacha leve e crocante.', 3.99, 'img/produtos/bolacha.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
