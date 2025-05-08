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
    idRole INT,
    Foreign Key (idRole) REFERENCES [role] (idRole) ,
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

CREATE TABLE [admin] (
    idAdmin INT PRIMARY KEY,
    FOREIGN KEY (idAdmin) REFERENCES users(idUSER)
)

INSERT INTO [role] (idROLE, nameROLE) VALUES
(1, 'artist'),
(2, 'customer'),
(3, 'admin'),
(4, 'advisor');

-- Insert users
INSERT INTO users (idUSER, username, email, [password], [location], idRole) VALUES
(1, 'artist_john', 'john@example.com', 'password123', 'New York', 1),
(2, 'painter_mary', 'mary@example.com', 'securepass', 'London', 1),
(3, 'art_lover', 'customer1@example.com', 'customerpass', 'Berlin', 2),
(4, 'collector_max', 'max@example.com', 'max1234', 'Paris', 2),
(5, 'admin_alex', 'alex@example.com', 'adminpass123', 'Tokyo', 3);

-- Insert artists (must be users with idRole = 1)
INSERT INTO artist (idArtist, [description]) VALUES
(1, 'Contemporary abstract painter from New York'),
(2, 'Traditional portrait artist based in London');

-- Insert customers (must be users with idRole = 2)
INSERT INTO customer (idCustomer, discountCode) VALUES
(3, 'WELCOME10'),
(4, 'ARTLOVER15');

-- Insert admins (must be users with idRole = 3)
INSERT INTO [admin] (idAdmin) VALUES
(5);