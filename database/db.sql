SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tasks
-- ----------------------------
DROP TABLE IF EXISTS `starship`;
CREATE TABLE teachaway.starship (
	name varchar(80) NOT NULL,
	model varchar(100) NOT NULL,
	manufacturer varchar(200) NOT NULL,
	cost_in_credits varchar(15) NOT NULL,
	`length` varchar(7) NOT NULL,
	max_atmosphering_speed varchar(10) NOT NULL,
	crew varchar(4) NOT NULL,
	passengers varchar(4) NOT NULL,
	cargo_capacity varchar(7) NOT NULL,
	consumables varchar(15) NOT NULL,
	hyperdrive_rating varchar(5) NOT NULL,
	mglt varchar(7) NOT NULL,
	starship_class varchar(100) NOT NULL,
	pilots TEXT NULL,
	films TEXT NULL,
	created TIMESTAMP NOT NULL,
	edited TIMESTAMP NOT NULL,
	url varchar(100) NOT NULL,
	count SMALLINT DEFAULT 0 NOT NULL
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;



SET FOREIGN_KEY_CHECKS = 1;