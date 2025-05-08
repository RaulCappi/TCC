CREATE DATABASE IF NOT EXISTS na_tabela;
USE na_tabela;


CREATE TABLE IF NOT EXISTS `Usuario` (
  `usu_codigo` INT NOT NULL AUTO_INCREMENT,
  `usu_nome` VARCHAR(255) NOT NULL,
  `usu_email` VARCHAR(255) NOT NULL,
  `usu_senha` VARCHAR(255) NOT NULL,
  `usu_telefone` INT(11) NULL,
  `usu_foto` VARCHAR(255) NULL,
  `usu_estado` VARCHAR(255) NOT NULL,
  `usu_cidade` VARCHAR(255) NULL,
  `usu_publicar` TINYINT NULL,
  `usu_ativo` TINYINT NULL,
  `created` DATE NULL,
  PRIMARY KEY (`usu_codigo`)
    );

    INSERT INTO `Usuario` (usu_nome, usu_email, usu_senha, usu_estado, usu_publicar, usu_ativo) VALUES ('ArielLuisPabloRaul', 'email@email', '$2y$10$pmoehXGxinyYLKt67kQPiO0okbs0/ffoHSAxd6f8bbJU7ta8eZ1iK', 'SP', 1, 1); /*1234*/

CREATE TABLE IF NOT EXISTS `Adm` (
  `adm_codigo` INT NOT NULL AUTO_INCREMENT,
  `adm_nome` VARCHAR(255) NOT NULL,
  `adm_senha` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`adm_codigo`)
    );

INSERT INTO `Adm` (adm_nome, adm_senha) VALUES ('ArielLuisPabloRaul', '$2y$10$pmoehXGxinyYLKt67kQPiO0okbs0/ffoHSAxd6f8bbJU7ta8eZ1iK'); /*1234*/

CREATE TABLE IF NOT EXISTS `Publicacao` (
  `pub_codigo` INT NOT NULL AUTO_INCREMENT,
  `pub_descricao` TEXT(500) NOT NULL,
  `pub_titulo` VARCHAR(255) NOT NULL,
  `pub_conteudo` VARCHAR(255) NULL,
  `created` DATE NULL,
  `hora` TIME NULL,
  `modified` DATE NULL,
  `hora_modif` TIME NULL,
  `Usuario_usu_codigo` INT NOT NULL,

  PRIMARY KEY (`pub_codigo`),
  CONSTRAINT `fk_Publicacao_Usuario`
    FOREIGN KEY (`Usuario_usu_codigo`)
    REFERENCES `Usuario` (`usu_codigo`)
    );

CREATE TABLE IF NOT EXISTS `Time` (
  `tim_codigo` INT NOT NULL AUTO_INCREMENT,
  `tim_nome` VARCHAR(255) NOT NULL,
  `tim_estado` VARCHAR(255) NOT NULL,
  `tim_cidade` VARCHAR(255) NOT NULL,

  PRIMARY KEY (`tim_codigo`)

);

CREATE TABLE IF NOT EXISTS `Atleta` (
  `atl_codigo` INT NOT NULL AUTO_INCREMENT,
  `atl_nome` VARCHAR(255) NOT NULL,
  `atl_idade` INT(100) NULL,
  `atl_foto` VARCHAR(255) NULL,
  `atl_cidade` VARCHAR(255) NULL,
  PRIMARY KEY (`atl_codigo`)
);