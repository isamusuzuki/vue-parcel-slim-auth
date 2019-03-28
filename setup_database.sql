-- 1. 新しいデータベースを作成する
create database vpsa_db;

-- 2. 新しいユーザーをユーザーを作成し、データベースへの権限を与える
grant all on vpsa_db.* to vpsa_dbuser@localhost identified by 'vpsa_dbpasswd';

-- 3. 権限テーブルをリロードする
flush privileges;

-- 4. 使用するデータベースを変更する
use vpsa_db;

-- 5. vpsa_usersテーブルを作成する
CREATE TABLE `vpsa_users` (
  `id` int AUTO_INCREMENT,
  `username` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 6. vpsa_usersテーブルにデータを追加する
INSERT INTO `vpsa_users` (`username`, `password`) VALUES
('user', '$2y$10$Fn26scxVobuHaHz2sNtYDeP3x703QAsVjCLj4pdQdMpjGq78ma/MC');
