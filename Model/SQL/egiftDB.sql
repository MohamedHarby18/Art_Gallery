CREATE TABLE egift (
  egiftID int NOT NULL PRIMARY KEY,
  userID int DEFAULT NULL,
  amount decimal(10,2) NOT NULL,
  recipientEmail varchar(255) NOT NULL,
  FOREIGN KEY (userID) REFERENCES customer (idCustomer) ON DELETE SET NULL
)