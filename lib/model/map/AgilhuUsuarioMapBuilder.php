<?php


/**
 * This class adds structure of 'agilhu_usuario' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Mon Aug 30 10:19:34 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AgilhuUsuarioMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AgilhuUsuarioMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(AgilhuUsuarioPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(AgilhuUsuarioPeer::TABLE_NAME);
		$tMap->setPhpName('AgilhuUsuario');
		$tMap->setClassname('AgilhuUsuario');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('agilhu_usuario_usu_id_seq');

		$tMap->addPrimaryKey('USU_ID', 'UsuId', 'INTEGER', true, null);

		$tMap->addForeignKey('ROL_ID', 'RolId', 'INTEGER', 'agilhu_rol', 'ROL_ID', false, null);

		$tMap->addColumn('USU_USUARIO', 'UsuUsuario', 'VARCHAR', true, 30);

		$tMap->addColumn('USU_CLAVE', 'UsuClave', 'VARCHAR', true, 32);

		$tMap->addColumn('USU_NOMBRES', 'UsuNombres', 'VARCHAR', true, 80);

		$tMap->addColumn('USU_APELLIDOS', 'UsuApellidos', 'VARCHAR', true, 80);

		$tMap->addColumn('USU_CORREO', 'UsuCorreo', 'VARCHAR', true, 150);

		$tMap->addColumn('USU_ESTADO', 'UsuEstado', 'VARCHAR', true, 20);

	} // doBuild()

} // AgilhuUsuarioMapBuilder
