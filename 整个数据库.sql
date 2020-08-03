CREATE TABLE IF NOT EXISTS `article` (
	`id` INTEGER NOT NULL,
	`title` TEXT NOT NULL DEFAULT "",
	`markdown` TEXT NOT NULL DEFAULT "",
	`html` TEXT NOT NULL DEFAULT "",
	`contentsJ` TEXT NOT NULL DEFAULT "",
	`commentJ` TEXT NOT NULL DEFAULT "",
	`drewT` TEXT NOT NULL DEFAULT "",
	`tagJ` TEXT NOT NULL DEFAULT "",
	PRIMARY KEY(`id` AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS `dir` (
	`id` INTEGER NOT NULL,
	`name` TEXT NOT NULL DEFAULT "",
	PRIMARY KEY(`id` AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS `layer` (
	`id` INTEGER NOT NULL,
	`type` INTEGER NOT NULL,
	`dirId` INTEGER NOT NULL DEFAULT 0,
	`createdT` TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modifiedT` TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(`id`, `type`)
);
-- 插入文章/目录, 触发layer新建事件, 层次为0, 需要手动指定新层次
-- article_insert_tri
-- dir_insert_tri
CREATE TRIGGER IF NOT EXISTS article_insert_tri
AFTER
INSERT ON article BEGIN
INSERT INTO layer(id, type)
VALUES(new.id, 0);
-- 这个能递归
UPDATE layer
SET modifiedT = CURRENT_TIMESTAMP
WHERE id = new.id
	AND type = 0;
END;
CREATE TRIGGER IF NOT EXISTS dir_insert_tri
AFTER
INSERT ON dir BEGIN
INSERT INTO layer(id, type)
VALUES(new.id, 1);
-- 这个能递归
UPDATE layer
SET modifiedT = CURRENT_TIMESTAMP
WHERE id = new.id
	AND type = 1;
END;
-- 编辑文章, markdown触发递归修改modifiedT
-- article_update_tri_markdown -- layer_update_tri_modifiedT
CREATE TRIGGER IF NOT EXISTS article_update_tri_markdown
AFTER
UPDATE OF markdown ON article BEGIN
UPDATE layer
SET modifiedT = CURRENT_TIMESTAMP
WHERE id = new.id
	AND type = 0;
END;
CREATE TRIGGER IF NOT EXISTS layer_update_tri_modifiedT
AFTER
UPDATE OF modifiedT ON layer BEGIN -- 这个能递归
UPDATE layer
SET modifiedT = CURRENT_TIMESTAMP
WHERE id = new.dirId
	AND type = 1;
END;
-- 渲染文章, html触发修改drewT.
-- article_update_tri_html
CREATE TRIGGER IF NOT EXISTS article_update_tri_html
AFTER
UPDATE OF html ON article BEGIN
UPDATE article
SET drewT = CURRENT_TIMESTAMP
WHERE id = new.id;
END;
-- 删除文章, 触发layer删除事件
-- article_delete_tri
CREATE TRIGGER IF NOT EXISTS article_delete_tri
AFTER DELETE ON article BEGIN
DELETE FROM layer
WHERE id = old.id
	AND type = 0;
END;
-- 删除目录, 同时递归触发layer删除事件 和 子元素删除事件
-- dir_delete_tri
CREATE TRIGGER IF NOT EXISTS dir_delete_tri
AFTER DELETE ON dir BEGIN -- 这个能递归
DELETE FROM article
WHERE id IN (
		SELECT id
		FROM layer
		WHERE dirId = old.id
			AND type = 0
	);
DELETE FROM dir
WHERE id IN (
		SELECT id
		FROM layer
		WHERE dirId = old.id
			AND type = 1
	);
-- 删除自身
DELETE FROM layer
WHERE id = old.id
	AND type = 1;
END;
-- 移动文章/目录. 触发layer, 只更改目标目录的modifiedT
-- 这里触发一次, 就会又进入layer_update_tri_modifiedT进行递归更新
CREATE TRIGGER IF NOT EXISTS layer_update_tri_dirId
AFTER
UPDATE OF dirId ON layer BEGIN
UPDATE layer
SET modifiedT = CURRENT_TIMESTAMP
WHERE id = new.dirId
	AND type = 1;
END;