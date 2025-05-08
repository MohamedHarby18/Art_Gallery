CREATE TABLE virtualgalleries (
  galleryID int NOT NULL PRIMARY KEY,
  artistID int DEFAULT NULL,
  [date] date DEFAULT NULL,
  FOREIGN KEY (artistID) REFERENCES artist (idArtist) ON DELETE SET NULL
)