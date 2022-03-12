CREATE TABLE relationships (
    user_id bigint NOT NULL,
    follow_id bigint NOT NULL,
    created_at DATETIME
) ENGINE=INNODB DEFAULT CHARSET=utf8;

	
ALTER TABLE relationships ADD PRIMARY KEY(user_id, follow_id);
ALTER TABLE relationships ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE relationships ADD FOREIGN KEY (follow_id) REFERENCES users(id);