DROP DATABASE IF EXISTS BASKETBALL_MANAGEMENT;
CREATE DATABASE IF NOT EXISTS BASKETBALL_MANAGEMENT;
DROP USER IF EXISTS 'nguyentran'@'localhost';
GRANT SELECT, INSERT, DELETE, UPDATE ON BASKETBALL_MANAGEMENT.* TO 'nguyentran'@'localhost' IDENTIFIED BY 'nguyen';

USE BASKETBALL_MANAGEMENT;


CREATE TABLE ACCOUNT
(
  USER_ID INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email varchar(50) NOT NULL,
  password varchar(100) NOT NULL,
  first_name VARCHAR(100),
  last_name VARCHAR(150) NOT NULL,
  hash CHAR(255) NOT NULL,
  type ENUM('O','D','ED') NOT NULL DEFAULT 'O',

  INDEX(last_name),
  INDEX(first_name, last_name)
);


CREATE TABLE TEAM
(
  TeamID INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  TeamName VARCHAR(100)
);

CREATE TABLE PLAYER
(
  PlayerId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  Name_First VARCHAR(100),
  Name_Last VARCHAR(150) NOT NULL,
  Street VARCHAR(250),
  City VARCHAR(100),
  State VARCHAR(100),
  Country VARCHAR(100),
  ZipCode CHAR(10),
  PlayerTeamId INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (PlayerId),

  FOREIGN KEY (PlayerTeamId) REFERENCES TEAM(TeamID) ON UPDATE CASCADE ON DELETE CASCADE,

  CHECK (ZipCode REGEXP '(?!0{5})(?!9{5})\\d{5}(-(?!0{4})(?!9{4})\\d{4})?'),
  INDEX(Name_Last),
  INDEX(Name_First, Name_Last)
);

CREATE TABLE GAME
(
  GameID INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  StartDate DATE,
  TimeSchedule TIME,
  ATeamID INT(10) UNSIGNED NOT NULL,
  BTeamID INT(10) UNSIGNED NOT NULL,

  CONSTRAINT TEAMPLAYER FOREIGN KEY (ATeamID) REFERENCES TEAM(TeamID) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT TEAMPLAYER2 FOREIGN KEY (BTeamID) REFERENCES TEAM(TeamID) ON UPDATE CASCADE ON DELETE CASCADE

);

CREATE TABLE Statistics
(
  ID INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  PlayerId INT(10) UNSIGNED NOT NULL,
  PlayingTimeMin TINYINT(2) UNSIGNED DEFAULT 0,
  PlayingTimeSec TINYINT(2) UNSIGNED DEFAULT 0,
  Points TINYINT(3) UNSIGNED DEFAULT 0,
  Assists TINYINT(3) UNSIGNED DEFAULT 0,
  Rebounds TINYINT(3) UNSIGNED DEFAULT 0,
  GameId INT(10) UNSIGNED NOT NULL,

  CONSTRAINT GAMEPLAY FOREIGN KEY (GameId) REFERENCES GAME(GameID) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT FORPLAYER FOREIGN KEY (PlayerId) REFERENCES PLAYER(PlayerId) ON UPDATE CASCADE ON DELETE CASCADE,

  CHECK((PLAYINGTIMEMIN < 40 AND PLAYINGTIMESEC < 60) OR
        (PLAYINGTIMEMIN = 40 AND PLAYINGTIMESEC = 0 ))
);

INSERT INTO TEAM VALUES
(35, 'CSUF'),
(36, 'UCLA'),
(37, 'CSULB');

INSERT INTO GAME VALUES
('1','2018-2-1','18:00:00','35','36'),
('2','2018-3-1','15:00:00','36','37'),
('3','2018-4-1','14:00:00','37','35');

INSERT INTO PLAYER(PlayerId, Name_First, Name_Last, Street, City, State, Country, ZipCode, PlayerTeamId) VALUES
(100, 'Donald', 'Duck', '1313 S. Harbor Blvd.', 'Anaheim', 'CA', 'USA', '92808-3232', '35'),
(101, 'Daisy', 'Duck', '1180 Seven Seas Dr.', 'Lake Buena Vista', 'FL', 'USA', '32830', '35' ),
(102, 'Mickey', 'Mouse', '1313 S.Harbor Blvd.', 'Anaheim', 'CA', 'USA', '92808-3232', '35' ),
(103, 'Pluto', 'Dog', '1313 S. Harbor Blvd.', 'Anaheim', 'CA', 'USA', '92808-3232', '36'),
(104, 'Scrooge', 'McDuck', '1180 Seven Seas Dr.', 'Lake Buena Vista', 'FL', 'USA', '92808-3232','36'),
(105, 'Huebert (Huey)', 'Duck', '1110 Seven Seas Dr.', 'Lake Buena Vista', 'FL', 'USA', '32830','37'),
(106, 'Deuteronomy (Dewey)', 'Duck', '1180 Seven Seas Dr.', 'Lake Buena Vista', 'FL', 'USA', '32830', '37'),
(107, 'Louie', 'Duck', '1180 Seven Seas Dr.', 'Lake Buena Vista', 'FL', 'USA', '32830', '37' ),
(108, 'Phooey', 'Duck', '1-1 Maihama Urayasu', 'Chiba Prefecture', 'Disney Tokyo', 'Japan', NULL, '37'),
(109, 'Della', 'Duck', '77700 Boulevard du Parc', 'Coupvray', 'Disney Paris', 'France', NULL, '37');


INSERT INTO Statistics VALUES
('17','100','35','12','47','11','21','1'),
('18','102','13','22','13','1','3','2'),
('19','103','10','0','18','2','4','3'),
('20','107','2','45','9','1','2','3'),
('21','102','15','39','26','3','7','2'),
('22','100','29','47','27','9','8','1');
