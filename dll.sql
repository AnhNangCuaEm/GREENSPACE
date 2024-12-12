CREATE DATABASE greenspace;
USE greenspace;

CREATE TABLE park (
  park_id INT AUTO_INCREMENT PRIMARY KEY,
  park_name VARCHAR(100) NOT NULL,
  area VARCHAR(100) NOT NULL,
  location VARCHAR(500) NOT NULL,
  price DECIMAL(10, 2) NULL,
  description TEXT,
  created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  update_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

--areaは例えば新宿、渋谷、原宿などのエリアの広さを表す
--locationは具体的な住所や地名を表す
INSERT INTO park (park_id, park_name, area, location, price, description) VALUES 
(1, 'Central Park', 'New York', 'Central Park, New York, NY', 0.00, 'Central Park is an urban park in New York City located between the Upper West Side and Upper East Side. It is the most visited urban park in the United States.'),
(2, 'Golden Gate Park', 'San Francisco', 'Golden Gate Park, San Francisco, CA', 0.00, 'Golden Gate Park, located in San Francisco, California, is a large urban park consisting of 1,017 acres of public grounds.'),
(3, 'Palm Park', 'Los Angeles', 'Palm Park, Los Angeles, CA', 0.00, 'Palm Park is a public park in Los Angeles, California, known for its palm trees and picnic areas.'),
(4, 'City Park', 'Chicago', 'City Park, Chicago, IL', 0.00, 'City Park is a popular park in Chicago, Illinois, with sports fields and recreational facilities.'),
(5, 'Forest Park', 'St. Louis', 'Forest Park, St. Louis, MO', 0.00, 'Forest Park is a public park in St. Louis, Missouri, known for its museums, gardens, and outdoor activities.')
(6, 'Yoyogi Park', 'Tokyo', 'Yoyogi Park, Tokyo, Japan', 0.00, 'Yoyogi Park is a large park in Tokyo, Japan, known for its cherry blossoms and cultural events.'),
(7, 'Hyde Park', 'London', 'Hyde Park, London, UK', 0.00, 'Hyde Park is a historic park in London, United Kingdom, with famous landmarks and recreational areas.'),
(8, 'Vondelpark', 'Amsterdam', 'Vondelpark, Amsterdam, Netherlands', 0.00, 'Vondelpark is a popular park in Amsterdam, Netherlands, with walking paths and outdoor activities.'),
(9, 'Tiergarten', 'Berlin', 'Tiergarten, Berlin, Germany', 0.00, 'Tiergarten is a large park in Berlin, Germany, known for its green spaces and cultural attractions.'),
(10, 'Parc Guell', 'Barcelona', 'Parc Guell, Barcelona, Spain', 0.00, 'Parc Guell is a public park in Barcelona, Spain, designed by architect Antoni Gaudi.')
;

CREATE TABLE user (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  username VARCHAR(100) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  phone VARCHAR(15) NOT NULL,
  image VARCHAR(255) NULL,
  address VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
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