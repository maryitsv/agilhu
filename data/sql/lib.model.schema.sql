
-----------------------------------------------------------------------------
-- agilhu_documento
-----------------------------------------------------------------------------

DROP TABLE "agilhu_documento" CASCADE;


CREATE TABLE "agilhu_documento"
(
	"doc_id" serial  NOT NULL,
	"doc_nombre" VARCHAR(200),
	"doc_descripcion" VARCHAR(1000),
	"doc_tamano" VARCHAR(100),
	"doc_tipo" VARCHAR(200),
	"doc_contenido" BYTEA,
	"doc_id_pro" INTEGER,
	"doc_id_mod" INTEGER,
	"doc_id_his" INTEGER,
	"doc_id_remitente" INTEGER,
	"doc_visibilidad" VARCHAR(20),
	"created_at" TIMESTAMP,
	PRIMARY KEY ("doc_id")
);

COMMENT ON TABLE "agilhu_documento" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- agilhu_historia_usuario
-----------------------------------------------------------------------------

DROP TABLE "agilhu_historia_usuario" CASCADE;


CREATE TABLE "agilhu_historia_usuario"
(
	"his_id" serial  NOT NULL,
	"mod_id" INTEGER,
	"pro_id" INTEGER,
	"his_nombre" VARCHAR(200),
	"his_dependencias" VARCHAR(500),
	"his_prioridad" VARCHAR(10),
	"his_riesgo" INTEGER,
	"his_tiempo_estimado" INTEGER,
	"his_tiempo_real" INTEGER,
	"his_tipo_actividad" VARCHAR(20),
	"his_descripcion" TEXT,
	"his_observaciones" VARCHAR(500),
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP  NOT NULL,
	"his_creador" VARCHAR(30),
	"his_temporal" VARCHAR(20),
	"his_version" VARCHAR(10),
	"his_responsable" VARCHAR(200),
	"his_unidad_tiempo" VARCHAR(10),
	"his_mensaje_version" VARCHAR(200),
	"his_identificador_historia" INTEGER,
	"his_actor" VARCHAR(80),
	"his_iteracion" INTEGER,
	PRIMARY KEY ("his_id")
);

COMMENT ON TABLE "agilhu_historia_usuario" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- agilhu_mensaje_enviado
-----------------------------------------------------------------------------

DROP TABLE "agilhu_mensaje_enviado" CASCADE;


CREATE TABLE "agilhu_mensaje_enviado"
(
	"men_id" serial  NOT NULL,
	"men_pro_id" INTEGER,
	"men_de" VARCHAR(250),
	"men_para" VARCHAR(250),
	"men_asunto" VARCHAR(250),
	"created_at" DATE,
	"men_mensaje" VARCHAR(250),
	PRIMARY KEY ("men_id")
);

COMMENT ON TABLE "agilhu_mensaje_enviado" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- agilhu_mensaje_recibido
-----------------------------------------------------------------------------

DROP TABLE "agilhu_mensaje_recibido" CASCADE;


CREATE TABLE "agilhu_mensaje_recibido"
(
	"men_id" serial  NOT NULL,
	"men_pro_id" INTEGER,
	"men_de" VARCHAR(250),
	"men_para" VARCHAR(250),
	"men_asunto" VARCHAR(250),
	"created_at" DATE,
	"men_mensaje" VARCHAR(250),
	PRIMARY KEY ("men_id")
);

COMMENT ON TABLE "agilhu_mensaje_recibido" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- agilhu_modulo
-----------------------------------------------------------------------------

DROP TABLE "agilhu_modulo" CASCADE;


CREATE TABLE "agilhu_modulo"
(
	"mod_id" serial  NOT NULL,
	"pro_id" INTEGER,
	"mod_nombre" VARCHAR(150),
	"mod_estado" VARCHAR(80),
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	"mod_descripcion" TEXT,
	PRIMARY KEY ("mod_id")
);

COMMENT ON TABLE "agilhu_modulo" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- agilhu_participante
-----------------------------------------------------------------------------

DROP TABLE "agilhu_participante" CASCADE;


CREATE TABLE "agilhu_participante"
(
	"pro_id" INTEGER,
	"usu_id" INTEGER,
	"rop_id" INTEGER,
	"estado" VARCHAR(50),
	"created_at" TIMESTAMP,
	"id" serial  NOT NULL,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "agilhu_participante" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- agilhu_preguntas
-----------------------------------------------------------------------------

DROP TABLE "agilhu_preguntas" CASCADE;


CREATE TABLE "agilhu_preguntas"
(
	"pre_id" serial  NOT NULL,
	"pre_pro_id" INTEGER,
	"pre_descripcion" VARCHAR(1000)  NOT NULL,
	"pre_caracteristica_calidad" VARCHAR(100),
	"pre_categoria" VARCHAR(200),
	PRIMARY KEY ("pre_id")
);

COMMENT ON TABLE "agilhu_preguntas" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- agilhu_proyecto
-----------------------------------------------------------------------------

DROP TABLE "agilhu_proyecto" CASCADE;


CREATE TABLE "agilhu_proyecto"
(
	"pro_id" serial  NOT NULL,
	"usu_id" INTEGER,
	"pro_nombre_corto" VARCHAR(80),
	"pro_nombre" VARCHAR(300),
	"pro_area_aplicacion" VARCHAR(500),
	"pro_fecha_inicio" DATE,
	"pro_fecha_finalizacion" DATE,
	"pro_estado" VARCHAR(50),
	"pro_logo" VARCHAR(500),
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	"pro_descripcion" TEXT,
	PRIMARY KEY ("pro_id")
);

COMMENT ON TABLE "agilhu_proyecto" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- agilhu_prueba_experto
-----------------------------------------------------------------------------

DROP TABLE "agilhu_prueba_experto" CASCADE;


CREATE TABLE "agilhu_prueba_experto"
(
	"pru_fecha_evalucion" TIMESTAMP  NOT NULL,
	"his_id_asociada" INTEGER  NOT NULL,
	"usu_evaluador_id" INTEGER  NOT NULL,
	"pru_promedio" NUMERIC,
	"pru_comentarios" VARCHAR(200),
	"pru_independiente" INTEGER,
	"pru_negociable" INTEGER,
	"pru_valiosa" INTEGER,
	"pru_estimable" INTEGER,
	"pru_pequena" INTEGER,
	"pru_testeable" INTEGER,
	PRIMARY KEY ("pru_fecha_evalucion","his_id_asociada","usu_evaluador_id")
);

COMMENT ON TABLE "agilhu_prueba_experto" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- agilhu_rol
-----------------------------------------------------------------------------

DROP TABLE "agilhu_rol" CASCADE;


CREATE TABLE "agilhu_rol"
(
	"rol_id" serial  NOT NULL,
	"rol_nombre" VARCHAR(50)  NOT NULL,
	PRIMARY KEY ("rol_id")
);

COMMENT ON TABLE "agilhu_rol" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- agilhu_rol_proyecto
-----------------------------------------------------------------------------

DROP TABLE "agilhu_rol_proyecto" CASCADE;


CREATE TABLE "agilhu_rol_proyecto"
(
	"rop_id" INTEGER  NOT NULL,
	"rop_nombre" VARCHAR(50)  NOT NULL,
	"rop_descipcion" VARCHAR(100),
	PRIMARY KEY ("rop_id")
);

COMMENT ON TABLE "agilhu_rol_proyecto" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- agilhu_usuario
-----------------------------------------------------------------------------

DROP TABLE "agilhu_usuario" CASCADE;


CREATE TABLE "agilhu_usuario"
(
	"usu_id" serial  NOT NULL,
	"rol_id" INTEGER,
	"usu_usuario" VARCHAR(30)  NOT NULL,
	"usu_clave" VARCHAR(32)  NOT NULL,
	"usu_nombres" VARCHAR(80)  NOT NULL,
	"usu_apellidos" VARCHAR(80)  NOT NULL,
	"usu_correo" VARCHAR(150)  NOT NULL,
	"usu_estado" VARCHAR(20)  NOT NULL,
	PRIMARY KEY ("usu_id")
);

COMMENT ON TABLE "agilhu_usuario" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- agilhu_usuario_estado
-----------------------------------------------------------------------------

DROP TABLE "agilhu_usuario_estado" CASCADE;


CREATE TABLE "agilhu_usuario_estado"
(
	"use_id" serial  NOT NULL,
	"use_usuario" VARCHAR(100),
	"use_estado" BOOLEAN,
	PRIMARY KEY ("use_id")
);

COMMENT ON TABLE "agilhu_usuario_estado" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- chat
-----------------------------------------------------------------------------

DROP TABLE "chat" CASCADE;


CREATE TABLE "chat"
(
	"id" serial  NOT NULL,
	"de" VARCHAR(255) default '' NOT NULL,
	"para" VARCHAR(255) default '' NOT NULL,
	"message" TEXT  NOT NULL,
	"sent" TIMESTAMP  NOT NULL,
	"recd" INTEGER default 0 NOT NULL,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "chat" IS '';


SET search_path TO public;
ALTER TABLE "agilhu_historia_usuario" ADD CONSTRAINT "agilhu_historia_usuario_FK_1" FOREIGN KEY ("mod_id") REFERENCES "agilhu_modulo" ("mod_id") ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE "agilhu_historia_usuario" ADD CONSTRAINT "agilhu_historia_usuario_FK_2" FOREIGN KEY ("pro_id") REFERENCES "agilhu_proyecto" ("pro_id") ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE "agilhu_modulo" ADD CONSTRAINT "agilhu_modulo_FK_1" FOREIGN KEY ("pro_id") REFERENCES "agilhu_proyecto" ("pro_id") ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE "agilhu_participante" ADD CONSTRAINT "agilhu_participante_FK_1" FOREIGN KEY ("pro_id") REFERENCES "agilhu_proyecto" ("pro_id") ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE "agilhu_participante" ADD CONSTRAINT "agilhu_participante_FK_2" FOREIGN KEY ("usu_id") REFERENCES "agilhu_usuario" ("usu_id") ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE "agilhu_participante" ADD CONSTRAINT "agilhu_participante_FK_3" FOREIGN KEY ("rop_id") REFERENCES "agilhu_rol_proyecto" ("rop_id") ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE "agilhu_preguntas" ADD CONSTRAINT "agilhu_preguntas_FK_1" FOREIGN KEY ("pre_pro_id") REFERENCES "agilhu_proyecto" ("pro_id");

ALTER TABLE "agilhu_proyecto" ADD CONSTRAINT "agilhu_proyecto_FK_1" FOREIGN KEY ("usu_id") REFERENCES "agilhu_usuario" ("usu_id") ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE "agilhu_prueba_experto" ADD CONSTRAINT "agilhu_prueba_experto_FK_1" FOREIGN KEY ("his_id_asociada") REFERENCES "agilhu_historia_usuario" ("his_id") ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE "agilhu_prueba_experto" ADD CONSTRAINT "agilhu_prueba_experto_FK_2" FOREIGN KEY ("usu_evaluador_id") REFERENCES "agilhu_usuario" ("usu_id") ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE "agilhu_usuario" ADD CONSTRAINT "agilhu_usuario_FK_1" FOREIGN KEY ("rol_id") REFERENCES "agilhu_rol" ("rol_id") ON UPDATE RESTRICT ON DELETE RESTRICT;
