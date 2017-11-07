DROP TABLE IF EXISTS 'auth_assignment';
DROP TABLE IF EXISTS 'auth_item_child';
DROP TABLE IF EXISTS 'auth_item';
DROP TABLE IF EXISTS 'auth_rule';

CREATE TABLE 'auth_rule'(
  'name' VARCHAR(64) NOT NULL ,
  'date' TEXT,
  'created_at' INTEGER,
  'update_at' INTEGER,
      PRIMARY KEY ('name')
) ENGINE InnoDB;


CREATE TABLE 'auth_item' (
  'name' VARCHAR(64) NOT NULL ,
  'type' INTEGER NOT NULL ,
  'description' TEXT,
  'rule_name' VARCHAR(64),
  'data' TEXT,
  'created_at' INTEGER,
  'updated_at' INTEGER,
  PRIMARY KEY ('name'),
  FOREIGN KEY ('rule_name') REFERENCES 'auth_rule' ('name') ON DELETE SET NULL ON UPDATE CASCADE ,
  KEY 'type' ('type')
) ENGINE InnoDB;


CREATE TABLE 'auth_item_child'(
  'parent' VARCHAR(64) NOT NULL ,
  'child' VARCHAR(64) NOT NULL ,
  PRIMARY KEY ('parent', 'child'),
  FOREIGN KEY ('parent') REFERENCES 'auth_item' ('name') ON DELETE SET NULL ON UPDATE CASCADE ,
  FOREIGN KEY ('child') REFERENCES 'auth_item' ('name') ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE InnoDB;

CREATE TABLE 'auth_assignment' (
  'item_name' VARCHAR(64) NOT NULL ,
  'user_id' VARCHAR(64) NOT NULL ,
  'created_at' INTEGER,
  PRIMARY KEY ('item_name', 'user_id'),
  FOREIGN KEY ('item_name') REFERENCES 'auth_item' ('name') ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE InnoDB;


#==================报错，去除引号试试==========================
DROP TABLE IF EXISTS auth_assignment;
DROP TABLE IF EXISTS auth_item_child;
DROP TABLE IF EXISTS auth_item;
DROP TABLE IF EXISTS auth_rule;


CREATE TABLE auth_rule(
  name VARCHAR(64) NOT NULL ,
  date TEXT,
  created_at INTEGER,
  updated_at INTEGER,
  PRIMARY KEY (name)
) ENGINE InnoDB;

# 角色表
CREATE TABLE auth_item (
  name VARCHAR(64) NOT NULL ,
  type INTEGER NOT NULL ,
  description TEXT,
  rule_name VARCHAR(64),
  data TEXT,
  created_at INTEGER,
  update_at INTEGER,
  PRIMARY KEY (name),
  FOREIGN KEY (rule_name) REFERENCES auth_rule (name) ON DELETE SET NULL ON UPDATE CASCADE ,
  KEY type (type)
) ENGINE InnoDB;

#权限表
CREATE TABLE auth_item_child(
  parent VARCHAR(64) NOT NULL ,
  child VARCHAR(64) NOT NULL ,
  PRIMARY KEY (parent, child),
  # 添加外键，如果引用这和被引用者 set null 设置的不同，也会报错， 这个地方错了，所以无法建立外键关联
  FOREIGN KEY (parent) REFERENCES auth_item (name) ON DELETE CASCADE ON UPDATE CASCADE ,
  FOREIGN KEY (child) REFERENCES auth_item (name) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE InnoDB;


# 用户角色表
CREATE TABLE auth_assignment (
  item_name VARCHAR(64) NOT NULL ,
  user_id VARCHAR(64) NOT NULL ,
  created_at INTEGER,
  PRIMARY KEY (item_name, user_id),
  FOREIGN KEY (item_name) REFERENCES auth_item (name) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE InnoDB;








