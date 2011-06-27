# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v5.2.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          city-select.dez                                 #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2009-12-22 01:27                                #
# Model version:         Version 2009-12-22                              #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `City` DROP FOREIGN KEY `State_City`;

ALTER TABLE `UserAddress` DROP FOREIGN KEY `City_UserAddress`;

# ---------------------------------------------------------------------- #
# Drop table "City"                                                      #
# ---------------------------------------------------------------------- #

ALTER TABLE `UserAddress` DROP COLUMN `cityID`;

# Remove autoinc for PK drop #

ALTER TABLE `City` MODIFY `ID` INTEGER UNSIGNED NOT NULL;

# Drop constraints #

ALTER TABLE `City` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `City`;

