create database masterquiz;

DROP TABLE reponse;
DROP TABLE question;
DROP TABLE quiz;
DROP TABLE user;


CREATE TABLE user (
	UserID INTEGER NOT NULL AUTO_INCREMENT,
	Nom VARCHAR(20),
	Mdp VARCHAR(255),
	Email VARCHAR(20),
	Administrateur BOOLEAN,
	PRIMARY KEY (UserID)
);

CREATE TABLE quiz (
    QuizID INTEGER NOT NULL AUTO_INCREMENT,
	UserID INTEGER,
    Nom VARCHAR(30),
    Theme VARCHAR(30),
    Descrip VARCHAR(100),
    Creation DATE,
	Public BOOLEAN,
	PRIMARY KEY (QuizID),
    FOREIGN KEY (UserID) REFERENCES user(UserID) ON DELETE CASCADE 
);

CREATE TABLE question (
	QuestionID INTEGER NOT NULL AUTO_INCREMENT,
	QuizID INTEGER,
	Question VARCHAR(100),

	PRIMARY KEY (QuestionID),
    FOREIGN KEY (QuizID) REFERENCES quiz(QuizID) ON DELETE CASCADE 
);

CREATE TABLE reponse (
	ReponseID INTEGER NOT NULL AUTO_INCREMENT,
	QuestionID INTEGER,
	Reponse VARCHAR(100),
	ReponseVrai INTEGER,

	PRIMARY KEY (ReponseID),
    FOREIGN KEY (QuestionID) REFERENCES question(QuestionID) ON DELETE CASCADE 
);


INSERT INTO user VALUES (1, "admin", "$1$.uEj.keU$DypM276Z7MaGcQz8A06Ca0", "email@mail.com", 1);



/*
INSERT INTO quiz (UserId, Nom, Theme, Descrip, Creation, Public) VALUES (1,"Star Wars", "cinema", "Etes vous un fan de star wars ?", '2019-11-12', 1);
INSERT INTO quiz (UserId, Nom, Theme, Descrip, Creation, Public) VALUES (1, "Les Mathématiques", "sciences", "Revenons sur les bases des mathématiques", '2019-11-12', 1);
INSERT INTO quiz (UserId, Nom, Theme, Descrip, Creation, Public) VALUES (1, "Calculabilité", "sciences", "Avez vous appris votre cours ?", '2019-11-12', 1);
INSERT INTO quiz (UserId, Nom, Theme, Descrip, Creation, Public) VALUES (1, "Star Treck", "cinema", "Saurez vous trouvez les bonnes citations ?", '2019-11-12', 1);
INSERT INTO quiz (UserId, Nom, Theme, Descrip, Creation, Public) VALUES (1, "Jeux Vidéos rétro", "jeu-vidéo", "Trouvez la date de sortie de ses jeux rétro", '2019-11-12', 0);
INSERT INTO quiz (UserId, Nom, Theme, Descrip, Creation, Public) VALUES (1, "Les Matrices", "sciences", "Petit Quiz sur les math", '2019-11-12', 1);
INSERT INTO quiz (UserId, Nom, Theme, Descrip, Creation, Public) VALUES (1, "L''ordinateur quantique", "sciences", "Qu''est ce qui est vrai sur les ordinateurs quantiques", '2019-11-12', 1);
INSERT INTO quiz (UserId, Nom, Theme, Descrip, Creation, Public) VALUES (1, "Les expressions francaise", "autres", "Trouvez d''ou viens le sens de cette expression", '2019-11-12', 1);
INSERT INTO quiz (UserId, Nom, Theme, Descrip, Creation, Public) VALUES (1, "C'est un super quiz", "autres", "une description superbe", '2019-11-12', 1);
INSERT INTO quiz (UserId, Nom, Theme, Descrip, Creation, Public) VALUES (1, "Mon second quiz génial", "autres", "tu la tellement bien décrit", '2019-11-12', 1);


INSERT INTO question (QuizID, Question) VALUES (1,'Quel personnages viens de Star Wars épisode I');
INSERT INTO question (QuizID, Question) VALUES (1,'Quel personnages viens de Star Wars épisode II');
INSERT INTO question (QuizID, Question) VALUES (1,'Quel personnages viens de Star Wars épisode III');

INSERT INTO reponse VALUES ( 1, 1, 'Anakin Skywalker', 1);
INSERT INTO reponse VALUES ( 2, 1, 'SuperMan', 0);
INSERT INTO reponse VALUES ( 3, 1, 'Le Joker', 0);*/
