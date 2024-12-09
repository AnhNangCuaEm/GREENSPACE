CREATE DATABASE greenspace;
USE greenspace;

CREATE TABLE park (
  park_id INT AUTO_INCREMENT PRIMARY KEY,
  park_name VARCHAR(100) NOT NULL,
  area INT NOT NULL,
  location VARCHAR(255) NOT NULL,
  price DECIMAL(10, 2) NULL,
  description TEXT
);

INSERT INTO park (park_id, park_name, area, location, price, description) VALUES
(1, 'Central Park', 843, 'New York', 0, 'Central Park is an urban park in New York City located between the Upper West and Upper East Sides of Manhattan. It is the fifth-largest park in the city by area, covering 843 acres (341 ha).'),
(2, 'Golden Gate Park', 1017, 'San Francisco', 0, 'Golden Gate Park, located in San Francisco, California, United States, is a large urban park consisting of 1,017 acres (412 ha) of public grounds.'),
(3, 'Palm Park', 200, 'Los Angeles', 0, 'Palm Park is a small park located in Los Angeles, California. It is a great place for a picnic or a leisurely walk.'),
(4, 'City Park', 330, 'New Orleans', 0, 'City Park, a 1,300-acre public park in New Orleans, Louisiana, is the 87th largest and 20th-most-visited urban public park in the United States.'),
(5, 'Forest Park', 1371, 'St. Louis', 0, 'Forest Park is a public park in western St. Louis, Missouri. It is a prominent civic center and covers 1,371 acres (555 ha).')

CREATE TABLE user (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  username VARCHAR(100) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  phone VARCHAR(15) NOT NULL,
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

CREATE TABLE review (
  review_id INT AUTO_INCREMENT PRIMARY KEY,
  park_id INT NOT NULL,
  user_id INT NOT NULL,
  rating INT CHECK (rating BETWEEN 1 AND 5),
  comment TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (park_id) REFERENCES park(park_id),
  FOREIGN KEY (user_id) REFERENCES user(user_id)
);

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
