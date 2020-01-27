BEGIN TRANSACTION;
-- TABLE --
CREATE TABLE IF NOT EXISTS article (
	id          int(10)    primary key not null default 0,
	title       text       not null,
	dir_id      int(10)    not null default 1,
	type        text       not null default "md",
	created     text       not null default "",
	modified    text       not null default "",
	visited     int(10)    not null default 0
);
CREATE TABLE IF NOT EXISTS dir (
	id          int(10)    primary key not null default 0,
	title       text       not null,
	dir_id      int(10)    not null default 1,
	created     text       not null default "",
	modified    text       not null default ""
);
CREATE TABLE IF NOT EXISTS tag (
	name        text       primary key not null,
	visited     int(10)    not null default 0
);
CREATE TABLE IF NOT EXISTS article_tag (
	art_id      int(10)    not null,
	tag_name    text       not null,
	primary key(art_id, tag_name)
);
CREATE TABLE IF NOT EXISTS search (
	content      text      primary key not null,
	count        int(5)    not null default 0
);
CREATE TABLE IF NOT EXISTS CREATE
-- VIEW --
CREATE VIEW IF NOT EXISTS tag_view AS
	SELECT name, visited, COUNT(art_id) AS count
	FROM tag, article_tag
	WHERE name = tag_name
	GROUP BY name;
-- TRIGGER --
CREATE TRIGGER IF NOT EXISTS tri_article_insert
after insert on article
begin
	update article set
		id = 1 + (select MAX(id) from article),
		created = datetime('now'),
		modified = datetime('now')
	where id = new.id;
end;
CREATE TRIGGER IF NOT EXISTS tri_dir_insert
after insert on dir
begin
	update dir set
		id = 1 + (select MAX(id) from dir),
		created = datetime('now'),
		modified = datetime('now')
	where id = new.id;
end;
CREATE TRIGGER IF NOT EXISTS tri_article_update
after update on article
begin
	update article set
		modified = datetime('now')
	where id = new.id;
end;
CREATE TRIGGER IF NOT EXISTS tri_dir_update
after update on dir
begin
	update dir set
		modified = datetime('now')
	where id = new.id;
end;
CREATE TRIGGER IF NOT EXISTS tri_search_insert_or_replace
after insert on search
begin
	update search set
		count = 1 + count
	where content = new.content;
end;
INSERT INTO dir (title, dir_id) VALUES ("root", 0);
COMMIT;
