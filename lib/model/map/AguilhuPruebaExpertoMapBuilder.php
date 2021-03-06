<?php


/**
 * This class adds structure of 'aguilhu_prueba_experto' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Nov 19 11:56:14 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AguilhuPruebaExpertoMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AguilhuPruebaExpertoMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(AguilhuPruebaExpertoPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(AguilhuPruebaExpertoPeer::TABLE_NAME);
		$tMap->setPhpName('AguilhuPruebaExperto');
		$tMap->setClassname('AguilhuPruebaExperto');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('PRU_FECHA_EVALUCION', 'PruFechaEvalucion', 'TIMESTAMP', true, null);

		$tMap->addForeignPrimaryKey('HIS_ID_ASOCIADA', 'HisIdAsociada', 'INTEGER' , 'agilhu_historia_usuario', 'HIS_ID', true, null);

		$tMap->addForeignPrimaryKey('USU_EVALUADOR_ID', 'UsuEvaluadorId', 'INTEGER' , 'agilhu_usuario', 'USU_ID', true, null);

		$tMap->addColumn('PRU_PROMEDIO', 'PruPromedio', 'NUMERIC', false, null);

		$tMap->addColumn('PRU_COMENTARIOS', 'PruComentarios', 'VARCHAR', false, 200);

		$tMap->addColumn('PRU_INDEPENDIENTE', 'PruIndependiente', 'INTEGER', false, null);

		$tMap->addColumn('PRU_NEGOCIABLE', 'PruNegociable', 'INTEGER', false, null);

		$tMap->addColumn('PRU_VALIOSA', 'PruValiosa', 'INTEGER', false, null);

		$tMap->addColumn('PRU_ESTIMABLE', 'PruEstimable', 'INTEGER', false, null);

		$tMap->addColumn('PRU_PEQUENA', 'PruPequena', 'INTEGER', false, null);

		$tMap->addColumn('PRU_TESTEABLE', 'PruTesteable', 'INTEGER', false, null);

	} // doBuild()

} // AguilhuPruebaExpertoMapBuilder
