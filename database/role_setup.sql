USE hanjari_music_house_db;

ALTER TABLE users
MODIFY role ENUM('admin', 'storekeeper')
NOT NULL DEFAULT 'storekeeper';