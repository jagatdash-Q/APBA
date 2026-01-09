

-- Normal delete by getting nomination uuid

START TRANSACTION;

DELETE FROM nomination_positions
WHERE nomination_uuid = 'a59396b7-0949-43a0-9b21-c55f6b919b81';

DELETE FROM nominations
WHERE uuid = 'a59396b7-0949-43a0-9b21-c55f6b919b81';


-- Delete all the nominations by checking if nomination has not started

START TRANSACTION;


DELETE FROM nomination_positions
WHERE id IN (
    SELECT id FROM (
        SELECT np.id
        FROM nomination_positions np
        JOIN nominations n ON np.nomination_uuid = n.uuid
        WHERE n.start_date > CURRENT_DATE
    ) AS temp_ids
);


DELETE FROM nominations
WHERE start_date > CURRENT_DATE and id>0;

COMMIT;




-- Delete all the nominations by checking if nomination has not started as well as if customer not nominated anyone


START TRANSACTION;

SET SQL_SAFE_UPDATES = 0;


DELETE FROM nomination_positions
WHERE nomination_uuid IN (
    SELECT uuid FROM (
        SELECT n.uuid
        FROM nominations n
        LEFT JOIN customer_nominations cn ON cn.nomination_uuid = n.uuid
        WHERE n.start_date > CURRENT_DATE
          AND cn.nomination_uuid IS NULL
    ) AS temp_nominations
);

DELETE FROM nominations
WHERE uuid IN (
    SELECT uuid FROM (
        SELECT n.uuid
        FROM nominations n
        LEFT JOIN customer_nominations cn ON cn.nomination_uuid = n.uuid
        WHERE n.start_date > CURRENT_DATE
          AND cn.nomination_uuid IS NULL
    ) AS temp_nominations
);

SET SQL_SAFE_UPDATES = 1;

COMMIT;

