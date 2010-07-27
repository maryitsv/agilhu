<?php

/**
 * Base static class for performing query and update operations on the 'agilhu_proyecto' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Mon Jun 28 16:09:55 2010
 *
 * @package    lib.model.om
 */
abstract class BaseAgilhuProyectoPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'agilhu_proyecto';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.AgilhuProyecto';

	/** The total number of columns. */
	const NUM_COLUMNS = 12;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** the column name for the PRO_ID field */
	const PRO_ID = 'agilhu_proyecto.PRO_ID';

	/** the column name for the USU_ID field */
	const USU_ID = 'agilhu_proyecto.USU_ID';

	/** the column name for the PRO_NOMBRE_CORTO field */
	const PRO_NOMBRE_CORTO = 'agilhu_proyecto.PRO_NOMBRE_CORTO';

	/** the column name for the PRO_NOMBRE field */
	const PRO_NOMBRE = 'agilhu_proyecto.PRO_NOMBRE';

	/** the column name for the PRO_AREA_APLICACION field */
	const PRO_AREA_APLICACION = 'agilhu_proyecto.PRO_AREA_APLICACION';

	/** the column name for the PRO_FECHA_INICIO field */
	const PRO_FECHA_INICIO = 'agilhu_proyecto.PRO_FECHA_INICIO';

	/** the column name for the PRO_FECHA_FINALIZACION field */
	const PRO_FECHA_FINALIZACION = 'agilhu_proyecto.PRO_FECHA_FINALIZACION';

	/** the column name for the PRO_ESTADO field */
	const PRO_ESTADO = 'agilhu_proyecto.PRO_ESTADO';

	/** the column name for the PRO_LOGO field */
	const PRO_LOGO = 'agilhu_proyecto.PRO_LOGO';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'agilhu_proyecto.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'agilhu_proyecto.UPDATED_AT';

	/** the column name for the PRO_DESCRIPCION field */
	const PRO_DESCRIPCION = 'agilhu_proyecto.PRO_DESCRIPCION';

	/**
	 * An identiy map to hold any loaded instances of AgilhuProyecto objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array AgilhuProyecto[]
	 */
	public static $instances = array();

	/**
	 * The MapBuilder instance for this peer.
	 * @var        MapBuilder
	 */
	private static $mapBuilder = null;

	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('ProId', 'UsuId', 'ProNombreCorto', 'ProNombre', 'ProAreaAplicacion', 'ProFechaInicio', 'ProFechaFinalizacion', 'ProEstado', 'ProLogo', 'CreatedAt', 'UpdatedAt', 'ProDescripcion', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('proId', 'usuId', 'proNombreCorto', 'proNombre', 'proAreaAplicacion', 'proFechaInicio', 'proFechaFinalizacion', 'proEstado', 'proLogo', 'createdAt', 'updatedAt', 'proDescripcion', ),
		BasePeer::TYPE_COLNAME => array (self::PRO_ID, self::USU_ID, self::PRO_NOMBRE_CORTO, self::PRO_NOMBRE, self::PRO_AREA_APLICACION, self::PRO_FECHA_INICIO, self::PRO_FECHA_FINALIZACION, self::PRO_ESTADO, self::PRO_LOGO, self::CREATED_AT, self::UPDATED_AT, self::PRO_DESCRIPCION, ),
		BasePeer::TYPE_FIELDNAME => array ('pro_id', 'usu_id', 'pro_nombre_corto', 'pro_nombre', 'pro_area_aplicacion', 'pro_fecha_inicio', 'pro_fecha_finalizacion', 'pro_estado', 'pro_logo', 'created_at', 'updated_at', 'pro_descripcion', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('ProId' => 0, 'UsuId' => 1, 'ProNombreCorto' => 2, 'ProNombre' => 3, 'ProAreaAplicacion' => 4, 'ProFechaInicio' => 5, 'ProFechaFinalizacion' => 6, 'ProEstado' => 7, 'ProLogo' => 8, 'CreatedAt' => 9, 'UpdatedAt' => 10, 'ProDescripcion' => 11, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('proId' => 0, 'usuId' => 1, 'proNombreCorto' => 2, 'proNombre' => 3, 'proAreaAplicacion' => 4, 'proFechaInicio' => 5, 'proFechaFinalizacion' => 6, 'proEstado' => 7, 'proLogo' => 8, 'createdAt' => 9, 'updatedAt' => 10, 'proDescripcion' => 11, ),
		BasePeer::TYPE_COLNAME => array (self::PRO_ID => 0, self::USU_ID => 1, self::PRO_NOMBRE_CORTO => 2, self::PRO_NOMBRE => 3, self::PRO_AREA_APLICACION => 4, self::PRO_FECHA_INICIO => 5, self::PRO_FECHA_FINALIZACION => 6, self::PRO_ESTADO => 7, self::PRO_LOGO => 8, self::CREATED_AT => 9, self::UPDATED_AT => 10, self::PRO_DESCRIPCION => 11, ),
		BasePeer::TYPE_FIELDNAME => array ('pro_id' => 0, 'usu_id' => 1, 'pro_nombre_corto' => 2, 'pro_nombre' => 3, 'pro_area_aplicacion' => 4, 'pro_fecha_inicio' => 5, 'pro_fecha_finalizacion' => 6, 'pro_estado' => 7, 'pro_logo' => 8, 'created_at' => 9, 'updated_at' => 10, 'pro_descripcion' => 11, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	/**
	 * Get a (singleton) instance of the MapBuilder for this peer class.
	 * @return     MapBuilder The map builder for this peer
	 */
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new AgilhuProyectoMapBuilder();
		}
		return self::$mapBuilder;
	}
	/**
	 * Translates a fieldname to another type
	 *
	 * @param      string $name field name
	 * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @param      string $toType   One of the class type constants
	 * @return     string translated name of the field.
	 * @throws     PropelException - if the specified name could not be found in the fieldname mappings.
	 */
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	/**
	 * Returns an array of field names.
	 *
	 * @param      string $type The type of fieldnames to return:
	 *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     array A list of field names
	 */

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	/**
	 * Convenience method which changes table.column to alias.column.
	 *
	 * Using this method you can maintain SQL abstraction while using column aliases.
	 * <code>
	 *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
	 *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
	 * </code>
	 * @param      string $alias The alias for the current table.
	 * @param      string $column The column name for current table. (i.e. AgilhuProyectoPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(AgilhuProyectoPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	/**
	 * Add all the columns needed to create a new object.
	 *
	 * Note: any columns that were marked with lazyLoad="true" in the
	 * XML schema will not be added to the select list and only loaded
	 * on demand.
	 *
	 * @param      criteria object containing the columns to add.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(AgilhuProyectoPeer::PRO_ID);

		$criteria->addSelectColumn(AgilhuProyectoPeer::USU_ID);

		$criteria->addSelectColumn(AgilhuProyectoPeer::PRO_NOMBRE_CORTO);

		$criteria->addSelectColumn(AgilhuProyectoPeer::PRO_NOMBRE);

		$criteria->addSelectColumn(AgilhuProyectoPeer::PRO_AREA_APLICACION);

		$criteria->addSelectColumn(AgilhuProyectoPeer::PRO_FECHA_INICIO);

		$criteria->addSelectColumn(AgilhuProyectoPeer::PRO_FECHA_FINALIZACION);

		$criteria->addSelectColumn(AgilhuProyectoPeer::PRO_ESTADO);

		$criteria->addSelectColumn(AgilhuProyectoPeer::PRO_LOGO);

		$criteria->addSelectColumn(AgilhuProyectoPeer::CREATED_AT);

		$criteria->addSelectColumn(AgilhuProyectoPeer::UPDATED_AT);

		$criteria->addSelectColumn(AgilhuProyectoPeer::PRO_DESCRIPCION);

	}

	/**
	 * Returns the number of rows matching criteria.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
		// we may modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(AgilhuProyectoPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			AgilhuProyectoPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(AgilhuProyectoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}


    foreach (sfMixer::getCallables('BaseAgilhuProyectoPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseAgilhuProyectoPeer', $criteria, $con);
    }


		// BasePeer returns a PDOStatement
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}
	/**
	 * Method to select one object from the DB.
	 *
	 * @param      Criteria $criteria object used to create the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     AgilhuProyecto
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = AgilhuProyectoPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	/**
	 * Method to do selects.
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     array Array of selected Objects
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return AgilhuProyectoPeer::populateObjects(AgilhuProyectoPeer::doSelectStmt($criteria, $con));
	}
	/**
	 * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
	 *
	 * Use this method directly if you want to work with an executed statement durirectly (for example
	 * to perform your own object hydration).
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con The connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     PDOStatement The executed PDOStatement object.
	 * @see        BasePeer::doSelect()
	 */
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseAgilhuProyectoPeer:doSelectStmt:doSelectStmt') as $callable)
    {
      call_user_func($callable, 'BaseAgilhuProyectoPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(AgilhuProyectoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			AgilhuProyectoPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		// BasePeer returns a PDOStatement
		return BasePeer::doSelect($criteria, $con);
	}
	/**
	 * Adds an object to the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doSelect*()
	 * methods in your stub classes -- you may need to explicitly add objects
	 * to the cache in order to ensure that the same objects are always returned by doSelect*()
	 * and retrieveByPK*() calls.
	 *
	 * @param      AgilhuProyecto $value A AgilhuProyecto object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool(AgilhuProyecto $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getProId();
			} // if key === null
			self::$instances[$key] = $obj;
		}
	}

	/**
	 * Removes an object from the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doDelete
	 * methods in your stub classes -- you may need to explicitly remove objects
	 * from the cache in order to prevent returning objects that no longer exist.
	 *
	 * @param      mixed $value A AgilhuProyecto object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof AgilhuProyecto) {
				$key = (string) $value->getProId();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or AgilhuProyecto object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
				throw $e;
			}

			unset(self::$instances[$key]);
		}
	} // removeInstanceFromPool()

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
	 * @return     AgilhuProyecto Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
	 * @see        getPrimaryKeyHash()
	 */
	public static function getInstanceFromPool($key)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if (isset(self::$instances[$key])) {
				return self::$instances[$key];
			}
		}
		return null; // just to be explicit
	}
	
	/**
	 * Clear the instance pool.
	 *
	 * @return     void
	 */
	public static function clearInstancePool()
	{
		self::$instances = array();
	}
	
	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      array $row PropelPDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @return     string A string version of PK or NULL if the components of primary key in result array are all null.
	 */
	public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
	{
		// If the PK cannot be derived from the row, return NULL.
		if ($row[$startcol + 0] === null) {
			return null;
		}
		return (string) $row[$startcol + 0];
	}

	/**
	 * The returned array will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
		// set the class once to avoid overhead in the loop
		$cls = AgilhuProyectoPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = AgilhuProyectoPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = AgilhuProyectoPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				AgilhuProyectoPeer::addInstanceToPool($obj, $key);
			} // if key exists
		}
		$stmt->closeCursor();
		return $results;
	}

	/**
	 * Returns the number of rows matching criteria, joining the related AgilhuUsuario table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAgilhuUsuario(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(AgilhuProyectoPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			AgilhuProyectoPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(AgilhuProyectoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(AgilhuProyectoPeer::USU_ID,), array(AgilhuUsuarioPeer::USU_ID,), $join_behavior);


    foreach (sfMixer::getCallables('BaseAgilhuProyectoPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseAgilhuProyectoPeer', $criteria, $con);
    }


		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Selects a collection of AgilhuProyecto objects pre-filled with their AgilhuUsuario objects.
	 * @param      Criteria  $c
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of AgilhuProyecto objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAgilhuUsuario(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{

    foreach (sfMixer::getCallables('BaseAgilhuProyectoPeer:doSelectJoin:doSelectJoin') as $callable)
    {
      call_user_func($callable, 'BaseAgilhuProyectoPeer', $c, $con);
    }


		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AgilhuProyectoPeer::addSelectColumns($c);
		$startcol = (AgilhuProyectoPeer::NUM_COLUMNS - AgilhuProyectoPeer::NUM_LAZY_LOAD_COLUMNS);
		AgilhuUsuarioPeer::addSelectColumns($c);

		$c->addJoin(array(AgilhuProyectoPeer::USU_ID,), array(AgilhuUsuarioPeer::USU_ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = AgilhuProyectoPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = AgilhuProyectoPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$omClass = AgilhuProyectoPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				AgilhuProyectoPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = AgilhuUsuarioPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = AgilhuUsuarioPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = AgilhuUsuarioPeer::getOMClass();

					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					AgilhuUsuarioPeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded

				// Add the $obj1 (AgilhuProyecto) to $obj2 (AgilhuUsuario)
				$obj2->addAgilhuProyecto($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining all related tables
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(AgilhuProyectoPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			AgilhuProyectoPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(AgilhuProyectoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(AgilhuProyectoPeer::USU_ID,), array(AgilhuUsuarioPeer::USU_ID,), $join_behavior);

    foreach (sfMixer::getCallables('BaseAgilhuProyectoPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseAgilhuProyectoPeer', $criteria, $con);
    }


		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}

	/**
	 * Selects a collection of AgilhuProyecto objects pre-filled with all related objects.
	 *
	 * @param      Criteria  $c
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of AgilhuProyecto objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAll(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{

    foreach (sfMixer::getCallables('BaseAgilhuProyectoPeer:doSelectJoinAll:doSelectJoinAll') as $callable)
    {
      call_user_func($callable, 'BaseAgilhuProyectoPeer', $c, $con);
    }


		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AgilhuProyectoPeer::addSelectColumns($c);
		$startcol2 = (AgilhuProyectoPeer::NUM_COLUMNS - AgilhuProyectoPeer::NUM_LAZY_LOAD_COLUMNS);

		AgilhuUsuarioPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (AgilhuUsuarioPeer::NUM_COLUMNS - AgilhuUsuarioPeer::NUM_LAZY_LOAD_COLUMNS);

		$c->addJoin(array(AgilhuProyectoPeer::USU_ID,), array(AgilhuUsuarioPeer::USU_ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = AgilhuProyectoPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = AgilhuProyectoPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$omClass = AgilhuProyectoPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				AgilhuProyectoPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

			// Add objects for joined AgilhuUsuario rows

			$key2 = AgilhuUsuarioPeer::getPrimaryKeyHashFromRow($row, $startcol2);
			if ($key2 !== null) {
				$obj2 = AgilhuUsuarioPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = AgilhuUsuarioPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					AgilhuUsuarioPeer::addInstanceToPool($obj2, $key2);
				} // if obj2 loaded

				// Add the $obj1 (AgilhuProyecto) to the collection in $obj2 (AgilhuUsuario)
				$obj2->addAgilhuProyecto($obj1);
			} // if joined row not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


  static public function getUniqueColumnNames()
  {
    return array();
  }
	/**
	 * Returns the TableMap related to this peer.
	 * This method is not needed for general use but a specific application could have a need.
	 * @return     TableMap
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	/**
	 * The class that the Peer will make instances of.
	 *
	 * This uses a dot-path notation which is tranalted into a path
	 * relative to a location on the PHP include_path.
	 * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
	 *
	 * @return     string path.to.ClassName
	 */
	public static function getOMClass()
	{
		return AgilhuProyectoPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a AgilhuProyecto or Criteria object.
	 *
	 * @param      mixed $values Criteria or AgilhuProyecto object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseAgilhuProyectoPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseAgilhuProyectoPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(AgilhuProyectoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from AgilhuProyecto object
		}

		if ($criteria->containsKey(AgilhuProyectoPeer::PRO_ID) && $criteria->keyContainsValue(AgilhuProyectoPeer::PRO_ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.AgilhuProyectoPeer::PRO_ID.')');
		}


		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			// use transaction because $criteria could contain info
			// for more than one table (I guess, conceivably)
			$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollBack();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseAgilhuProyectoPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseAgilhuProyectoPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a AgilhuProyecto or Criteria object.
	 *
	 * @param      mixed $values Criteria or AgilhuProyecto object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseAgilhuProyectoPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseAgilhuProyectoPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(AgilhuProyectoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(AgilhuProyectoPeer::PRO_ID);
			$selectCriteria->add(AgilhuProyectoPeer::PRO_ID, $criteria->remove(AgilhuProyectoPeer::PRO_ID), $comparison);

		} else { // $values is AgilhuProyecto object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseAgilhuProyectoPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseAgilhuProyectoPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the agilhu_proyecto table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(AgilhuProyectoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(AgilhuProyectoPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a AgilhuProyecto or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or AgilhuProyecto object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      PropelPDO $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 public static function doDelete($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(AgilhuProyectoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			AgilhuProyectoPeer::clearInstancePool();

			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof AgilhuProyecto) {
			// invalidate the cache for this single object
			AgilhuProyectoPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key



			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(AgilhuProyectoPeer::PRO_ID, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
				// we can invalidate the cache for this single object
				AgilhuProyectoPeer::removeInstanceFromPool($singleval);
			}
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);

			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given AgilhuProyecto object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      AgilhuProyecto $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(AgilhuProyecto $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(AgilhuProyectoPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(AgilhuProyectoPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach ($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(AgilhuProyectoPeer::DATABASE_NAME, AgilhuProyectoPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = AgilhuProyectoPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
        }
    }

    return $res;
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     AgilhuProyecto
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = AgilhuProyectoPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(AgilhuProyectoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(AgilhuProyectoPeer::DATABASE_NAME);
		$criteria->add(AgilhuProyectoPeer::PRO_ID, $pk);

		$v = AgilhuProyectoPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	/**
	 * Retrieve multiple objects by pkey.
	 *
	 * @param      array $pks List of primary keys
	 * @param      PropelPDO $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(AgilhuProyectoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(AgilhuProyectoPeer::DATABASE_NAME);
			$criteria->add(AgilhuProyectoPeer::PRO_ID, $pks, Criteria::IN);
			$objs = AgilhuProyectoPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseAgilhuProyectoPeer

// This is the static code needed to register the MapBuilder for this table with the main Propel class.
//
// NOTE: This static code cannot call methods on the AgilhuProyectoPeer class, because it is not defined yet.
// If you need to use overridden methods, you can add this code to the bottom of the AgilhuProyectoPeer class:
//
// Propel::getDatabaseMap(AgilhuProyectoPeer::DATABASE_NAME)->addTableBuilder(AgilhuProyectoPeer::TABLE_NAME, AgilhuProyectoPeer::getMapBuilder());
//
// Doing so will effectively overwrite the registration below.

Propel::getDatabaseMap(BaseAgilhuProyectoPeer::DATABASE_NAME)->addTableBuilder(BaseAgilhuProyectoPeer::TABLE_NAME, BaseAgilhuProyectoPeer::getMapBuilder());
