create table reviews
(
	id int(255) auto_increment
		primary key,
	text varchar(255) not null,
	user_id int(255) not null,
	post_id int(255) not null
)
engine=InnoDB;

