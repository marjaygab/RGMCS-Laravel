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
CREATE OR REPLACE VIEW rgmcs_warehouse_encoder_db.item_overview AS SELECT l.itemno,l.itemdesc,l.unit_id,l.item_type_id,s.qty AS qty
FROM rgmcs_references_db.itemcatalog as l
INNER JOIN rgmcs_warehouse_encoder_db.stocks AS s
ON s.itemno = l.itemno





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





