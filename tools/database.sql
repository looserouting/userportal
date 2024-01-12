create database bizniss;
grant all privileges on bizniss.* to 'admin'@'localhost' identified by 'admin';
use bizniss;
create table users (id int unsigned auto_increment primary key, mail varchar(64) not null, password varchar(64) not null);
insert into users (mail,password) value ("rob@example.com","biznizz");