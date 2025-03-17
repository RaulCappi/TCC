CREATE DATABASE IF NOT EXISTS na_tabela;
USE na_tabela;

CREATE TABLE IF NOT EXISTS `Cidade` (
  `cid_codigo` INT NOT NULL AUTO_INCREMENT,
  `cid_nome` VARCHAR(100) NULL,
  `cid_uf` CHAR(2) NULL,
  PRIMARY KEY (`cid_codigo`)
  );

CREATE TABLE IF NOT EXISTS `Usuario` (
  `usu_codigo` INT NOT NULL AUTO_INCREMENT,
  `usu_nome` VARCHAR(100) NOT NULL,
  `usu_email` VARCHAR(100) NOT NULL,
  `usu_senha` VARCHAR(45) NOT NULL,
  `usu_telefone` INT(11) NOT NULL,
  `created` DATETIME NULL,
  `Cidade_cid_codigo` INT NOT NULL,
  PRIMARY KEY (`usu_codigo`),
  CONSTRAINT `fk_Usuario_Cidade`
    FOREIGN KEY (`Cidade_cid_codigo`)
    REFERENCES `Cidade` (`cid_codigo`)
    );

CREATE TABLE IF NOT EXISTS `Usuario_adm` (
  `adm_codigo` INT NOT NULL AUTO_INCREMENT,
  `adm_nome` VARCHAR(100) NOT NULL,
  `adm_email` VARCHAR(100) NOT NULL,
  `adm_senha` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`adm_codigo`)
    );

CREATE TABLE IF NOT EXISTS `Publicacao` (
  `pub_codigo` INT NOT NULL AUTO_INCREMENT,
  `pub_comentario` LONGTEXT NULL,
  `pub_descricao` LONGTEXT NOT NULL,
  `pub_titulo` VARCHAR(45) NOT NULL,
  `pub_conteudo` BLOB NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  `Usuario_adm_adm_codigo` INT NOT NULL,
  `Usuario_usu_codigo` INT NOT NULL,
  `Cidade_cid_codigo` INT NOT NULL,

  PRIMARY KEY (`pub_codigo`),
  CONSTRAINT `fk_Publicacao_Usuario_adm`
    FOREIGN KEY (`Usuario_adm_adm_codigo`)
    REFERENCES `Usuario_adm` (`adm_codigo`),
  CONSTRAINT `fk_Publicacao_Usuario`
    FOREIGN KEY (`Usuario_usu_codigo`)
    REFERENCES `Usuario` (`usu_codigo`),
  CONSTRAINT `fk_Publicacao_Cidade`
    FOREIGN KEY (`Cidade_cid_codigo`)
    REFERENCES `Cidade` (`cid_codigo`)
    );

CREATE TABLE IF NOT EXISTS `Grupo` (
  `gru_codigo` INT NOT NULL AUTO_INCREMENT,
  `gru_nome` VARCHAR(45) NULL,
  `gru_descricao` VARCHAR(200) NULL,
  `gru_datacriacao` DATE,
  `Usuario_adm_adm_codigo` INT NOT NULL,
  `Cidade_cid_codigo` INT NOT NULL,
  `Usuario_usu_codigo` INT NOT NULL,
  PRIMARY KEY (`gru_codigo`),
  CONSTRAINT `fk_Grupo_Usuario`
    FOREIGN KEY (`Usuario_usu_codigo`)
    REFERENCES `Usuario` (`usu_codigo`),
  CONSTRAINT `fk_Grupo_Usuario_adm`
    FOREIGN KEY (`Usuario_adm_adm_codigo`)
    REFERENCES `Usuario_adm` (`adm_codigo`),
  CONSTRAINT `fk_Grupo_Cidade`
    FOREIGN KEY (`Cidade_cid_codigo`)
    REFERENCES `Cidade` (`cid_codigo`)
);

CREATE TABLE IF NOT EXISTS `Usuario_Grupo` (
  `Usuario_usu_codigo` INT NOT NULL,
  `Cidade_cid_codigo` INT NOT NULL,
  `Grupo_gru_codigo` INT NOT NULL,
  PRIMARY KEY (`Usuario_usu_codigo`, `Cidade_cid_codigo`, `Grupo_gru_codigo`),
  CONSTRAINT `fk_Usuario_Grupo_Usuario1`
    FOREIGN KEY (`Usuario_usu_codigo`)
    REFERENCES `Usuario` (`usu_codigo`),
  CONSTRAINT `fk_Usuario_Grupo_Cidade1`
    FOREIGN KEY (`Cidade_cid_codigo`)
    REFERENCES `Cidade` (`cid_codigo`),
  CONSTRAINT `fk_Usuario_Grupo_Grupo1`
    FOREIGN KEY (`Grupo_gru_codigo`)
    REFERENCES `Grupo` (`gru_codigo`)
);