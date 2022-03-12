CREATE TABLE comments (
    id bigint AUTO_INCREMENT PRIMARY KEY,
    user_id bigint NOT NULL,
    post_id bigint NOT NULL,
    content text,
    created_at DATETIME,
    modified_at DATETIME,
    deleted_at DATETIME
) ENGINE=INNODB DEFAULT CHARSET=utf8;

ALTER TABLE comments ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE comments ADD FOREIGN KEY (post_id) REFERENCES posts(id);