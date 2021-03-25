CREATE USER IF NOT EXISTS 'fldoucet'@'%' IDENTIFIED BY 'fldoucet';
DROP DATABASE IF EXISTS db_camagru;
CREATE DATABASE IF NOT EXISTS db_camagru;
GRANT ALL PRIVILEGES ON db_camagru.* TO 'fldoucet'@'%';
USE db_camagru;

CREATE TABLE Users
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(30) NOT NULL,
	email VARCHAR(30) NOT NULL,
	password VARCHAR(128) NOT NULL,
	subscribed BOOL NOT NULL,
	activated BOOL NOT NULL,
	notification INT(6) NOT NULL,
	publication INT(6) NOT NULL,
	followers INT(6) NOT NULL,
	followed INT(6) NOT NULL,
	avatar TEXT NOT NULL,
	token VARCHAR(32),
	reg_date TIMESTAMP
);
CREATE TABLE Links
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	followed VARCHAR(30) NOT NULL,
	follower VARCHAR(30) NOT NULL
);
CREATE TABLE Chat
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	id_1 VARCHAR(30) NOT NULL,
	id_2 VARCHAR(30) NOT NULL,
	from_id VARCHAR(30) NOT NULL,
	message TEXT NOT NULL,
	msg_date TIMESTAMP
);
CREATE TABLE Pictures
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	from_id INT(6) NOT NULL,
	name TEXT NOT NULL,
	upload_date TIMESTAMP
);
CREATE TABLE Likes
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	picture_id INT(6) NOT NULL,
	liked_from VARCHAR(30) NOT NULL,
	upload_date TIMESTAMP
);
CREATE TABLE Comments
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	img_id INT(6) NOT NULL,
	from_id INT(6) NOT NULL,
	comments TEXT NOT NULL,
	comment_date TIMESTAMP
);
CREATE TABLE Notification
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	for_user VARCHAR(30) NOT NULL,
	notification TEXT NOT NULL,
	seen INT(6) NOT NULL,
	not_date TIMESTAMP
);
INSERT INTO Users (username, email, password, subscribed, activated, notification, publication, followers, followed, avatar) VALUES ('demo1', 'demo@demo.com', 'demo', '1', '0', '0', '4', '0', '0', 'public/img/img_avatar.png');
INSERT INTO Users (username, email, password, subscribed, activated, notification, publication, followers, followed, avatar) VALUES ('demo2', 'demo@demo.com', 'demo', '1', '0', '0', '1', '0', '0', 'public/img/img_avatar2.png');
INSERT INTO Users (username, email, password, subscribed, activated, notification, publication, followers, followed, avatar) VALUES ('fldoucet', 'fldoucet@student.42.fr', 'theworld', '1', '0', '0', '0', '0', '0', 'public/img/fldoucet.jpg');
INSERT INTO Pictures (from_id, name) VALUES ('1', 'public/img/users/demo1/1.jpg');
INSERT INTO Pictures (from_id, name) VALUES ('2', 'public/img/users/demo2/1.jpg');
INSERT INTO Pictures (from_id, name) VALUES ('1', 'public/img/users/demo1/2.jpg');
INSERT INTO Pictures (from_id, name) VALUES ('1', 'public/img/users/demo1/3.jpg');
INSERT INTO Pictures (from_id, name) VALUES ('1', 'public/img/users/demo1/4.jpg');
INSERT INTO Comments (img_id, from_id, comments) VALUES ('1', '2', 'nice one !');
INSERT INTO Comments (img_id, from_id, comments) VALUES ('2', '1', 'wow !');

