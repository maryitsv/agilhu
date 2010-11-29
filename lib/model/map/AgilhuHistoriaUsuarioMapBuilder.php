<?php


/**
 * This class adds structure of 'agilhu_historia_usuario' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Mon Aug 30 10:19:33 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AgilhuHistoriaUsuarioMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AgilhuHistoriaUsuarioMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(AgilhuHistoriaUsuarioPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(AgilhuHistoriaUsuarioPeer::TABLE_NAME);
		$tMap->setPhpName('AgilhuHistoriaUsuario');
		$tMap->setClassname('AgilhuHistoriaUsuario');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('agilhu_historia_usuario_his_id_seq');

		$tMap->addPrimaryKey('HIS_ID', 'HisId', 'INTEGER', true, null);

		$tMap->addForeignKey('MOD_ID', 'ModId', 'INTEGER', 'agilhu_modulo', 'MOD_ID', false, null);

		$tMap->addForeignKey('PRO_ID', 'ProId', 'INTEGER', 'agilhu_proyecto', 'PRO_ID', false, null);

		$tMap->addColumn('HIS_NOMBRE', 'HisNombre', 'VARCHAR', false, 200);

		$tMap->addColumn('HIS_DEPENDENCIAS', 'HisDependencias', 'VARCHAR', false, 500);

		$tMap->addColumn('HIS_PRIORIDAD', 'HisPrioridad', 'VARCHAR', false, 10);

		$tMap->addColumn('HIS_RIESGO', 'HisRiesgo', 'INTEGER', false, null);

		$tMap->addColumn('HIS_TIEMPO_ESTIMADO', 'HisTiempoEstimado', 'INTEGER', false, null);

		$tMap->addColumn('HIS_TIEMPO_REAL', 'HisTiempoReal', 'INTEGER', false, null);

		$tMap->addColumn('HIS_TIPO_ACTIVIDAD', 'HisTipoActividad', 'VARCHAR', false, 20);

		$tMap->addColumn('HIS_DESCRIPCION', 'HisDescripcion', 'LONGVARCHAR', false, null);

		$tMap->addColumn('HIS_OBSERVACIONES', 'HisObservaciones', 'VARCHAR', false, 500);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null);

		$tMap->addColumn('HIS_CREADOR', 'HisCreador', 'VARCHAR', false, 30);

		$tMap->addColumn('HIS_TEMPORAL', 'HisTemporal', 'VARCHAR', false, 20);

		$tMap->addColumn('HIS_VERSION', 'HisVersion', 'VARCHAR', false, 10);

		$tMap->addColumn('HIS_RESPONSABLE', 'HisResponsable', 'VARCHAR', false, 200);

		$tMap->addColumn('HIS_UNIDAD_TIEMPO', 'HisUnidadTiempo', 'VARCHAR', false, 10);

		$tMap->addColumn('HIS_MENSAJE_VERSION', 'HisMensajeVersion', 'VARCHAR', false, 200);

		$tMap->addColumn('HIS_IDENTIFICADOR_HISTORIA', 'HisIdentificadorHistoria', 'INTEGER', false, null);

		$tMap->addColumn('HIS_ACTOR', 'HisActor', 'VARCHAR', false, 80);

		$tMap->addColumn('HIS_ITERACION', 'HisIteracion', 'INTEGER', false, null);

	} // doBuild()

} // AgilhuHistoriaUsuarioMapBuilder
