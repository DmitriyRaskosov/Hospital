ALTER TABLE users ADD COLUMN key varchar(255);

ALTER TABLE users ADD COLUMN key_timestamp timestamp without time zone;

CREATE INDEX users_keys_index ON users USING BTREE (key);