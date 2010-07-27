/*==============================================================*/
/* Table: AGILHU_HISTORIA_USUARIO                               */
/*==============================================================*/
create table AGILHU_HISTORIA_USUARIO (
   HIS_ID               serial               not null,
   MOD_ID               integer              null,

   PRO_ID               integer              null,
   HIS_NOMBRE           varchar(200)         null,
   HIS_DEPENDENCIAS     varchar(500)         null,

   HIS_PRIORIDAD        VARCHAR(10)          null,
   HIS_RIESGO           integer              null,
   HIS_TIEMPO_ESTIMADO  integer              null,

   HIS_TIEMPO_REAL      integer              null,
   HIS_BASE             varchar(50)          null,
   HIS_TIPO_ACTIVIDAD   varchar(20)          null,

   HIS_DESCRIPCION      varchar(500)         null,
   HIS_OBSERVACIONES    varchar(500)         null,
   created_at   timestamp                 null,

   updated_at   timestamp                 not null,
   HIS_CREADOR          varchar(30)          null,
   HIS_IDENTIFICADOR_HISTORIA varchar(20)          null,
   
   HIS_VERSION          varchar(10)          null,
   HIS_RESPONSABLE      varchar(100)         null,
   HIS_UNIDAD_TIEMPO    varchar(10)          null,
   constraint PK_AGILHU_HISTORIA_USUARIO primary key (HIS_ID)
);

/*==============================================================*/
/* Table: AGILHU_MODULO                                         */
/*==============================================================*/
