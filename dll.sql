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
(1, 'Central Park', 'New York', 'New York, NY 10024', 'Central Park is an urban park in New York City located between the Upper West and Upper East Sides of Manhattan. It is the most visited urban park in the United States.', '/img/img/central-park.jpg'),
(2, 'Golden Gate Park', 'San Francisco', 'San Francisco, CA 94121', 'Golden Gate Park is a large urban park consisting of 1,017 acres of public grounds in San Francisco, California. It is a popular destination for locals and tourists alike.', '/img/img/golden-gate-park.jpg'),
(3, 'Palm Park', 'Los Angeles', 'Los Angeles, CA 90012', 'Palm Park is a small park located in downtown Los Angeles. It is a peaceful oasis in the midst of the bustling city.', '/img/img/palm-park.jpg'),
(4, 'City Park', 'Chicago', 'Chicago, IL 60614', 'City Park is a historic park in the Lincoln Park neighborhood of Chicago. It offers a variety of recreational activities and events for visitors.', '/img/img/city-park.jpg'),
(5, 'Forest Park', 'St. Louis', 'St. Louis, MO 63110', 'Forest Park is a public park in St. Louis, Missouri. It is home to several cultural institutions, including the St. Louis Art Museum and the Missouri History Museum.', '/img/img/forest-park.jpg'),
(6, 'Hyde Park', 'London', 'London W2 2UH, UK', 'Hyde Park is a Grade I-listed major park in Central London. It is the largest of four Royal Parks that form a chain from the entrance of Kensington Palace through Kensington Gardens and Hyde Park, via Hyde Park Corner and Green Park past the main entrance to Buckingham Palace.', '/img/img/hyde-park.jpg'),
(7, 'Vondelpark', 'Amsterdam', '1071 AA Amsterdam, Netherlands', 'Vondelpark is a public urban park of 47 hectares in Amsterdam, Netherlands. It is part of the borough of Amsterdam-Zuid and situated west from the Leidseplein and the Museumplein.', '/img/img/vondelpark.jpg'),
(8, 'Ueno Park', 'Tokyo', 'Uenokoen, Taito City, Tokyo 110-0007, Japan', 'Ueno Park is a spacious public park in the Ueno district of Taitō, Tokyo, Japan. The park was established in 1873 on lands formerly belonging to the temple of Kan'ei-ji.', '/img/img/ueno-park.jpg'),
(9, 'Parc Güell', 'Barcelona', '08024 Barcelona, Spain', 'Parc Güell is a public park system composed of gardens and architectonic elements located on Carmel Hill, in Barcelona, Catalonia, Spain.', '/img/img/parc-guell.jpg'),
(10, 'Yoyogi Park', 'Tokyo', '2-1 Yoyogikamizonocho, Shibuya City, Tokyo 151-0052, Japan', 'Yoyogi Park is a park in Shibuya, Tokyo, Japan. Yoyogi Park is a popular Tokyo destination and a great spot for hanami during cherry blossom season.', '/img/img/yoyogi-park.jpg'),
(11, 'Luxembourg Gardens', 'Paris', '75006 Paris, France', 'The Jardin du Luxembourg, also known in English as the Luxembourg Gardens, is located in the 6th arrondissement of Paris, France. It was created beginning in 1612 by Marie de' Medici, the widow of King Henry IV of France, for a new residence she constructed, the Luxembourg Palace.', '/img/img/luxembourg-gardens.jpg');

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