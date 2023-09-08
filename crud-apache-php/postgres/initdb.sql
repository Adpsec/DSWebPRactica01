CREATE USER myuser; 
CREATE DATABASE mydb;
GRANT ALL PRIVILEGES ON DATABASE mydb to myuser; 
ALTER DATABASE mydb OWNER to myuser;

\connect mydb 
CREATE TABLE ejemplo
(
    clave integer NOT NULL,
    nombre character varying,
    direccion character varying,
    telefono character varying,
    CONSTRAINT pk_clave PRIMARY KEY (clave)
);

ALTER TABLE ejemplo OWNER to myuser;