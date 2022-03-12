CREATE TABLE likes (
    user_id bigint NOT NULL,
    post_id bigint NOT NULL,
    created_at DATETIME
) ENGINE=INNODB DEFAULT CHARSET=utf8;

	
ALTER TABLE likes ADD PRIMARY KEY(user_id, post_id);
ALTER TABLE likes ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE likes ADD FOREIGN KEY (post_id) REFERENCES posts(id);