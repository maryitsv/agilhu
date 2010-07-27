<?php

/**
 * Base static class for performing query and update operations on the 'agilhu_documento' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Mon Jun 28 16:09:55 2010
 *
 * @package    lib.model.om
 */
abstract class BaseAgilhuDocumentoPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'agilhu_documento';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.AgilhuDocumento';

	/** The total number of columns. */
	const NUM_COLUMNS = 12;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** the column name for the DOC_ID field */
	const DOC_ID = 'agilhu_documento.DOC_ID';

	/** the column name for the DOC_NOMBRE field */
	const DOC_NOMBRE = 'agilhu_documento.DOC_NOMBRE';

	/** the column name for the DOC_DESCRIPCION field */
	const DOC_DESCRIPCION = 'agilhu_documento.DOC_DESCRIPCION';

	/** the column name for the DOC_TAMANO field */
	const DOC_TAMANO = 'agilhu_documento.DOC_TAMANO';

	/** the column name for the DOC_TIPO field */
	const DOC_TIPO = 'agilhu_documento.DOC_TIPO';

	/** the column name for the DOC_CONTENIDO field */
	const DOC_CONTENIDO = 'agilhu_documento.DOC_CONTENIDO';

	/** the column name for the DOC_ID_PRO field */
	const DOC_ID_PRO = 'agilhu_documento.DOC_ID_PRO';

	/** the column name for the DOC_ID_MOD field */
	const DOC_ID_MOD = 'agilhu_documento.DOC_ID_MOD';

	/** the column name for the DOC_ID_HIS field */
	const DOC_ID_HIS = 'agilhu_documento.DOC_ID_HIS';

	/** the column name for the DOC_ID_REMITENTE field */
	const DOC_ID_REMITENTE = 'agilhu_documento.DOC_ID_REMITENTE';

	/** the column name for the DOC_VISIBILIDAD field */
	const DOC_VISIBILIDAD = 'agilhu_documento.DOC_VISIBILIDAD';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'agilhu_documento.CREATED_AT';

	/**
	 * An identiy map to hold any loaded instances of AgilhuDocumento objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array AgilhuDocumento[]
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
		BasePeer::TYPE_PHPNAME => array ('DocId', 'DocNombre', 'DocDescripcion', 'DocTamano', 'DocTipo', 'DocContenido', 'DocIdPro', 'DocIdMod', 'DocIdHis', 'DocIdRemitente', 'DocVisibilidad', 'CreatedAt', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('docId', 'docNombre', 'docDescripcion', 'docTamano', 'docTipo', 'docContenido', 'docIdPro', 'docIdMod', 'docIdHis', 'docIdRemitente', 'docVisibilidad', 'createdAt', ),
		BasePeer::TYPE_COLNAME => array (self::DOC_ID, self::DOC_NOMBRE, self::DOC_DESCRIPCION, self::DOC_TAMANO, self::DOC_TIPO, self::DOC_CONTENIDO, self::DOC_ID_PRO, self::DOC_ID_MOD, self::DOC_ID_HIS, self::DOC_ID_REMITENTE, self::DOC_VISIBILIDAD, self::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('doc_id', 'doc_nombre', 'doc_descripcion', 'doc_tamano', 'doc_tipo', 'doc_contenido', 'doc_id_pro', 'doc_id_mod', 'doc_id_his', 'doc_id_remitente', 'doc_visibilidad', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('DocId' => 0, 'DocNombre' => 1, 'DocDescripcion' => 2, 'DocTamano' => 3, 'DocTipo' => 4, 'DocContenido' => 5, 'DocIdPro' => 6, 'DocIdMod' => 7, 'DocIdHis' => 8, 'DocIdRemitente' => 9, 'DocVisibilidad' => 10, 'CreatedAt' => 11, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('docId' => 0, 'docNombre' => 1, 'docDescripcion' => 2, 'docTamano' => 3, 'docTipo' => 4, 'docContenido' => 5, 'docIdPro' => 6, 'docIdMod' => 7, 'docIdHis' => 8, 'docIdRemitente' => 9, 'docVisibilidad' => 10, 'createdAt' => 11, ),
		BasePeer::TYPE_COLNAME => array (self::DOC_ID => 0, self::DOC_NOMBRE => 1, self::DOC_DESCRIPCION => 2, self::DOC_TAMANO => 3, self::DOC_TIPO => 4, self::DOC_CONTENIDO => 5, self::DOC_ID_PRO => 6, self::DOC_ID_MOD => 7, self::DOC_ID_HIS => 8, self::DOC_ID_REMITENTE => 9, self::DOC_VISIBILIDAD => 10, self::CREATED_AT => 11, ),
		BasePeer::TYPE_FIELDNAME => array ('doc_id' => 0, 'doc_nombre' => 1, 'doc_descripcion' => 2, 'doc_tamano' => 3, 'doc_tipo' => 4, 'doc_contenido' => 5, 'doc_id_pro' => 6, 'doc_id_mod' => 7, 'doc_id_his' => 8, 'doc_id_remitente' => 9, 'doc_visibilidad' => 10, 'created_at' => 11, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	/**
	 * Get a (singleton) instance of the MapBuilder for this peer class.
	 * @return     MapBuilder The map builder for this peer
	 */
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new AgilhuDocumentoMapBuilder();
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
	 * @param      string $column The column name for current table. (i.e. AgilhuDocumentoPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(AgilhuDocumentoPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(AgilhuDocumentoPeer::DOC_ID);

		$criteria->addSelectColumn(AgilhuDocumentoPeer::DOC_NOMBRE);

		$criteria->addSelectColumn(AgilhuDocumentoPeer::DOC_DESCRIPCION);

		$criteria->addSelectColumn(AgilhuDocumentoPeer::DOC_TAMANO);

		$criteria->addSelectColumn(AgilhuDocumentoPeer::DOC_TIPO);

		$criteria->addSelectColumn(AgilhuDocumentoPeer::DOC_CONTENIDO);

		$criteria->addSelectColumn(AgilhuDocumentoPeer::DOC_ID_PRO);

		$criteria->addSelectColumn(AgilhuDocumentoPeer::DOC_ID_MOD);

		$criteria->addSelectColumn(AgilhuDocumentoPeer::DOC_ID_HIS);

		$criteria->addSelectColumn(AgilhuDocumentoPeer::DOC_ID_REMITENTE);

		$criteria->addSelectColumn(AgilhuDocumentoPeer::DOC_VISIBILIDAD);

		$criteria->addSelectColumn(AgilhuDocumentoPeer::CREATED_AT);

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
		$criteria->setPrimaryTableName(AgilhuDocumentoPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			AgilhuDocumentoPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(AgilhuDocumentoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}


    foreach (sfMixer::getCallables('BaseAgilhuDocumentoPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseAgilhuDocumentoPeer', $criteria, $con);
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
	 * @return     AgilhuDocumento
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = AgilhuDocumentoPeer::doSelect($critcopy, $con);
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
		return AgilhuDocumentoPeer::populateObjects(AgilhuDocumentoPeer::doSelectStmt($criteria, $con));
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

    foreach (sfMixer::getCallables('BaseAgilhuDocumentoPeer:doSelectStmt:doSelectStmt') as $callable)
    {
      call_user_func($callable, 'BaseAgilhuDocumentoPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(AgilhuDocumentoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			AgilhuDocumentoPeer::addSelectColumns($criteria);
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
	 * @param      AgilhuDocumento $value A AgilhuDocumento object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool(AgilhuDocumento $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getDocId();
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
	 * @param      mixed $value A AgilhuDocumento object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof AgilhuDocumento) {
				$key = (string) $value->getDocId();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or AgilhuDocumento object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
	 * @return     AgilhuDocumento Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
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
		$cls = AgilhuDocumentoPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = AgilhuDocumentoPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = AgilhuDocumentoPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				AgilhuDocumentoPeer::addInstanceToPool($obj, $key);
			} // if key exists
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
		return AgilhuDocumentoPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a AgilhuDocumento or Criteria object.
	 *
	 * @param      mixed $values Criteria or AgilhuDocumento object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseAgilhuDocumentoPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseAgilhuDocumentoPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(AgilhuDocumentoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from AgilhuDocumento object
		}

		if ($criteria->containsKey(AgilhuDocumentoPeer::DOC_ID) && $criteria->keyContainsValue(AgilhuDocumentoPeer::DOC_ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.AgilhuDocumentoPeer::DOC_ID.')');
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

		
    foreach (sfMixer::getCallables('BaseAgilhuDocumentoPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseAgilhuDocumentoPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a AgilhuDocumento or Criteria object.
	 *
	 * @param      mixed $values Criteria or AgilhuDocumento object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseAgilhuDocumentoPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseAgilhuDocumentoPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(AgilhuDocumentoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(AgilhuDocumentoPeer::DOC_ID);
			$selectCriteria->add(AgilhuDocumentoPeer::DOC_ID, $criteria->remove(AgilhuDocumentoPeer::DOC_ID), $comparison);

		} else { // $values is AgilhuDocumento object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseAgilhuDocumentoPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseAgilhuDocumentoPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the agilhu_documento table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(AgilhuDocumentoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(AgilhuDocumentoPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a AgilhuDocumento or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or AgilhuDocumento object or primary key or array of primary keys
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
			$con = Propel::getConnection(AgilhuDocumentoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			AgilhuDocumentoPeer::clearInstancePool();

			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof AgilhuDocumento) {
			// invalidate the cache for this single object
			AgilhuDocumentoPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key



			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(AgilhuDocumentoPeer::DOC_ID, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
				// we can invalidate the cache for this single object
				AgilhuDocumentoPeer::removeInstanceFromPool($singleval);
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
	 * Validates all modified columns of given AgilhuDocumento object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      AgilhuDocumento $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(AgilhuDocumento $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(AgilhuDocumentoPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(AgilhuDocumentoPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(AgilhuDocumentoPeer::DATABASE_NAME, AgilhuDocumentoPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = AgilhuDocumentoPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
        }
    }

    return $res;
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     AgilhuDocumento
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = AgilhuDocumentoPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(AgilhuDocumentoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(AgilhuDocumentoPeer::DATABASE_NAME);
		$criteria->add(AgilhuDocumentoPeer::DOC_ID, $pk);

		$v = AgilhuDocumentoPeer::doSelect($criteria, $con);

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
			$con = Propel::getConnection(AgilhuDocumentoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(AgilhuDocumentoPeer::DATABASE_NAME);
			$criteria->add(AgilhuDocumentoPeer::DOC_ID, $pks, Criteria::IN);
			$objs = AgilhuDocumentoPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseAgilhuDocumentoPeer

// This is the static code needed to register the MapBuilder for this table with the main Propel class.
//
// NOTE: This static code cannot call methods on the AgilhuDocumentoPeer class, because it is not defined yet.
// If you need to use overridden methods, you can add this code to the bottom of the AgilhuDocumentoPeer class:
//
// Propel::getDatabaseMap(AgilhuDocumentoPeer::DATABASE_NAME)->addTableBuilder(AgilhuDocumentoPeer::TABLE_NAME, AgilhuDocumentoPeer::getMapBuilder());
//
// Doing so will effectively overwrite the registration below.

Propel::getDatabaseMap(BaseAgilhuDocumentoPeer::DATABASE_NAME)->addTableBuilder(BaseAgilhuDocumentoPeer::TABLE_NAME, BaseAgilhuDocumentoPeer::getMapBuilder());
