CREATE DATABASE greenspace;
USE greenspace;

CREATE TABLE park (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  area VARCHAR(100) NOT NULL,
  location VARCHAR(500) NOT NULL,
  description TEXT,
  price VARCHAR(100),
  created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  thumbnail VARCHAR(255)
);

--areaは例えば新宿、渋谷、原宿などのエリアの広さを表す
--locationは具体的な住所や地名を表す
INSERT INTO park (name, area, location, description, price, created_at, updated_at, thumbnail) VALUES
('上野恩賜公園', '上野', '東京都台東区上野公園5-20', '東京を代表する歴史的な公園で、美術館や博物館など文化的な施設が充実しています。不忍池では四季折々の自然を楽しむことができ、特に春には桜の名所として多くの人が訪れます。', '入園無料（一部施設有料）', NOW(), NOW(), NULL),
('代々木公園', '渋谷', '東京都渋谷区代々木神園町2-1', '東京最大級の緑豊かな公園で、広大な芝生広場やジョギングコースがあります。季節ごとにイベントやフェスティバルが開催され、都会のオアシスとして人気です。', '入園無料', NOW(), NOW(), NULL),
('日比谷公園', '千代田', '東京都千代田区日比谷公園1-6', '日本初の洋風庭園で、四季折々の花壇や噴水が美しい景観を作り出しています。散策や読書を楽しむのに適した静かな空間です。', '入園無料', NOW(), NOW(), NULL),
('新宿御苑', '新宿', '東京都新宿区内藤町11', '日本庭園と洋風庭園が融合した広大で美しい庭園です。春には桜が見事で、秋には紅葉も楽しめます。都会の喧騒を忘れる癒しのスポットです。', '大人500円', NOW(), NOW(), NULL),
('国営昭和記念公園', '立川', '東京都立川市緑町3173', '広大な敷地内には花畑やバーベキュー施設、子供向けの遊具エリアがあります。サイクリングやボート遊びなどアクティブな楽しみ方ができ、家族連れに人気です。', '大人450円', NOW(), NOW(), NULL),
('お台場海浜公園', '港区', '東京都港区台場1', '東京湾を望む都会のビーチで、レインボーブリッジを背景に散策やピクニックが楽しめます。夜景も美しく、デートスポットとしてもおすすめです。', '入園無料', NOW(), NOW(), NULL),
('浜離宮恩賜庭園', '中央区', '東京都中央区浜離宮庭園1-1', '江戸時代の大名庭園で、美しい池や石灯籠が点在しています。抹茶を味わいながら庭園の景色を堪能することができます。', '一般300円', NOW(), NOW(), NULL),
('井の頭恩賜公園', '吉祥寺', '東京都武蔵野市御殿山1-18-31', '吉祥寺駅から徒歩5分の便利な立地にある公園です。ボート遊びや動物園が楽しめるほか、散策路や池の風景も魅力的です。', '入園無料（一部施設有料）', NOW(), NOW(), NULL),
('新宿中央公園', '新宿', '東京都新宿区新宿1-2-3', '新宿駅から徒歩5分の立地にあり、都会の中で気軽に緑を楽しめる公園です。季節の花や広場があり、リフレッシュに最適です。', '入園無料', NOW(), NOW(), NULL),
('小石川後楽園', '文京区', '東京都文京区後楽1-6-6', '日本庭園と中国庭園の要素を取り入れた歴史的な庭園です。特に紅葉の季節には訪れる人が多く、池を中心とした景観が見事です。', '一般300円', NOW(), NOW(), NULL),
('原宿公園', '原宿', '東京都渋谷区神宮前1-2-3', '原宿駅から徒歩3分という好立地にある小規模な公園で、買い物や観光の合間に立ち寄るのに便利です。', '入園無料', NOW(), NOW(), NULL),
('葛西臨海公園', '葛西', '東京都江戸川区臨海町6-2-1', '東京湾沿いに広がる大規模な公園で、観覧車や葛西臨海水族園が併設されています。ピクニックや散策に最適な場所です。', '入園無料', NOW(), NOW(), NULL),
('芝公園', '東京タワー', '東京都港区芝公園4-2-8', '東京タワーのすぐそばに位置し、広場や遊具が整備された公園です。タワーを背景にした写真スポットとしても人気があります。', '入園無料', NOW(), NOW(), NULL),
('木場公園', '江東区', '東京都江東区木場4-6-1', '元材木置き場を再開発した公園で、スポーツ施設やイベントスペースが充実しています。桜並木や日本庭園もあり、季節の変化が楽しめます。', '入園無料', NOW(), NOW(), NULL),
('清澄庭園', '江東区', '東京都江東区清澄3-3-9', '明治時代に造られた回遊式庭園で、池に映る緑や東屋が趣深い景観を作り出しています。静かな時間を過ごすのに最適です。', '一般150円', NOW(), NOW(), NULL),
('旧古河庭園', '北区', '東京都北区西ヶ原1-27-39', '洋館と日本庭園が調和した大正時代の庭園です。特にバラ園が有名で、春と秋のバラフェスティバルが人気です。', '一般150円', NOW(), NOW(), NULL),
('砧公園', '世田谷区', '東京都世田谷区砧公園1-1', '広大な芝生広場が特徴で、ピクニックや家族でのんびり過ごすのにぴったりの公園です。子供向けの遊具も充実しています。', '入園無料', NOW(), NOW(), NULL),
('六義園', '文京区', '東京都文京区本駒込6-16-3', '江戸時代の大名庭園で、春のしだれ桜や秋の紅葉が見どころです。特にライトアップされた夜の庭園は幻想的な雰囲気です。', '一般300円', NOW(), NOW(), NULL);


CREATE TABLE park_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  park_id INT NOT NULL,
  image_url VARCHAR(255) NOT NULL,
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

CREATE TABLE avatar (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_email VARCHAR(100) NOT NULL,
  avatar_url VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_email) REFERENCES user(email)
);


CREATE TABLE event (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  date VARCHAR(100) NOT NULL,
  time VARCHAR(100),
  location VARCHAR(100),
  description TEXT NOT NULL,
  price VARCHAR(100) NOT NULL
);

CREATE TABLE park_likes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  park_id INT NOT NULL,
  user_email VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (park_id) REFERENCES park(id),
  FOREIGN KEY (user_email) REFERENCES user(email)
);

CREATE TABLE event_saved (
  id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT NOT NULL,
  user_email VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (event_id) REFERENCES event(id),
  FOREIGN KEY (user_email) REFERENCES user(email)
);


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