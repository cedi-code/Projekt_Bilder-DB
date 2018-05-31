DROP DATABASE IF EXISTS `bilderdb`;
CREATE DATABASE IF NOT EXISTS `bilderdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_german2_ci;

USE `bilderdb`;

CREATE TABLE IF NOT EXISTS `USER` (
	id int PRIMARY KEY  AUTO_INCREMENT,
    email varchar(40) UNIQUE ,
    passwd varchar(255),
    nickname varchar(30)

);
CREATE TABLE IF NOT EXISTS `GALERIE` (
	id int PRIMARY KEY  AUTO_INCREMENT,
    gname varchar(30),
    path varchar(255),
    beschreibung TEXT,
    uid int,
    isPublic boolean,
    FOREIGN KEY (uid) REFERENCES `USER`(id)

);
CREATE TABLE IF NOT EXISTS `BILD` (
	id int PRIMARY KEY  AUTO_INCREMENT,
    bname varchar(30),
    bezeichnung TEXT,
    gid int,

    FOREIGN KEY (gid) REFERENCES `GALERIE`(id) ON DELETE CASCADE

);
