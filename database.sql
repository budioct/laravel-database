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

# sql where OR
select * from categories where(id = 'SANDAL' OR id = 'JAKET');

select * from categories where description is null

create table counters
(
    id      varchar(100) not null,
    counter int          not null default 0,
    primary key (id)
) engine = innodb;

describe counters;

insert into counters(id, counter) values('sample', 0);
select * from counters;

create table products
(
    id          varchar(100) not null primary key,
    name        varchar(100) not null,
    description text         null,
    price       int          not null,
    category_id varchar(100) not null,
    created_at  timestamp    not null default current_timestamp,
    constraint fk_category_id foreign key (category_id) references categories (id)
) engine = innodb;

describe products;
select * from products;


drop table products;
drop table categories;
drop table counters;

show tables;

describe categories;
describe products;
describe counters;
