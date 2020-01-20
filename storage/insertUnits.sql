INSERT INTO units (unit_code) VALUES
('Gal'),
('Ltr'),
('Btl'),
('Can'),
('Pcs'),
('Bag'),
('Sck'),
('Set'),
('Rol'),
('Grs'),
('Doz'),
('Pck'),
('Tin'),
('Prs'),
('Ft'),
('Box'),
('Kls'),
('Pc'),
('Mtr'),
('L/F'),
('Uni'),
('Pvs'),
('Spl'),
('Ro');


SELECT i.itemno,i.itemdesc,t.id,u.id
FROM itemcatalog AS i
INNER JOIN units as u
ON i.unit_id = u.unit_code
INNER JOIN item_types as t
ON i.item_type_id = t.type;

SELECT i.itemno,i.itemdesc,t.id,u.id
FROM itemcatalog AS i
INNER JOIN units as u
ON i.unit_id = u.unit_code

SELECT i.id,i.itemdesc,t.type,u.unit_code
FROM item_catalog AS i
INNER JOIN units as u
ON i.unit_id = u.id
INNER JOIN item_types as t
ON i.item_type_id = t.id;


USE rgmcs_warehouse_encoder_db;
CREATE OR REPLACE VIEW rgmcs_warehouse_encoder_db.item_overview AS SELECT s.itemno,i.itemdesc,u.unit_code AS unit,t.type,s.qty,w.price AS unit_cost
FROM rgmcs_warehouse_encoder_db.stocks AS s
INNER JOIN rgmcs_references_db.item_catalog as i
ON s.itemno = i.itemno
INNER JOIN rgmcs_references_db.units as u
ON i.unit_id = u.id
INNER JOIN rgmcs_references_db.item_types as t
ON i.item_type_id = t.id
INNER JOIN rgmcs_warehouse_encoder_db.pricelist AS w
ON s.itemno = w.itemno;


USE rgmcs_warehouse_encoder_db;
CREATE OR REPLACE VIEW rgmcs_warehouse_encoder_db.item_overview AS SELECT l.itemno,l.itemdesc,l.unit_id,l.item_type_id,s.qty,w.price AS unit_cost
FROM rgmcs_warehouse_encoder_db.stocks AS s
INNER JOIN rgmcs_references_db.itemcatalog as l
ON s.itemno = l.itemno
INNER JOIN rgmcs_warehouse_encoder_db.pricelist AS w
ON s.itemno = w.itemno;

USE rgmcs_warehouse_encoder_db;
CREATE OR REPLACE VIEW rgmcs_warehouse_encoder_db.item_overview AS SELECT l.itemno,l.itemdesc,l.unit_id,l.item_type_id,s.qty,w.price AS unit_cost
FROM rgmcs_references_db.itemcatalog as l
INNER JOIN rgmcs_warehouse_encoder_db.stocks AS s
ON s.itemno = l.itemno
INNER JOIN rgmcs_warehouse_encoder_db.pricelist AS w
ON s.itemno = w.itemno;

USE rgmcs_warehouse_encoder_db;
CREATE OR REPLACE VIEW rgmcs_warehouse_encoder_db.item_overview_view AS SELECT l.id,l.itemdesc,l.unit_code,l.type,s.qty AS qty
FROM rgmcs_references_db.item_list_view as l
INNER JOIN rgmcs_warehouse_encoder_db.stocks AS s
ON s.itemno = l.id
-- INNER JOIN rgmcs_warehouse_encoder_db.price_list AS w
-- ON l.id = w.itemno;

CREATE OR REPLACE VIEW cart_overview_view AS
SELECT c.id,c.transaction_type,c.name,c.itemno,r.itemdesc,c.vendor,c.unit_cost,c.qtyin,c.qtyout,c.tdate,c.created_at
FROM rgmcs_warehouse_encoder_db.cart AS c
INNER JOIN rgmcs_references_db.item_list_view AS r
ON c.itemno = r.id

CREATE OR REPLACE VIEW transactions_overview_view AS
SELECT t.id,t.transaction_type,t.name,t.itemno,r.itemdesc,t.vendor,t.unit_cost,t.qtyin,t.qtyout,t.qtyoh,t.tdate,t.created_at
FROM rgmcs_warehouse_encoder_db.transactions AS t   
INNER JOIN rgmcs_references_db.item_list_view AS r
ON t.itemno = r.id


-- IF WAREHOUSE
CREATE OR REPLACE VIEW stocks_overview_view AS
SELECT r.id,r.itemdesc,r.unit_code,r.type,s.qty
FROM rgmcs_warehouse_encoder_db.stocks AS s   
INNER JOIN rgmcs_references_db.item_list_view AS r
ON s.itemno = r.id;







USE rgmcs_renes_encoder_db;
CREATE OR REPLACE VIEW rgmcs_renes_encoder_db.item_overview AS SELECT s.itemno,i.itemdesc,u.unit_code AS unit,t.type,s.qty,w.price AS unit_cost
FROM rgmcs_renes_encoder_db.stocks AS s
INNER JOIN rgmcs_references_db.item_catalog as i
ON s.itemno = i.itemno
INNER JOIN rgmcs_references_db.units as u
ON i.unit_id = u.id
INNER JOIN rgmcs_references_db.item_types as t
ON i.item_type_id = t.id
INNER JOIN rgmcs_warehouse_encoder_db.pricelist AS w
ON s.itemno = w.itemno;


USE rgmcs_redor_encoder_db;
CREATE OR REPLACE VIEW rgmcs_redor_encoder_db.item_overview AS SELECT s.itemno,i.itemdesc,u.unit_code AS unit,t.type,s.qty,w.price AS unit_cost
FROM rgmcs_redor_encoder_db.stocks AS s
INNER JOIN rgmcs_references_db.item_catalog as i
ON s.itemno = i.itemno
INNER JOIN rgmcs_references_db.units as u
ON i.unit_id = u.id
INNER JOIN rgmcs_references_db.item_types as t
ON i.item_type_id = t.id
INNER JOIN rgmcs_warehouse_encoder_db.pricelist AS w
ON s.itemno = w.itemno;


USE rgmcs_renes_cashier_db;
CREATE OR REPLACE VIEW rgmcs_renes_cashier_db.item_overview AS SELECT s.itemno,i.itemdesc,u.unit_code AS unit,t.type,s.qty,w.price AS unit_cost
FROM rgmcs_renes_cashier_db.stocks AS s
INNER JOIN rgmcs_references_db.item_catalog as i
ON s.itemno = i.itemno
INNER JOIN rgmcs_references_db.units as u
ON i.unit_id = u.id
INNER JOIN rgmcs_references_db.item_types as t
ON i.item_type_id = t.id
INNER JOIN rgmcs_warehouse_encoder_db.pricelist AS w
ON s.itemno = w.itemno;


INSERT INTO `scpfailedjobs` (`datetimeoffailure`, `datetimeoftransaction`, `referenceid`, `cif`, `crn`, `accountnumber`, `lastname`, `middlename`, `firstname`, `birthdate`, `solid`, `jobcode`, `jobdescription`, `document`, `documenttypeid`, `sssnumber`, `cardtype`, `additionalpayload`, `processeddatetime`) 
VALUES
('2020-01-10 07:34:35', '2020-01-10 07:32:21', '9dd43228-9b69-4580-a6d3-82609e71a20a', 'R910000742', '003364889430', '109830014330', 'ESGUERRA JR', 'ADOR DIONISIO', 'DANTE', '1974-12-23', '1015', 'Upload_SFTP', 'Failed to upload file to SFTP', 798471, NULL, '3364889430', 'QCAO', NULL, NULL),
('2020-01-10 07:35:35', '2020-01-10 07:32:21', '9dd43228-9b69-4580-a6d3-82609e71a20a', 'R910000742', '003364889430', '109830014330', 'ESGUERRA JR', 'ADOR DIONISIO', 'DANTE', '1974-12-23', '1015', 'Upload_EDMS', 'Failed to upload file to EDMS', 567983, 194, '3364889430', 'QCAO', NULL, NULL),
('2020-01-10 07:35:37', '2020-01-10 07:32:21', '9dd43228-9b69-4580-a6d3-82609e71a20a', 'R910000742', '003364889430', '109830014330', 'ESGUERRA JR', 'ADOR DIONISIO', 'DANTE', '1974-12-23', '1015', 'Upload_EDMS', 'Failed to upload file to EDMS', 345987, 195, '3364889430', 'QCAO', NULL, NULL),
('2020-01-10 07:35:39', '2020-01-10 07:32:21', '9dd43228-9b69-4580-a6d3-82609e71a20a', 'R910000742', '003364889430', '109830014330', 'ESGUERRA JR', 'ADOR DIONISIO', 'DANTE', '1974-12-23', '1015', 'Upload_EDMS', 'Failed to upload file to EDMS', 123456, 15, '3364889430', 'QCAO', NULL, NULL),
('2020-01-10 07:35:41', '2020-01-10 07:32:21', '9dd43228-9b69-4580-a6d3-82609e71a20a', 'R910000742', '003364889430', '109830014330', 'ESGUERRA JR', 'ADOR DIONISIO', 'DANTE', '1974-12-23', '1015', 'Upload_EDMS', 'Failed to upload file to EDMS', 048593, 251, '3364889430', 'QCAO', NULL, NULL),
('2020-01-10 07:35:43', '2020-01-10 07:32:21', '9dd43228-9b69-4580-a6d3-82609e71a20a', 'R910000742', '003364889430', '109830014330', 'ESGUERRA JR', 'ADOR DIONISIO', 'DANTE', '1974-12-23', '1015', 'Upload_EDMS', 'Failed to upload file to EDMS', 234859, 193, '3364889430', 'QCAO', NULL, NULL),
('2020-01-10 07:35:45', '2020-01-10 07:32:21', '9dd43228-9b69-4580-a6d3-82609e71a20a', 'R910000742', '003364889430', '109830014330', 'ESGUERRA JR', 'ADOR DIONISIO', 'DANTE', '1974-12-23', '1015', 'Upload_EDMS', 'Failed to upload file to EDMS', 294738, 194, '3364889430', 'QCAO', NULL, NULL),
('2020-01-10 07:35:47', '2020-01-10 07:32:21', '9dd43228-9b69-4580-a6d3-82609e71a20a', 'R910000742', '003364889430', '109830014330', 'ESGUERRA JR', 'ADOR DIONISIO', 'DANTE', '1974-12-23', '1015', 'Upload_SVS', 'Failed to upload file to SVS', 346539, NULL, '3364889430', 'QCAO', NULL, NULL),
('2020-01-10 07:37:20', '2020-01-10 07:32:21', '9dd43228-9b69-4580-a6d3-82609e71a20a', 'R910000742', '003364889430', '109830014330', 'ESGUERRA JR', 'ADOR DIONISIO', 'DANTE', '1974-12-23', '1015', 'Upload_SVS', 'Failed to upload file to SVS', 346539, NULL, '3364889430', 'QCAO', NULL, NULL),
('2020-01-10 07:41:34', '2020-01-10 07:32:21', '9dd43228-9b69-4580-a6d3-82609e71a20a', 'R910000742', '003364889430', '109830014330', 'ESGUERRA JR', 'ADOR DIONISIO', 'DANTE', '1974-12-23', '1015', 'Upload_SVS', 'Failed to upload file to SVS', 346539, NULL, '3364889430', 'QCAO', NULL, NULL);







