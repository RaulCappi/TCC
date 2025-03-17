/*CREATE USER 'adm'@'%' IDENTIFIED BY '123';
GRANT ALL PRIVILEGES ON *.* TO 'adm'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;*/

CREATE DATABASE IF NOT EXISTS na_tabela;
USE na_tabela;


CREATE TABLE IF NOT EXISTS `Usuario` (
  `usu_codigo` INT NOT NULL AUTO_INCREMENT,
  `usu_nome` VARCHAR(255) NOT NULL,
  `usu_email` VARCHAR(255) NOT NULL,
  `usu_senha` VARCHAR(255) NOT NULL,
  `usu_telefone` INT(11) NOT NULL,
  `usu_cidade` VARCHAR(255) NOT NULL,
  `usu_publicar` TINYINT(0),
  `created` DATE NULL,
  PRIMARY KEY (`usu_codigo`)
    );

/*CREATE TABLE IF NOT EXISTS `Usuario_adm` (
  `adm_codigo` INT NOT NULL AUTO_INCREMENT,
  `adm_nome` VARCHAR(100) NOT NULL,
  `adm_email` VARCHAR(100) NOT NULL,
  `adm_senha` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`adm_codigo`)
    );*/

CREATE TABLE IF NOT EXISTS `Publicacao` (
  `pub_codigo` INT NOT NULL AUTO_INCREMENT,
  /*`pub_comentario` LONGTEXT NULL,*/
  `pub_descricao` TEXT(500) NOT NULL,
  `pub_titulo` VARCHAR(200) NOT NULL,
  `pub_conteudo` VARCHAR(200) NULL,
  `created` DATE NULL,
  `hora` TIME NULL,
  `modified` DATETIME NULL,
  /*`Usuario_adm_adm_codigo` INT NOT NULL,*/
  `Usuario_usu_codigo` INT NOT NULL,

  PRIMARY KEY (`pub_codigo`),
  /*CONSTRAINT `fk_Publicacao_Usuario_adm`
    FOREIGN KEY (`Usuario_adm_adm_codigo`)
    REFERENCES `Usuario_adm` (`adm_codigo`),*/
  CONSTRAINT `fk_Publicacao_Usuario`
    FOREIGN KEY (`Usuario_usu_codigo`)
    REFERENCES `Usuario` (`usu_codigo`)
    );

CREATE TABLE IF NOT EXISTS `Grupo` (
  `gru_codigo` INT NOT NULL AUTO_INCREMENT,
  `gru_nome` VARCHAR(45) NULL,
  `gru_descricao` VARCHAR(200) NULL,
  `gru_datacriacao` DATE,
  `Usuario_adm_adm_codigo` INT NOT NULL,
  `Usuario_usu_codigo` INT NOT NULL,
  PRIMARY KEY (`gru_codigo`),
  CONSTRAINT `fk_Grupo_Usuario`
    FOREIGN KEY (`Usuario_usu_codigo`)
    REFERENCES `Usuario` (`usu_codigo`)
  /*CONSTRAINT `fk_Grupo_Usuario_adm`
    FOREIGN KEY (`Usuario_adm_adm_codigo`)
    REFERENCES `Usuario_adm` (`adm_codigo`)
);*/);

CREATE TABLE IF NOT EXISTS `Usuario_Grupo` (
  `Usuario_usu_codigo` INT NOT NULL,
  `Grupo_gru_codigo` INT NOT NULL,
  PRIMARY KEY (`Usuario_usu_codigo`, `Grupo_gru_codigo`),
  CONSTRAINT `fk_Usuario_Grupo_Usuario1`
    FOREIGN KEY (`Usuario_usu_codigo`)
    REFERENCES `Usuario` (`usu_codigo`),
  CONSTRAINT `fk_Usuario_Grupo_Grupo1`
    FOREIGN KEY (`Grupo_gru_codigo`)
    REFERENCES `Grupo` (`gru_codigo`)
);