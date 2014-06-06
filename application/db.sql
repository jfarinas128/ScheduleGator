-- Database: "BetterBracket"

-- DROP DATABASE "BetterBracket";
/*
CREATE DATABASE "BetterBracket"
  WITH OWNER = postgres
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       LC_COLLATE = 'C'
       LC_CTYPE = 'C'
       CONNECTION LIMIT = -1;
*/

CREATE SEQUENCE user_id_seq;
CREATE TABLE users
(
  id integer NOT NULL DEFAULT nextval('user_id_seq'),
  email character varying(125),
  password varchar(256),
  date_joined timestamp without time zone DEFAULT statement_timestamp(),
  CONSTRAINT users_table_pkey PRIMARY KEY (id),
  CONSTRAINT emails UNIQUE(email)
);
ALTER SEQUENCE user_id_seq OWNED BY users.id;

CREATE TABLE users_profile
(
  user_id integer NOT NULL,
  first character varying(125),
  last character varying(125),
  description TEXT,
  caption character varying(125)
);

CREATE SEQUENCE group_id_seq;
CREATE TABLE groups
(
  id integer NOT NULL DEFAULT nextval('group_id_seq'),
  name character varying(125),
  date_created timestamp without time zone DEFAULT statement_timestamp(),
  CONSTRAINT groups_table_pkey PRIMARY KEY (id)
);
ALTER SEQUENCE group_id_seq OWNED BY groups.id;

CREATE TABLE groups_profile
(
  group_id integer NOT NULL,
  picturelocation character varying(256),
  description TEXT,
  caption character varying(125)
);


CREATE TABLE user_groups
(
  group_id integer NOT NULL,
  user_id integer NOT NULL
);

CREATE SEQUENCE team_id_seq;
CREATE TABLE teams  (
  id INTEGER NOT NULL DEFAULT nextval('team_id_seq'),
  team_name character varying(126),
  seed integer,
  region smallint,
  CONSTRAINT teams_table_pkey PRIMARY KEY (id)
);
ALTER SEQUENCE team_id_seq OWNED BY teams.id;

CREATE SEQUENCE games_id_seq;
CREATE TABLE games  (
  id INTEGER NOT NULL DEFAULT nextval('games_id_seq'),
  team_id_1 INTEGER,
  team_id_2 INTEGER,
  date_played timestamp,
  CONSTRAINT games_table_pkey PRIMARY KEY (id)
);

CREATE TABLE scores  (
  game_id INTEGER NOT NULL,
  score SMALLINT,
  score_2 SMALLINT,
  FOREIGN KEY (game_id) REFERENCES games (id)
);


CREATE SEQUENCE message_id_seq;
CREATE TABLE messages
(
  id integer NOT NULL DEFAULT nextval('message_id_seq'),
  user_id integer NOT NULL,
  group_id integer NOT NULL,
  message text,
  date_posted timestamp without time zone DEFAULT statement_timestamp()
);
ALTER SEQUENCE message_id_seq OWNED BY messages.id;


CREATE SEQUENCE pick_id_seq;
CREATE TABLE picks
(
  id integer NOT NULL DEFAULT nextval('pick_id_seq'),
  user_id INTEGER,
  group_id INTEGER,
  team_id INTEGER,
  region SMALLINT,
  round SMALLINT,
  game SMALLINT,
  team SMALLINT,
  CONSTRAINT picks_table_pkey PRIMARY KEY (id)
);
ALTER SEQUENCE pick_id_seq OWNED BY picks.id;

/*

Adding Team Data

 */
INSERT INTO groups(name)VALUES('Global');
INSERT INTO groups_profile(group_id)
SELECT ID FROM GROUPS WHERE NAME = 'Global';

INSERT INTO teams (team_name,seed,region)VALUES('Florida',1,1);
INSERT INTO teams (team_name,seed,region)VALUES('Kansas',2,1);
INSERT INTO teams (team_name,seed,region)VALUES('Syracuse',3,1);
INSERT INTO teams (team_name,seed,region)VALUES('UCLA',4,1);
INSERT INTO teams (team_name,seed,region)VALUES('Virginia Commonwealth',5,1);
INSERT INTO teams (team_name,seed,region)VALUES('Ohio State',6,1);
INSERT INTO teams (team_name,seed,region)VALUES('New Mexico',7,1);
INSERT INTO teams (team_name,seed,region)VALUES('Colorado',8,1);
INSERT INTO teams (team_name,seed,region)VALUES('Pittsburgh',9,1);
INSERT INTO teams (team_name,seed,region)VALUES('Stanford',10,1);
INSERT INTO teams (team_name,seed,region)VALUES('Dayton',11,1);
INSERT INTO teams (team_name,seed,region)VALUES('Stephen F. Austin',12,1);
INSERT INTO teams (team_name,seed,region)VALUES('Tulsa',13,1);
INSERT INTO teams (team_name,seed,region)VALUES('Western Michigan',14,1);
INSERT INTO teams (team_name,seed,region)VALUES('Eastern Kentucky',15,1);
INSERT INTO teams (team_name,seed,region)VALUES('Albany',16,1);

INSERT INTO teams (team_name,seed,region)VALUES('Arizona',1,2);
INSERT INTO teams (team_name,seed,region)VALUES('Wisconsin',2,2);
INSERT INTO teams (team_name,seed,region)VALUES('Creighton',3,2);
INSERT INTO teams (team_name,seed,region)VALUES('San Diego State',4,2);
INSERT INTO teams (team_name,seed,region)VALUES('Oklahoma',5,2);
INSERT INTO teams (team_name,seed,region)VALUES('Baylor',6,2);
INSERT INTO teams (team_name,seed,region)VALUES('Oregon',7,2);
INSERT INTO teams (team_name,seed,region)VALUES('Gonzaga',8,2);
INSERT INTO teams (team_name,seed,region)VALUES('Oklahoma State',9,2);
INSERT INTO teams (team_name,seed,region)VALUES('Brigham Young',10,2);
INSERT INTO teams (team_name,seed,region)VALUES('Nebraska',11,2);
INSERT INTO teams (team_name,seed,region)VALUES('North Dakota State',12,2);
INSERT INTO teams (team_name,seed,region)VALUES('New Mexico State',13,2);
INSERT INTO teams (team_name,seed,region)VALUES('Louisiana-Lafayette',14,2);
INSERT INTO teams (team_name,seed,region)VALUES('American',15,2);
INSERT INTO teams (team_name,seed,region)VALUES('Weber State',16,2);

INSERT INTO teams (team_name,seed,region)VALUES('Virginia',1,3);
INSERT INTO teams (team_name,seed,region)VALUES('Villanova',2,3);
INSERT INTO teams (team_name,seed,region)VALUES('Iowa State',3,3);
INSERT INTO teams (team_name,seed,region)VALUES('Michigan State',4,3);
INSERT INTO teams (team_name,seed,region)VALUES('Cincinnati',5,3);
INSERT INTO teams (team_name,seed,region)VALUES('North Carolina',6,3);
INSERT INTO teams (team_name,seed,region)VALUES('Connecticut',7,3);
INSERT INTO teams (team_name,seed,region)VALUES('Memphis',8,3);
INSERT INTO teams (team_name,seed,region)VALUES('George Washington',9,3);
INSERT INTO teams (team_name,seed,region)VALUES('St. Joseph''s',10,3);
INSERT INTO teams (team_name,seed,region)VALUES('Providence',11,3);
INSERT INTO teams (team_name,seed,region)VALUES('Harvard',12,3);
INSERT INTO teams (team_name,seed,region)VALUES('Delaware',13,3);
INSERT INTO teams (team_name,seed,region)VALUES('North Carolina Central',14,3);
INSERT INTO teams (team_name,seed,region)VALUES('Milwaukee',15,3);
INSERT INTO teams (team_name,seed,region)VALUES('Coastal Carolina',16,3);

INSERT INTO teams (team_name,seed,region)VALUES('Wichita State',1,4);
INSERT INTO teams (team_name,seed,region)VALUES('Michigan',2,4);
INSERT INTO teams (team_name,seed,region)VALUES('Duke',3,4);
INSERT INTO teams (team_name,seed,region)VALUES('Louisville',4,4);
INSERT INTO teams (team_name,seed,region)VALUES('St. Louis',5,4);
INSERT INTO teams (team_name,seed,region)VALUES('Massachusetts',6,4);
INSERT INTO teams (team_name,seed,region)VALUES('Texas',7,4);
INSERT INTO teams (team_name,seed,region)VALUES('Kentucky',8,4);
INSERT INTO teams (team_name,seed,region)VALUES('Kansas State',9,4);
INSERT INTO teams (team_name,seed,region)VALUES('Arizona State',10,4);
INSERT INTO teams (team_name,seed,region)VALUES('Tennessee',11,4);
INSERT INTO teams (team_name,seed,region)VALUES('NC State',12,4);
INSERT INTO teams (team_name,seed,region)VALUES('Manhattan',13,4);
INSERT INTO teams (team_name,seed,region)VALUES('Mercer',14,4);
INSERT INTO teams (team_name,seed,region)VALUES('Wofford',15,4);
INSERT INTO teams (team_name,seed,region)VALUES('Cal Poly',16,4);


/*Games and scores 
<tr>
  <td>([A-Za-z \.\-\']+)</td>
  <td>(.+)</td>
  <td>([A-Za-z \.\-\']+)</td>
  <td>(.+)</td>
</tr>
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = '$1'),
(SELECT id from teams where team_name = '$3'),
'2014-03-20');\n INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = '$1') AND team_id_2 = (SELECT id from teams where team_name = '$3')),
$2,$4);

*/


INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Wisconsin'),
(SELECT id from teams where team_name = 'American'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Wisconsin') AND team_id_2 = (SELECT id from teams where team_name = 'American')),
75,35);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Pittsburgh'),
(SELECT id from teams where team_name = 'Colorado'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Pittsburgh') AND team_id_2 = (SELECT id from teams where team_name = 'Colorado')),
77,48);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Harvard'),
(SELECT id from teams where team_name = 'Cincinnati'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Harvard') AND team_id_2 = (SELECT id from teams where team_name = 'Cincinnati')),
61,57);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Syracuse'),
(SELECT id from teams where team_name = 'Western Michigan'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Syracuse') AND team_id_2 = (SELECT id from teams where team_name = 'Western Michigan')),
77,53);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Oregon'),
(SELECT id from teams where team_name = 'Brigham Young'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Oregon') AND team_id_2 = (SELECT id from teams where team_name = 'Brigham Young')),
87,68);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Florida'),
(SELECT id from teams where team_name = 'Albany'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Florida') AND team_id_2 = (SELECT id from teams where team_name = 'Albany')),
67,55);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Michigan State'),
(SELECT id from teams where team_name = 'Delaware'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Michigan State') AND team_id_2 = (SELECT id from teams where team_name = 'Delaware')),
93,78);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Connecticut'),
(SELECT id from teams where team_name = 'St. Joseph''s'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Connecticut') AND team_id_2 = (SELECT id from teams where team_name = 'St. Joseph''s')),
89,81);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Michigan'),
(SELECT id from teams where team_name = 'Wofford'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Michigan') AND team_id_2 = (SELECT id from teams where team_name = 'Wofford')),
57,40);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'St. Louis'),
(SELECT id from teams where team_name = 'NC State'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'St. Louis') AND team_id_2 = (SELECT id from teams where team_name = 'NC State')),
83,80);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'North Dakota State'),
(SELECT id from teams where team_name = 'Oklahoma'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'North Dakota State') AND team_id_2 = (SELECT id from teams where team_name = 'Oklahoma')),
80,75);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Texas'),
(SELECT id from teams where team_name = 'Arizona State'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Texas') AND team_id_2 = (SELECT id from teams where team_name = 'Arizona State')),
87,85);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Villanova'),
(SELECT id from teams where team_name = 'Milwaukee'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Villanova') AND team_id_2 = (SELECT id from teams where team_name = 'Milwaukee')),
73,53);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Louisville'),
(SELECT id from teams where team_name = 'Manhattan'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Louisville') AND team_id_2 = (SELECT id from teams where team_name = 'Manhattan')),
71,64);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Dayton'),
(SELECT id from teams where team_name = 'Ohio State'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Dayton') AND team_id_2 = (SELECT id from teams where team_name = 'Ohio State')),
60,59);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'San Diego State'),
(SELECT id from teams where team_name = 'New Mexico State'),
'2014-03-20');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'San Diego State') AND team_id_2 = (SELECT id from teams where team_name = 'New Mexico State')),
73,69);



/* march 21 */

INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Mercer'),
(SELECT id from teams where team_name = 'Duke'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Mercer') AND team_id_2 = (SELECT id from teams where team_name = 'Duke')),
78,71);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Baylor'),
(SELECT id from teams where team_name = 'Nebraska'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Baylor') AND team_id_2 = (SELECT id from teams where team_name = 'Nebraska')),
74,60);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Stanford'),
(SELECT id from teams where team_name = 'New Mexico'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Stanford') AND team_id_2 = (SELECT id from teams where team_name = 'New Mexico')),
58,53);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Arizona'),
(SELECT id from teams where team_name = 'Weber State'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Arizona') AND team_id_2 = (SELECT id from teams where team_name = 'Weber State')),
68,59);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Tennessee'),
(SELECT id from teams where team_name = 'Massachusetts'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Tennessee') AND team_id_2 = (SELECT id from teams where team_name = 'Massachusetts')),
86,67);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Creighton'),
(SELECT id from teams where team_name = 'Louisiana-Lafayette'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Creighton') AND team_id_2 = (SELECT id from teams where team_name = 'Louisiana-Lafayette')),
76,66);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Kansas'),
(SELECT id from teams where team_name = 'Eastern Kentucky'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Kansas') AND team_id_2 = (SELECT id from teams where team_name = 'Eastern Kentucky')),
80,69);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Gonzaga'),
(SELECT id from teams where team_name = 'Oklahoma State'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Gonzaga') AND team_id_2 = (SELECT id from teams where team_name = 'Oklahoma State')),
85,77);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Memphis'),
(SELECT id from teams where team_name = 'George Washington'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Memphis') AND team_id_2 = (SELECT id from teams where team_name = 'George Washington')),
71,66);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'North Carolina'),
(SELECT id from teams where team_name = 'Providence'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'North Carolina') AND team_id_2 = (SELECT id from teams where team_name = 'Providence')),
79,77);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Wichita State'),
(SELECT id from teams where team_name = 'Cal Poly'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Wichita State') AND team_id_2 = (SELECT id from teams where team_name = 'Cal Poly')),
64,37);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Stephen F. Austin'),
(SELECT id from teams where team_name = 'Virginia Commonwealth'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Stephen F. Austin') AND team_id_2 = (SELECT id from teams where team_name = 'Virginia Commonwealth')),
77,75);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Virginia'),
(SELECT id from teams where team_name = 'Coastal Carolina'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Virginia') AND team_id_2 = (SELECT id from teams where team_name = 'Coastal Carolina')),
70,59);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Kentucky'),
(SELECT id from teams where team_name = 'Kansas State'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Kentucky') AND team_id_2 = (SELECT id from teams where team_name = 'Kansas State')),
56,49);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Iowa State'),
(SELECT id from teams where team_name = 'North Carolina Central'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Iowa State') AND team_id_2 = (SELECT id from teams where team_name = 'North Carolina Central')),
93,75);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'UCLA'),
(SELECT id from teams where team_name = 'Tulsa'),
'2014-03-21');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'UCLA') AND team_id_2 = (SELECT id from teams where team_name = 'Tulsa')),
76,59);



/* march 22 */

INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Florida'),
(SELECT id from teams where team_name = 'Pittsburgh'),
'2014-03-22');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Florida') AND team_id_2 = (SELECT id from teams where team_name = 'Pittsburgh')),
61,45);INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Louisville'),
(SELECT id from teams where team_name = 'St. Louis'),
'2014-03-22');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Louisville') AND team_id_2 = (SELECT id from teams where team_name = 'St. Louis')),
66,51);INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Michigan'),
(SELECT id from teams where team_name = 'Texas'),
'2014-03-22');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Michigan') AND team_id_2 = (SELECT id from teams where team_name = 'Texas')),
79,65);INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'San Diego State'),
(SELECT id from teams where team_name = 'North Dakota State'),
'2014-03-22');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'San Diego State') AND team_id_2 = (SELECT id from teams where team_name = 'North Dakota State')),
63,44);INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Dayton'),
(SELECT id from teams where team_name = 'Syracuse'),
'2014-03-22');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Dayton') AND team_id_2 = (SELECT id from teams where team_name = 'Syracuse')),
55,53);INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Wisconsin'),
(SELECT id from teams where team_name = 'Oregon'),
'2014-03-22');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Wisconsin') AND team_id_2 = (SELECT id from teams where team_name = 'Oregon')),
85,77);INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Michigan State'),
(SELECT id from teams where team_name = 'Harvard'),
'2014-03-22');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Michigan State') AND team_id_2 = (SELECT id from teams where team_name = 'Harvard')),
80,73);INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Connecticut'),
(SELECT id from teams where team_name = 'Villanova'),
'2014-03-22');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Connecticut') AND team_id_2 = (SELECT id from teams where team_name = 'Villanova')),
77,65);


/*  march 23 */
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Stanford'),
(SELECT id from teams where team_name = 'Kansas'),
'2014-03-23');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Stanford') AND team_id_2 = (SELECT id from teams where team_name = 'Kansas')),
60,57);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Kentucky'),
(SELECT id from teams where team_name = 'Wichita State'),
'2014-03-23');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Kentucky') AND team_id_2 = (SELECT id from teams where team_name = 'Wichita State')),
78,76);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Iowa State'),
(SELECT id from teams where team_name = 'North Carolina'),
'2014-03-23');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Iowa State') AND team_id_2 = (SELECT id from teams where team_name = 'North Carolina')),
85,83);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Tennessee'),
(SELECT id from teams where team_name = 'Mercer'),
'2014-03-23');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Tennessee') AND team_id_2 = (SELECT id from teams where team_name = 'Mercer')),
83,63);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'UCLA'),
(SELECT id from teams where team_name = 'Stephen F. Austin'),
'2014-03-23');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'UCLA') AND team_id_2 = (SELECT id from teams where team_name = 'Stephen F. Austin')),
77,60);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Baylor'),
(SELECT id from teams where team_name = 'Creighton'),
'2014-03-23');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Baylor') AND team_id_2 = (SELECT id from teams where team_name = 'Creighton')),
85,55);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Virginia'),
(SELECT id from teams where team_name = 'Memphis'),
'2014-03-23');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Virginia') AND team_id_2 = (SELECT id from teams where team_name = 'Memphis')),
78,60);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Arizona'),
(SELECT id from teams where team_name = 'Gonzaga'),
'2014-03-23');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Arizona') AND team_id_2 = (SELECT id from teams where team_name = 'Gonzaga')),
84,61);

/* march 27 */
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Dayton'),
(SELECT id from teams where team_name = 'Stanford'),
'2014-03-27');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Dayton') AND team_id_2 = (SELECT id from teams where team_name = 'Stanford')),
82,72);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Wisconsin'),
(SELECT id from teams where team_name = 'Baylor'),
'2014-03-27');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Wisconsin') AND team_id_2 = (SELECT id from teams where team_name = 'Baylor')),
69,52);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Florida'),
(SELECT id from teams where team_name = 'UCLA'),
'2014-03-27');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Florida') AND team_id_2 = (SELECT id from teams where team_name = 'UCLA')),
79,68);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Arizona'),
(SELECT id from teams where team_name = 'San Diego State'),
'2014-03-27');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Arizona') AND team_id_2 = (SELECT id from teams where team_name = 'San Diego State')),
70,64);

/* march 28 */
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Tennessee'),
(SELECT id from teams where team_name = 'Michigan'),
'2014-03-28');
INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Tennessee') AND team_id_2 = (SELECT id from teams where team_name = 'Michigan')),
71,73);

INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Connecticut'),
(SELECT id from teams where team_name = 'Iowa State'),
'2014-03-28');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Connecticut') AND team_id_2 = (SELECT id from teams where team_name = 'Iowa State')),
81,76);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Kentucky'),
(SELECT id from teams where team_name = 'Louisville'),
'2014-03-28');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Kentucky') AND team_id_2 = (SELECT id from teams where team_name = 'Louisville')),
74,69);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Michigan State'),
(SELECT id from teams where team_name = 'Virginia'),
'2014-03-28');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Michigan State') AND team_id_2 = (SELECT id from teams where team_name = 'Virginia')),
61,59);


/* march 29 */
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Florida'),
(SELECT id from teams where team_name = 'Dayton'),
'2014-03-29');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Florida') AND team_id_2 = (SELECT id from teams where team_name = 'Dayton')), 52,62);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Wisconsin'),
(SELECT id from teams where team_name = 'Arizona'),
'2014-03-29');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Wisconsin') AND team_id_2 = (SELECT id from teams where team_name = 'Arizona')),
64,63);



/* march 30 */
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Connecticut'),
(SELECT id from teams where team_name = 'Michigan State'),
'2014-03-30');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Connecticut') AND team_id_2 = (SELECT id from teams where team_name = 'Michigan State')),
60,62);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Kentucky'),
(SELECT id from teams where team_name = 'Michigan'),
'2014-03-30');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Kentucky') AND team_id_2 = (SELECT id from teams where team_name = 'Michigan')),
75, 72);

/* April 5 */
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Connecticut'),
(SELECT id from teams where team_name = 'Florida'),
'2014-04-05');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Connecticut') AND team_id_2 = (SELECT id from teams where team_name = 'Florida')),
63,53);
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Kentucky'),
(SELECT id from teams where team_name = 'Wisconsin'),
'2014-04-05');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Kentucky') AND team_id_2 = (SELECT id from teams where team_name = 'Wisconsin')),
74, 73);

/* April 7 */
INSERT INTO games (team_id_1,team_id_2,date_played)
VALUES(
(SELECT id from teams where team_name = 'Kentucky'),
(SELECT id from teams where team_name = 'Connecticut'),
'2014-04-07');
 INSERT INTO scores (game_id,score,score_2)
VALUES(
(SELECT id from games where team_id_1 = (SELECT id from teams where team_name = 'Kentucky') AND team_id_2 = (SELECT id from teams where team_name = 'Connecticut')),
54, 60);




CREATE VIEW TeamsGames as select team_name, date_played, a.id from (select * from games) as a inner join (select * from teams) as b on b.id = a.team_id_1 OR b.id = a.team_id_2;--Relation between Games and Teams, without scores

CREATE VIEW GamesScores as select * from TeamsGames join (select * from scores) as a on TeamsGames.id = a.game_id; --Relation between Games, Scores, and Teams to give the Teams that played which game whith what score

-- View: bracket_teams

-- DROP VIEW bracket_teams;

CREATE VIEW bracket_teams as (
with bracket_games as (
SELECT teams.id as team_id, team_name,seed,region,date_played from games,teams WHERE games.team_id_1 = teams.id
UNION
SELECT teams.id as team_id, team_name,seed,region,date_played from games,teams WHERE games.team_id_2 = teams.id ORDER BY seed ASC),
round1 as (SELECT 1 as round,team_id, team_name,seed,region from bracket_games where date_played = '2014-03-20' OR date_played = '2014-03-21'),
round2 as (SELECT 2 as round,team_id, team_name,seed,region from bracket_games where date_played = '2014-03-22' OR date_played = '2014-03-23'),
round3 as (SELECT 3 as round,team_id, team_name,seed,region from bracket_games where date_played = '2014-03-27' OR date_played = '2014-03-28'),
round4 as (SELECT 4 as round,team_id, team_name,seed,region from bracket_games where date_played = '2014-03-29' OR date_played = '2014-03-30'),
round5 as (SELECT 5 as round,team_id, team_name,seed,region from bracket_games where date_played = '2014-04-05'),
round6 as (SELECT 6 as round,team_id, team_name,seed,region from bracket_games where date_played = '2014-04-07')
  
select * from round1
UNION
select * from round2
UNION 
select * from round3
UNION 
select * from round4
UNION 
select * from round5
UNION 
select * from round6
UNION
select 7 as round, team_id, team_name,seed,region from bracket_games where team_id = 39);
