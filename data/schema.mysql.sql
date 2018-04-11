CREATE TABLE `user_role_linker` (
    `user_id` BIGINT NOT NULL,
    `role_id` VARCHAR(255) NOT NULL,
    CONSTRAINT `user_role_linker_pk` PRIMARY KEY (`user_id`, `role_id`),
    CONSTRAINT `user_role_linker_fk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX `user_role_linker_ik1` (`user_id`)
);