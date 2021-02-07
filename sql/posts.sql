create table posts
(
	id int(255) auto_increment
		primary key,
	name varchar(255) not null,
	text text not null,
	user_id int(255) not null
)
engine=InnoDB;

