create database bizniss;
grant all privileges on bizniss.* to 'paolo'@'localhost' idetified by 'matrix';
use bizniss;
create table users (id int unsigned auto_increment primary key, mail varchar(64) not null, password varchar(64) not null);
insert into users (mail,password) value ("paolo.compagnini@gmail.com","matrix");