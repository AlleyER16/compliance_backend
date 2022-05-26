/*Database compliance*/

CREATE TABLE employees(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Picture VARCHAR(100) NULL,
    FirstName VARCHAR(100) NOT NULL,
    LastName VARCHAR(100) NOT NULL,
    Gender ENUM("Male", "Female") NOT NULL,
    Address VARCHAR(100) NULL,
    TownOrCity VARCHAR(100) NULL,
    EmailAddress VARCHAR(100) UNIQUE NULL,
    TelephoneNumber VARCHAR(20) UNIQUE NULL,
    NationalInsurance VARCHAR(50) NULL,
    SIALicense VARCHAR(50) NULL,
    PIN VARCHAR(10) NULL,
    ImmigrationStatus ENUM("Student", "None Student") NULL,
    BankSortCode VARCHAR(50) NULL,
    AccountNumber VARCHAR(20) NULL,
    AccountName VARCHAR(100) NULL,
    IDCard VARCHAR(100) NULL,
    ProofOfAddress VARCHAR(100) NULL,
    Username VARCHAR(50) UNIQUE NOT NULL,
    Password VARCHAR(100) NOT NULL,
    Status INT NOT NULL DEFAULT(0)
);

CREATE TABLE employees_reference(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Employee INT NOT NULL,
    FirstName VARCHAR(100) NOT NULL,
    LastName VARCHAR(100) NOT NULL,
    TelephoneNumber VARCHAR(20) NOT NULL,
    EmailAddress VARCHAR(100) NOT NULL,
    FOREIGN KEY (Employee) REFERENCES employees(ID)
);