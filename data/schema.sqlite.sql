CREATE TABLE user_role_linker (
    user_id  INTEGER NOT NULL,
    role_id  VARCHAR(55) NOT NULL,
    PRIMARY KEY(user_id,role_id),
    FOREIGN KEY(user_id) REFERENCES user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);
