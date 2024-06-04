show databases;

use belajar_laravel_database;

create table categories
(
    id          varchar(100) not null,
    name        varchar(100) not null,
    description text,
    created_at  timestamp,
    primary key (id)
) engine = innodb;

show tables;
describe categories;
