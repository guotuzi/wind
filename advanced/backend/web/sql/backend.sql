
CREATE TABLE companies (
  company_id INT AUTO_INCREMENT PRIMARY KEY ,
  company_name VARCHAR(100) NOT NULL DEFAULT '',
  company_email VARCHAR(100) NOT NULL DEFAULT '',
  company_address VARCHAR(100) NOT NULL DEFAULT '',
  company_created_date DATETIME NOT NULL DEFAULT 0 ,
  company_status enum("active","inactive") not null default "active"
) ENGINE InnoDB CHARSET utf8;


CREATE TABLE branches (
  branch_id INT AUTO_INCREMENT PRIMARY KEY ,
  companies_company_id  INT NOT NULL DEFAULT 0,
  branch_name VARCHAR(100) NOT NULL DEFAULT '',
  branch_address VARCHAR(100) NOT NULL DEFAULT '',
  branch_created_date DATETIME NOT NULL DEFAULT 0 ,
  branch_status enum("active","inactive") not null default "active"
) ENGINE InnoDB CHARSET utf8;


CREATE TABLE departments (
  department_id INT AUTO_INCREMENT PRIMARY KEY ,
  branches_branch_id  INT NOT NULL DEFAULT 0,
  department_name VARCHAR(100) NOT NULL DEFAULT '',
  companies_company_id  INT NOT NULL DEFAULT 0,
  department_created_date DATETIME NOT NULL DEFAULT 0 ,
  department_status enum("active","inactive") not null default "active"
) ENGINE InnoDB CHARSET utf8;