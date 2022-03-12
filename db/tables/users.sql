CREATE TABLE users (
    id bigint AUTO_INCREMENT PRIMARY KEY, 
    email varchar(255) UNIQUE NOT NULL,
    password varchar(255) NOT NULL,
    name varchar(30), 
    created_at DATETIME,
    modified_at DATETIME
) ENGINE=INNODB DEFAULT CHARSET=utf8;