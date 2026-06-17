create table solma_usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    ipn varchar(20) not null,
    usuario varchar(255) not null,
    uet varchar(255) not null,
    turno_fabricacion varchar(40),
    taller varchar(40),
    troncon varchar(40),
    turno varchar(40),
    jt_id int,
    foreign key (jt_id) references solma_jt(id)
);
create table solma_jt (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(255) not null,
    ipn varchar(20) not null unique
);
/*
create table solma_form(
    id int auto_increment primary key,
    uet varchar(255) not null,
    turno_fabricacion varchar(40),
    responsable varchar(255),
    fecha date,

    consumo_agua int,
    consumo_energia int,

    rnp_segregacion_residuos int,
    rnp_identificacion int,
    rnp_colores_bolsas int,
    rnp_sobrellenado int,
    rnp_metalicos_altvalor int,

    rp_segregacion_residuos int,
    rp_identificacion int,
    rp_proceso_segregacion int,
    rp_almacen int,
    rp_almacenado_compatibilidad int,
    rp_cartografia int,
    rp_formacion_especifica int,

    pq_formacion_relativa_riesgo int,
    pq_personal_formados int,
    pq_identificados_correctamente int,
    pq_almacenados_compatibilidad int,

    pqee_uet_empresas int,
    pqee_listado_autorizados int,
    
    adr_personal_pq int,
    adr_persona_renault int,
    adr_documentacion int,
    adr_consignias int,
    kt_ubicacion int,
    kt_identficacion int,
    suelos_zr_limpias int,
    suelos_zr_sin_derrames int,
    suelos_zr_sin_fisuras int,
    proxima_evaluacion date,
    estado varchar(20),
    necesidad_plan_accion varchar(25),
    mes_realizacion varchar(20)
);
*/
/*
create table solma_plan_accion(
    id int auto_increment primary key,
    uet varchar(50) not null,
    turno varchar(40) not null,
    estado varchar(20) not null,
    aspecto_ambiental varchar(255) not null,
    demerito varchar(300),
    acciones varchar(500),
    piloto varchar(100),
    fecha_cierre date,
    estado_cierre varchar(20)
);
*/


ALTER TABLE solma_usuarios
ADD admin TINYINT(1) DEFAULT 0;


ALTER TABLE solma_usuarios
ADD rol ENUM('JU','JT','auditor') DEFAULT 'JU';

create table solma_criterios(
    id int auto_increment primary key,
    criterio_num varchar(100) not null,
    criterio_nombre varchar(250) not null,
    nota varchar(250) not null,
    boton_info varchar(200) not null,
    pregunta_num varchar(10) not null
);

INSERT INTO solma_criterios 
(criterio_num, criterio_nombre, nota, boton_info, pregunta_num)
VALUES 
('Criterio 1', 'Sin fugas de agua, ni válvulas ni grifos abiertos', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'CONSUMO DE AGUA', '1'),
('Criterio 2', 'No existen fugas de aire comprimido ni instalaciones y/o alumbrado en funcionamiento sin ser necesario', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'CONSUMO DE ENERGÍA', '2'),
('Criterio 3', 'El proceso de segregación de los residuos es respetado al 100%', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'RESIDUOS NO PELIGROSOS (RNP)','3.1'),
('Criterio 4', 'Todos los residuos están correctamente identificados', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'RESIDUOS NO PELIGROSOS (RNP)', '3.2'),
('Criterio 5', 'Se respeta al 100% el código de colores de las bolsa', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'RESIDUOS NO PELIGROSOS (RNP)', '3.3'),
('Criterio 6', 'No existe sobrellenado', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'RESIDUOS NO PELIGROSOS (RNP)', '3.4'),
('Criterio 7', 'Todos los residuos metálicos de alto valor están correctamente securizados (tapa y candado)', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'RESIDUOS NO PELIGROSOS (RNP)', '3.5'),
('Criterio 8', 'El proceso de segregación de los RPs es respetado al 100%', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'RESIDUOS PELIGROSOS (RP)','4.1'),
('Criterio 9', 'El 100% de los RPs está correctamente identificados y la etiqueta es legible', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'RESIDUOS PELIGROSOS (RP)','4.2'),
('Criterio 10', 'Ningún RP se encuentra a la intemperie y están almacenados sobre suelo en perfectas condiciones (hormigonado)', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'RESIDUOS PELIGROSOS (RP)','4.3'),
('Criterio 11', 'Todos los RPs líquidos se encuentra almacenados sobre cubeto de retencion adecuado al residuo, capacitario, estanco y sin presencia de derrames/fugas', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'RESIDUOS PELIGROSOS (RP)','4.4'),
('Criterio 12', 'Todos los RPs se encuentran almacenados respetando las reglas de compatibilidad', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'RESIDUOS PELIGROSOS (RP)','4.5'),
('Criterio 13', 'Existe cartografía (estado 5S de referencia) y es respetada al 100%', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'RESIDUOS PELIGROSOS (RP)', '4.6'),
('Criterio 14', 'Todas las personas que manipulan RPs han recibido una formación específica', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'RESIDUOS PELIGROSOS (RP)','4.7'),
('Criterio 15', 'El 100% de los puestos utilizadores de PQs están identificados', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'PRODUCTOS QUÍMICOS (PQ)','5.1'),
('Criterio 16', 'El 100% del personal que trabaja en puestos utilizadores de PQs han recibido una formación relativa al riesgo químico', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'PRODUCTOS QUÍMICOS (PQ)','5.2'),
('Criterio 17', 'El 100% de los PQs utilizados en la UET están autorizados y tienen la Ficha de Producto Químico (FPQ)', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'PRODUCTOS QUÍMICOS (PQ)','5.3'),
('Criterio 18', 'El 100% de los PQs están correctamente identificados y disponen de retención capacitaria, adecuada al PQ, etiquetada (volumen de retención y color),  estanca y sin presencia de derrames', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'PRODUCTOS QUÍMICOS (PQ)', '5.4'),
('Criterio 19', 'El 100% de los PQs son almacenados según las reglas de compatibilidad', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'PRODUCTOS QUÍMICOS (PQ)','5.5'),
('Criterio 20', 'Todos los PQs utilizados en la UET por empresas externas están autorizados', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'PRODUCTOS QUÍMICOS (PQ) EMPRESAS EXTERNAS','6.1'),
('Criterio 21', 'La empresa externa dispone del Listado de PQs autorizados por Renault y de las Fichas de Datos de Seguridad (FDS)', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'PRODUCTOS QUÍMICOS (PQ) EMPRESAS EXTERNAS','6.2'),
('Criterio 22', 'El personal conoce los PQs/Residuos afectados por el ADR utilizados/generados en la Sección/UET', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'ADR','7.1'),
('Criterio 23', 'Siempre hay una persona de Renault debidamente formada, presente en las operaciones de carga/descarga', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'ADR','7.2'),
('Criterio 24', 'Se disponen de las consignas y documentación necesaria.', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'ADR','7.3'),
('Criterio 25', 'Se respetan las consignas', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'ADR','7.4'),
('Criterio 26', 'Está ubicado correctamente (visible y accesible)', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'KIT EMERGENCIA','8.1'),
('Criterio 27', 'Está identificado y completo', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'KIT EMERGENCIA','8.2'),
('Criterio 28', 'Zonas de retención (cubetos, bandejas, canaletas, perimetrales,…) limpias (sin suciedad, hojas,…)', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'SUELOS','9.1'),
('Criterio 29', 'Suelo y zonas de retención (cubetos, bandejas, canaletas, perimetrales,…) sin presencia de derrames', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'SUELOS','9.2'),
('Criterio 30', 'Suelo impermeabilizado sin fisuras/grietas', 'Nota: 0- Situación conforme; 1-Situación mejorable; 2-Situación frágil; 3- Situación crítica', 'SUELOS','9.3');


CREATE TABLE solma_grupos_info(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    comentario TEXT
);

ALTER TABLE solma_criterios ADD grupo_info_id INT;


INSERT INTO solma_grupos_info (nombre, comentario) VALUES
('RNP', '0: 
    3--> El proceso de segregación de los residuos es respetado al 100%.
    4--> Todos los residuos están correctamente identificados.
    5--> Se respeta al 100% el código de colores de las bolsas.
    6--> No existe sobrellenado.
    7--> Todos los residuos metálicos de alto valor están correctamente securizados (tapa y candado).

1:  
    3--> Se observan algunas discrepancias en la segregación de residuos.
    4--> Se observan algunos residuos sin identificar (no disponen de cartel) y/o mal identificados.
    5--> No se respeta algunas veces el código de colores de las bolsas.
    6--> Se observan algunos sobrellenados sin presencia de residuos en el suelo.
    7--> Algunos de los residuos metálicos de alto valor no están correctamente securizados (tapa abierta, sin candar,...).

2:  
    3--> Se observan múltiples discrepancias en la segregación de residuos.
    4--> Se observan muchos residuos sin identificar (no disponen de cartel) y/o mal identificados.
    5--> No se respeta muchas veces el código de colores de las bolsas.
    6--> Existe sobrellenado con presencia de residuos en el suelo y sin impacto al medio ambiente.
    7--> Muchos de los residuos metálicos de alto valor no están correctamente securizados (tapa abierta, sin candar,...).

3:  
    3--> No existe segregación de residuos.
    4--> Ningún residuo está identificados (no disponen de cartel).
    5--> No se respeta el código de colores de las bolsas.
    6--> Existe sobrellenado con presencia de residuos en el suelo y con impacto al medio ambiente (olores, lixiviados (escurridos),...).
    7--> Ningún residuo metálico de alto valor está  correctamente securizado (sin tapa ni candado).'),
('RP', '0: 
8--> El proceso de segregación de los RPs es respetado al 100%.
9--> El 100% de los RPs está correctamente identificados y la etiqueta es legible.
10--> Ningún RP se encuentra a la intemperie y están almacenados sobre suelo en perfectas condiciones (hormigonado).
11--> Todos los RPs líquidos se encuentran almacenados sobre cubeto de retención adecuado al residuo, capacitario, estanco y sin presencia de derrames/fugas.
12--> Todos los RPs se encuentran almacenados respetando las reglas de compatibilidad.
13--> Existe cartografía (estado 5S de referencia) y es respetada al 100%.
14--> Todas las personas que manipulan RPs han recibido una formación específica.

1:  
8--> El proceso de segregación de los RPs no es respetado en algunas ocasiones.
9--> Mas del 90% de los RPs están correctamente identificados y la etiqueta es legible.
10--> Algunos RPs se encuentra a la intemperie y/o están almacenados sobre suelo en condiciones no adecuadas.
11--> Algunos RPs líquidos se encuentran almacenados sobre cubeto de retención sin cumplir alguna de las siguientes condiciones (adecuado al residuo, capacitario, estanco y/o presencia de derrames/fugas).
12--> Algunos RPs se encuentran almacenados sin respetar las reglas de compatibilidad.
13--> Existe cartografía (estado 5S de referencia) y se encuntran algunas discrepancias.
14--> Alguna persona que manipula RPs no ha recibido una formación específica.

2: 
8--> El proceso de segregación de los RPs no es respetado en múltiples ocasiones.
9--> Entre el 75% y el 90% de los RPs están correctamente identificados y la etiqueta es legible.
10--> Muchos RPs se encuentra a la intemperie y/o están almacenados sobre suelo en condiciones no adecuadas.
11--> Muchos RPs líquidos no se encuentran almacenados  correctamente (sobre cubeto de retención, cubeto no adecuado al residuo, no capacitario, no estanco y/o presencia de derrames/fugas).
12--> Muchos RPs se encuentran almacenados sin respetar las reglas de compatibilidad.
13--> Existe cartografía (estado 5S de referencia) pero no se respeta.
14--> Varias personas que manipulan RPs no han recibido una formación específica.

3: 
8--> No existe segregación RPs.
9--> Menos del 75% de los RPs está correctamente identificado y la etiqueta es legible.
10--> Todos los RPs se encuentran a la intemperie y están almacenados sobre suelo en condiciones no adecuadas (sin hormigonar).
11--> Ningún RPs líquido se encuentra almacenado correctamente (sin cubeto de retención, sin cubeto adecuado al residuo, no capacitario, no estanco y con presencia de derrames/fugas).
12--> Ningún RPs se encuentra almacenado respetando las reglas de compatibilidad.
13--> No existe cartografía (estado 5S de referencia).
14--> Ninguna persona que manipula RPs ha recibido una formación específica.'),
('PQ','0:
15--> El 100% de los puestos utilizadores de PQs están identificados.
16--> El 100% del personal que trabaja en puestos utilizadores de PQs han recibido una formación relativa al riesgo químico.
17--> El 100% de los PQs utilizados en la UET están autorizados y tienen la Ficha de Producto Químico (FPQ).
18--> El 100% de los PQs están correctamente identificados y disponen de retención capacitaria, adecuada al PQ, etiquetada (volumen de retención y color),  estanca y sin presencia de derrames.
19-->  El 100% de los PQs son almacenados según las reglas de compatibilidad.

1:
15--> El 100% de los puestos utilizadores de PQs están identificados.
16--> El 90% del personal que trabaja en puestos utilizadores de PQs ha recibido formación relativa al riesgo químico.
17--> El 90% de los PQs utilizados en la UET está autorizados y  tienen la Ficha de Producto Químico (FPQ).
18--> El 90% de los PQs está correctamente identificado y disponen de retención capacitaria, adecuada al PQ, etiquetada (volumen de retención y color), estanca y sin presencia de derrames.
19-->  El 90% de los PQs son almacenados respetarndo las reglas de compatibilidad.

2:
15--> El 100% de los puestos utilizadores de PQs están identificados.
16--> El 80% del personal que trabaja en puestos utilizadores de PQs ha recibido formación relativa al riesgo químico.
17--> El 80% de los PQs utilizados en la UET está autorizados y  tienen la Ficha de Producto Químico (FPQ).
18--> El 80% de los PQs está correctamente identificado y disponen de retención capacitaria, adecuada al PQ, etiquetada (volumen de retención y color), estanca y sin presencia de derrames.
19-->  El 80% de los PQs son almacenados respetarndo las reglas de compatibilidad.

3:
15--> Los puestos utilizadores de PQs no están identificados.
16--> Personal que trabaja en puestos utilizadores de PQs sin formación relativa al riesgo químico.
17--> Ningun PQs utilizado en la UET está autorizados y  no tiene la Ficha de Producto Químico (FPQ).
18--> Ningún PQs está correctamente identificado y no disponen de retención capacitaria, adecuada al PQ, etiquetada. (volumen de retención y color), estanca y con presencia de derrames.
19-->  Los PQs son almacenados sin respetar las reglas de compatibilidad.'),/*15-19*/
('PQEE','0:
20--> Todos los PQs utilizados en la UET por empresas externas están autorizados.
21--> La empresa externa dispone del Listado de PQs autorizados por Renault y de las FDS.

3:
20--> PQs utilizados en la UET por empresas externas sin autorizar.
21--> La empresa externa no dispone del Listado de PQs autorizados por Renault y/o de las FDS.
'),/*20 21*/
('ADR','0:
22--> Conocen los PQs/Residuos afectados por el ADR utilizados/generados en la Sección/UET.
23--> Siempre hay una persona de Renault debidamente formada, presente en las operaciones de carga/descarga.
24--> Se disponen de las consignas y documentación necesaria.
25--> Se respetan las consignas.

3:
22--> No conocen los PQs/Residuos afectados por el ADR utilizados/generados en la Sección/UET.
23--> No hay una persona de Renault debidamente formada, presente en las operaciones de carga/descarga.
24--> No se disponen de las consignas y documentación necesaria.
25--> No se respetan las consignas.
'), /*22-25*/
('KIT EMERGENCIA','0:
26--> Está ubicado correctamente (visible y accesible).
27--> Está identificado y completo.

3:
26--> No está ubicado correctamente (no visible y/o accesible).
27--> No está identificado ni completo.
'),/*26 27*/
('SUELOS','0:
28--> Zonas de retención (cubetos, bandejas, canaletas, perimetrales,…) limpias (sin suciedad, hojas,…).
29--> Suelo y zonas de retención (cubetos, bandejas, canaletas, perimetrales,…) sin presencia de derrames.
30--> Suelo impermeabilizado sin fisuras/grietas

1:
28--> NA.
29--> Presencia de derrames en zonas de retención.
30--> NA.

2:
28--> NA.
29--> Presencia de derrames fuera de las zonas de retención sin posibilidad de alcanzar el alcantarillado, etc…
30--> NA.

3:
28--> Zonas de retención (cubetos, bandejas, canaletas, perimetrales,…) sucias.
29--> Presencia de derrames con posibilidad de alcanzar el alcantarillado, etc.
30--> Suelo impermeabilizado con fisuras/grietas.
'),/*28 30*/
('AGUA', '0: Sin fugas de agua, ni válvulas o grifos abiertos.

1: Sin fugas de agua pero con válvulas o grifos abiertos, con consumos no importantes ó fugas accidentales pero con plan de acción de reparación previsto.

2: Con fugas de agua, válvulas o grifos abiertos, con consumos no importantes ó fugas accidentales pero sin plan de acción de reparación previsto.

3: Con fugas de agua, válvulas o grifos abiertos, con consumos importantes ó fugas repetitivas y/o sin plan de acción de reparación previsto.'),
('ENERGIA', '0: No existen fugas de aire comprimido ni instalaciones y/o alumbrado en funcionamiento sin ser necesario.

1: Existen fugas de aire comprimido y/o alumbrado en funcionamiento sin ser necesario, consumos no importantes pero con plan de acción previsto.

2: Existen fugas de aire comprimido y/o alumbrado en funcionamiento sin ser necesario, consumos no importantes pero sin plan de acción previsto.

3: Existen fugas de aire comprimido y/o instalaciones y/o alumbrado en funcionamiento sin ser necesario, con consumos importantes.');


-- RNP (3-7)
UPDATE solma_criterios SET grupo_info_id = 1 WHERE id IN (3,4,5,6,7);

-- RP (8-14)
UPDATE solma_criterios SET grupo_info_id = 2 WHERE id BETWEEN 8 AND 14;

-- PQ (15-19)
UPDATE solma_criterios SET grupo_info_id = 3 WHERE id BETWEEN 15 AND 19;

-- PQEE (20-21)
UPDATE solma_criterios SET grupo_info_id = 4 WHERE id IN (20,21);

-- ADR (22-25)
UPDATE solma_criterios SET grupo_info_id = 5 WHERE id BETWEEN 22 AND 25;

-- KIT
UPDATE solma_criterios SET grupo_info_id = 6 WHERE id IN (26,27);

-- SUELOS
UPDATE solma_criterios SET grupo_info_id = 7 WHERE id BETWEEN 28 AND 30;

-- AGUA
UPDATE solma_criterios SET grupo_info_id = 8 WHERE id = 1;

-- ENERGIA
UPDATE solma_criterios SET grupo_info_id = 9 WHERE id = 2;


create table solma_plan_accion_criterios(
    id int auto_increment primary key,
    titulo varchar(255) not null,
    criterio_num varchar(100) not null,
    troncon varchar(255) not null,
    turno enum('A','B','C', 'otros') not null,
    responsable varchar(255) not null,
    aspecto_ambiental varchar(255) not null,
    fecha date not null,
    demerito text not null,
    acciones text not null,
    piloto varchar(255) not null,
    fecha_cierre date,
    fecha_cierre_real date,
    estado_plan_accion enum('abierto', 'cerrado', 'accion inmediata') not null,
    acciones_eficaces enum('si', 'no') not null,
    proxima_evaluacion date,
    lineas varchar(5),
    correccion varchar(5)
);

ALTER TABLE solma_plan_accion_criterios
ADD id_grupo INT;
