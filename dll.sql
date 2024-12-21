CREATE DATABASE greenspace;
USE greenspace;

CREATE TABLE park (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  area VARCHAR(100) NOT NULL,
  location VARCHAR(500) NOT NULL,
  description TEXT,
  created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  update_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  thumbnail VARCHAR(255)
  PRIMARY KEY (id)
);

--areaは例えば新宿、渋谷、原宿などのエリアの広さを表す
--locationは具体的な住所や地名を表す
INSERT INTO park (id, name, area, location, description, thumbnail) VALUES
(6, '新宿中央公園', '新宿', '東京都新宿区新宿1-2-3', '新宿駅から徒歩5分の好立地にある公園です。', '/img/img/dummy-blue.png'),
(7, '渋谷公園', '渋谷', '東京都渋谷区渋谷1-2-3', '渋谷駅から徒歩10分の公園です。', '/img/img/dummy-green.png'),
(8, '原宿公園', '原宿', '東京都渋谷区神宮前1-2-3', '原宿駅から徒歩3分の公園です。', '/img/img/dummy-dark.png'),
(9, '代々木公園', '代々木', '東京都渋谷区代々木1-2-3', '代々木駅から徒歩7分の公園です。', '/img/img/dummy-brown.png'),
(10, '新宿中央公園', '新宿', '東京都新宿区新宿1-2-3', '新宿駅から徒歩5分の好立地にある公園です。', '/img/img/dummy-sapphire.png');

CREATE TABLE park_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  park_id INT NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (park_id) REFERENCES park(id)
);

INSERT INTO park_images (image_id, id, image_url) VALUES
(1, 1, '/img/img/dummy-blue.png'),
(2, 2, '/img/img/dummy-green.png'),
(3, 3, '/img/img/dummy-dark.png'),
(4, 4, '/img/img/dummy-brown.png'),
(5, 5, '/img/img/dummy-sapphire.png')
;

CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  name VARCHAR(100) DEFAULT NULL,
  phone VARCHAR(15) DEFAULT NULL,
  avatar VARCHAR(255) DEFAULT '/GREENSPACE/img/avatar/panda.png',
  address VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE event (
  event_id INT AUTO_INCREMENT PRIMARY KEY,
  park_id INT NOT NULL,
  event_name VARCHAR(100) NOT NULL,
  event_datetime DATETIME NOT NULL,
  description TEXT,
  price DECIMAL(10, 2) NULL,
  FOREIGN KEY (park_id) REFERENCES park(park_id)
);

INSERT INTO event (event_id, park_id, event_name, event_datetime, description, price) VALUES
(1, 1, 'Central Park Concert', '2021-08-15 19:00:00', 'Enjoy a live concert in Central Park.', 20.00),
(2, 2, 'Golden Gate Park Festival', '2021-09-05 12:00:00', 'Join us for a fun festival in Golden Gate Park.', 15.00),
(3, 3, 'Palm Park Picnic', '2021-08-22 11:00:00', 'Bring your friends and family for a picnic at Palm Park.', 0.00),
(4, 4, 'City Park Art Show', '2021-09-12 10:00:00', 'Explore local art at City Park.', 10.00),
(5, 5, 'Forest Park Run', '2021-08-29 08:00:00', 'Participate in a 5K run in Forest Park.', 25.00);


CREATE TABLE amenities (
  amenity_id INT AUTO_INCREMENT PRIMARY KEY,
  amenity_name VARCHAR(100) UNIQUE NOT NULL
);

INSERT INTO amenities (amenity_id, amenity_name) VALUES
(1, 'Playground'),
(2, 'Picnic Area'),
(3, 'Hiking Trails'),
(4, 'Sports Fields'),
(5, 'Restrooms');


--公園と設備の多対多の関係を表す中間テーブル
CREATE TABLE park_amenities (
  park_id INT NOT NULL,
  amenity_id INT NOT NULL,
  PRIMARY KEY (park_id, amenity_id),
  FOREIGN KEY (park_id) REFERENCES park(park_id),
  FOREIGN KEY (amenity_id) REFERENCES amenities(amenity_id)
);

INSERT INTO park_amenities (park_id, amenity_id) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 2),
(2, 3),
(2, 4),
(3, 1),
(3, 2),
(3, 5),
(4, 2),
(4, 3),
(4, 4),
(5, 1),
(5, 3),
(5, 4),
(5, 5);

CREATE TABLE booking (
  booking_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  event_id INT NOT NULL,
  booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  quantity INT NOT NULL,
  total_price DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user(user_id),
  FOREIGN KEY (event_id) REFERENCES event(event_id)
);

CREATE TABLE favorite_parks (
  user_id INT NOT NULL,
  park_id INT NOT NULL,
  PRIMARY KEY (user_id, park_id),
  FOREIGN KEY (user_id) REFERENCES user(user_id),
  FOREIGN KEY (park_id) REFERENCES park(park_id)
);

CREATE TABLE favorite_events (
  user_id INT NOT NULL,
  event_id INT NOT NULL,
  PRIMARY KEY (user_id, event_id),
  FOREIGN KEY (user_id) REFERENCES user(user_id),
  FOREIGN KEY (event_id) REFERENCES event(event_id)
);

CREATE TABLE news (
  news_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)

INSERT INTO news (news_id, title, content, created_at) VALUES
(1, 'New Park Opening', 'We are excited to announce the opening of our new park in downtown! Come and enjoy the beautiful green space.', '2021-08-01 09:00:00'),
(2, 'Upcoming Events', 'Check out our upcoming events in the parks near you. From concerts to festivals, there is something for everyone.', '2021-08-05 12:00:00'),
(3, 'Park Renovation', 'We are renovating one of our parks to create a better experience for our visitors. Stay tuned for the grand reopening!', '2021-08-10 10:00:00');

CREATE TABLE feedback (
  feedback_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES user(user_id)
);