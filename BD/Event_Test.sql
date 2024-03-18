
DELIMITER //
CREATE EVENT create_test_of_the_day
ON SCHEDULE
    EVERY 1 DAY
    STARTS CURRENT_TIMESTAMP
DO
BEGIN
    DECLARE today DATE;
    SET today = CURDATE();

    INSERT INTO test_of_the_day (idTest, date)
    SELECT idTest, CURDATE()
    FROM (
        SELECT idTest, COUNT(*) AS total_responses
        FROM user_answers
        WHERE date >= DATE_SUB(today, INTERVAL 7 DAY) -- Filtrar respuestas de la última semana
        GROUP BY idTest
        ORDER BY total_responses DESC -- Ordenar por la cantidad de respuestas
    ) AS top_tests
    LEFT JOIN test_of_the_day tod ON top_tests.idTest = tod.idTest
    WHERE tod.idTestOfTheDay IS NULL -- Filtrar test que aún no están en test_of_the_day
    LIMIT 1; -- Seleccionar solo el primer test disponible que no está en test_of_the_day
END //

DELIMITER ;
