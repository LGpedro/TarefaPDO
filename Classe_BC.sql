DROP DATABASE Classe_BC;

CREATE DATABASE Classe_BC;

USE Classe_BC;

CREATE TABLE alunos(
	id INT PRIMARY KEY NOT NULL auto_increment,
    nome VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL UNIQUE
);

INSERT INTO alunos (nome,email) VALUES ("Carlos","carlos@gmail.com"),("Rock","rock@gmail.com"),("Maria","maria@gmail.com");

SELECT * FROM alunos;