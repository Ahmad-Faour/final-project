DROP DATABASE IF EXISTS blog_api;
CREATE DATABASE blog_api
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE blog_api;

/* ----------  users  ---------- */
CREATE TABLE users (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name       VARCHAR(100) NOT NULL,
  email      VARCHAR(255) NOT NULL UNIQUE,
  created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO users (name,email) VALUES
  ('Alice Johnson','alice@example.com'),
  ('Bob Smith','bob@example.com'),
  ('Charlie Lee','charlie@example.com');

/* ----------  posts  ---------- */
CREATE TABLE posts (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title      VARCHAR(255) NOT NULL,
  content    MEDIUMTEXT   NOT NULL,
  user_id    INT UNSIGNED NOT NULL,
  created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_posts_user
    FOREIGN KEY (user_id) REFERENCES users(id)
      ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO posts (title,content,user_id,created_at) VALUES
  ('Hello World','This is the first post!',1,'2025-08-01 10:00:00'),
  ('Second Post','Another day, another post.',2,'2025-08-02 12:30:00'),
  ('Travel Tips','Pack light and enjoy!',1,'2025-08-03 09:15:00'),
  ('Tech News','PHP 9 released today 🎉',3,'2025-08-04 18:45:00'),
  ('Cooking 101','Always taste as you go.',2,'2025-08-05 14:20:00');

/* ----------  comments  ---------- */
CREATE TABLE comments (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  content    TEXT         NOT NULL,
  post_id    INT UNSIGNED NOT NULL,
  user_id    INT UNSIGNED NOT NULL,
  created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_comments_post
    FOREIGN KEY (post_id) REFERENCES posts(id)
      ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_comments_user
    FOREIGN KEY (user_id) REFERENCES users(id)
      ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO comments (content,post_id,user_id,created_at) VALUES
  ('Great post!',1,2,'2025-08-01 11:00:00'),
  ('Thanks for sharing.',1,3,'2025-08-01 11:05:00'),
  ('Nice tips.',3,3,'2025-08-03 10:00:00'),
  ('Exciting news!',4,1,'2025-08-04 19:00:00'),
  ('Can you elaborate?',4,2,'2025-08-04 19:10:00'),
  ('Love this.',5,1,'2025-08-05 15:00:00'),
  ('Yummy!',5,3,'2025-08-05 15:05:00'),
  ('First comment here.',2,1,'2025-08-02 13:00:00'),
  ('Interesting perspective.',2,3,'2025-08-02 13:15:00'),
  ('Bookmarking this.',3,2,'2025-08-03 10:30:00');

CREATE INDEX idx_posts_user_created     ON posts    (user_id, created_at);
CREATE INDEX idx_comments_post_created  ON comments (post_id, created_at);
