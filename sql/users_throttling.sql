create table users_throttling
(
	bucket varchar(44) collate latin1_general_cs not null
		primary key,
	tokens float unsigned not null,
	replenished_at int unsigned not null,
	expires_at int unsigned not null
)
collate=utf8mb4_unicode_ci;

create index expires_at
	on users_throttling (expires_at);

