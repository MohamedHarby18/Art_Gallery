CREATE TABLE artFair (
  artFairID int NOT NULL PRIMARY KEY,
  [name] varchar(255) NOT NULL,
  [location] varchar(255) DEFAULT NULL,
  [date] date DEFAULT NULL,
  artistID int DEFAULT NULL,
  FOREIGN KEY (artistID) REFERENCES artist (idArtist) ON DELETE SET NULL
)