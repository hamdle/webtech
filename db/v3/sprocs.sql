DROP PROCEDURE IF EXISTS addColumn;

DELIMITER //
CREATE PROCEDURE addColumn(IN tableName VARCHAR(255), IN newColumnName VARCHAR(255), IN columnDefinition VARCHAR(255))
BEGIN
    DECLARE DOES_COLUMN_EXIST INT;
    SELECT COUNT(*)
    INTO DOES_COLUMN_EXIST
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
        table_name = tableName
        AND column_name = newColumnName;

    IF DOES_COLUMN_EXIST = 0 THEN
        SET @query = CONCAT('ALTER TABLE ', tableName, ' ADD COLUMN ', newColumnName, ' ', columnDefinition);
        PREPARE stmt FROM @query;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
    END IF;
END //
DELIMITER ;