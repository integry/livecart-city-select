# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v5.2.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          city-select.dez                                 #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2009-12-22 01:27                                #
# Model version:         Version 2009-12-22                              #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "City"                                                       #
# ---------------------------------------------------------------------- #

CREATE TABLE `City` (
    `ID` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    `stateID` INTEGER UNSIGNED NOT NULL,
    `code` CHAR(15) NOT NULL,
    `name` VARCHAR(100),
    CONSTRAINT `PK_City` PRIMARY KEY (`ID`)
) ENGINE=INNODB;

ALTER TABLE `UserAddress` ADD COLUMN `cityID` INTEGER UNSIGNED;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `City` ADD CONSTRAINT `State_City` 
    FOREIGN KEY (`stateID`) REFERENCES `State` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `UserAddress` ADD CONSTRAINT `City_UserAddress` 
    FOREIGN KEY (`cityID`) REFERENCES `City` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;
