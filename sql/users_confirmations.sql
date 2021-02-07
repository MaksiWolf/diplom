create table users_confirmations
(
	id int unsigned auto_increment
		primary key,
	user_id int unsigned not null,
	email varchar(249) not null,
	selector varchar(16) collate latin1_general_cs not null,
	token varchar(255) collate latin1_general_cs not null,
	expires int unsigned not null,
	constraint selector
		unique (selector)
)
collate=utf8mb4_unicode_ci;

create index email_expires
	on users_confirmations (email, expires);

create index user_id
	on users_confirmations (user_id);

