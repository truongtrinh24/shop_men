TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER before_insert_customer\nBEFORE INSERT ON customer\nFOR EACH ROW\nBEGIN\n    DECLARE new_id INT;\n    SET new_id = (SELECT COUNT(*) FROM customer) + 1;\n    SET NEW.customer_id = CONCAT(\'KH\', LPAD(new_id, 2, \'0\'));\nEND'
sql_modes=524288
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_unicode_ci'
db_cl_names='utf8mb4_general_ci'
created=1713712781478702
