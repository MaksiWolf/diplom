create table users
(
	id int unsigned auto_increment
		primary key,
	email varchar(249) not null,
	password varchar(255) collate latin1_general_cs not null,
	username varchar(100) null,
	status tinyint(2) unsigned default 0 not null,
	verified tinyint(1) unsigned default 0 not null,
	resettable tinyint(1) unsigned default 1 not null,
	roles_mask int unsigned default 0 not null,
	registered int unsigned not null,
	last_login int unsigned null,
	force_logout mediumint(7) unsigned default 0 not null,
	constraint email
		unique (email)
)
collate=utf8mb4_unicode_ci;

