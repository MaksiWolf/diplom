create table users_remembered
(
	id bigint unsigned auto_increment
		primary key,
	user int unsigned not null,
	selector varchar(24) collate latin1_general_cs not null,
	token varchar(255) collate latin1_general_cs not null,
	expires int unsigned not null,
	constraint selector
		unique (selector)
)
collate=utf8mb4_unicode_ci;

create index user
	on users_remembered (user);

