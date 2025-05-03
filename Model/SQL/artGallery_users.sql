CREATE TABLE[role](
    idROLE INT NOT NULL PRIMARY KEY,
    nameROLE NVARCHAR(20),
)

CREATE TABLE users(
    idUSER INT NOT NULL PRIMARY KEY,
    username NVARCHAR(50),
    email NVARCHAR(50),
    [password] NVARCHAR(50),
    [location] NVARCHAR(100),
    roletype INT REFERENCES [role] (idROLE),
)

CREATE TABLE artist(
    idArtist INT PRIMARY KEY,
    [description] NVARCHAR(500),
    FOREIGN KEY (idArtist) REFERENCES [users](idUSER)
)

CREATE TABLE customer (
    idCustomer INT PRIMARY KEY,
    discountCode NVARCHAR(50),  
    FOREIGN KEY (idCustomer) REFERENCES users(idUSER)
)

CREATE TABLE admin (
    idAdmin INT PRIMARY KEY,
    FOREIGN KEY (idAdmin) REFERENCES users(idUSER)
)