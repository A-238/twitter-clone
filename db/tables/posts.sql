CREATE TABLE posts (
    id bigint AUTO_INCREMENT PRIMARY KEY,
    user_id bigint NOT NULL,
    content text,
    created_at DATETIME,
    modified_at DATETIME,
    deleted_at DATETIME
) ENGINE=INNODB DEFAULT CHARSET=utf8;

ALTER TABLE posts ADD FOREIGN KEY (user_id) REFERENCES users(id);