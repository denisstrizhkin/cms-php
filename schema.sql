create table users (
    id       int unsigned auto_increment primary key,
    username varchar(20)  not null unique,
    email    varchar(100) not null unique,
    password varchar(20)  not null,
    active   bool         not null default true,
    added    datetime     not null default current_timestamp
);

create table posts (
    id        int unsigned auto_increment primary key,
    title     varchar(50)  not null,
    content   text         not null,
    author_id int unsigned not null,
    changed   datetime     not null default current_timestamp,
    added     datetime     not null default current_timestamp,

    foreign key (author_id) references users(id) on delete cascade
);

