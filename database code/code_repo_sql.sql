create database repo;
use repo;
create table user(
	user_id integer auto_increment,
	first_name varchar(15),
	last_name varchar(15),
	skill_level smallint,
	designation smallint,
	email varchar(20) ,
	password varchar(40),
	UNIQUE(email),
	primary key(user_id)
);
create table code (
	code_id integer auto_INCREMENT,
	description varchar(100),
	url varchar(50),
	title varchar(50),
	last_updated datetime,
	update_count integer,
	primary key(code_id)
);
create table project(
	project_id integer auto_increment,
	langauge varchar(10),
	title varchar(20),
	description varchar(100),
	url varchar(20),
	primary key(project_id)
);
create table tag(
	project_id integer,
	tag_name varchar(20),
	primary key (project_id, tag_name),
	foreign key(project_id) references project(project_id)	on delete cascade
);
create table shares(
	user_id integer,
	project_id integer,
	sharing_date datetime,
	primary key(user_id, project_id),
	foreign key(user_id)  references user(user_id) on delete cascade ,
	foreign key(project_id)  references project(project_id) on delete cascade	
);
create table comments(
	user_id integer,
	project_id integer,
	comment varchar(100),
	comment_date datetime,
	foreign key(user_id)  references user(user_id) on delete cascade,
	foreign key(project_id)  references project(project_id) on delete cascade
	
);
create table rates(
	user_id integer,
	project_id integer,
	rating smallint,
	foreign key(user_id)  references user(user_id) on delete cascade,
	foreign key(project_id)  references project(project_id) on delete cascade
);
create table contains(
	project_id integer,
	code_id integer,
	primary key(project_id, code_id),
	foreign key(project_id)  references project(project_id) on delete cascade,
	foreign key(code_id)  references code(code_id) on delete cascade
);
create table wishlist(
	user_id integer,
	tag_name varchar(10),
	primary key(user_id, tag_name),
	foreign key(user_id)  references user(user_id) on delete cascade
);