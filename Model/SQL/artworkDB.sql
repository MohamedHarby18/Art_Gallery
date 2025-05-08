CREATE TABLE artworks (
  artworkID int NOT NULL PRIMARY KEY,
  title varchar(255) NOT NULL,
  [description] text NOT NULL,
  catagory varchar(255) NOT NULL,
  price decimal(10,2) NOT NULL,
  rate int DEFAULT '0',
  [image] text NOT NULL,
  artistID int DEFAULT NULL,
  FOREIGN KEY (artistID) REFERENCES artist (idArtist) ON DELETE SET NULL
)