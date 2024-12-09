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


CREATE TABLE amenities (
  amenity_id INT AUTO_INCREMENT PRIMARY KEY,
  amenity_name VARCHAR(100) UNIQUE NOT NULL
);


CREATE TABLE park_amenities (
  park_id INT NOT NULL,
  amenity_id INT NOT NULL,
  PRIMARY KEY (park_id, amenity_id),
  FOREIGN KEY (park_id) REFERENCES park(park_id),
  FOREIGN KEY (amenity_id) REFERENCES amenities(amenity_id)
);

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




INSERT INTO park (pard_id, name, area, location, price) VALUES
(1, 'Central Park', 843, 1, 0),
(2, 'Golden Gate Park', 1017, 2, 0),
(3, 'Palm Park', 200, 3, 0),
(4, 'City Park', 330, 4, 0),
(5, 'Forest Park', 1371, 5, 0);
