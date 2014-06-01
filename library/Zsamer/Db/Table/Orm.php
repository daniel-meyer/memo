<?php
/**
 * Zsamer Framework
 *
 * @category   Zsamer
 * @package    Zsamer_Db
 * @subpackage Table
 * @copyright  Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC (http://www.bolsadeideas.cl)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Zsamer_Db_Table_Orm
 *
 * It extends Zend_Db_Table_Abstract class to provide more functionality for ORM
 * Object-relational mapping (aka ORM, O/RM, and O/R mapping)
 *
 * @author Andres Guzman F. <aguzman@bolsadeideas.cl>
 */

/**
 * @see Zend_Db_Table_Abstract
 */
require_once 'Zend/Db/Table/Abstract.php';

abstract class Zsamer_Db_Table_Orm extends Zend_Db_Table_Abstract
{
	protected $_rowClass = 'Zsamer_Db_Table_Row_Orm';
    
    protected function _checkRow($row)
    {
        if($row instanceof Zsamer_Db_Table_Row_Orm && $row->isEmpty()){
            return null;
        }
        return $row;
    }
    
    public function create(array $data = array())
	{
		return $this->createRow($data);
	}
    
	public function findAll()
	{
		return $this->fetchAll();
	}
    public function findBy(array $criteria, $order = null)
	{
		$where = array();
        foreach($criteria as $k=>$v){
            $where[$k . '=?'] = $v;
        }
        $orderBy = array();
        foreach((array)$order as $k=>$v){
            $orderBy[] = $k . ' ' . $v;
        }
        return $this->fetchAll($where, $orderBy);
	}
    
    public function indexBy(array $criteria, $columnName = null)
	{
		$array = $this->findBy($criteria);
        
        $out = array();
        foreach($array as $v){
            $out[ $v->$columnName ] = $v;
        }
        return $out;
	}
    
    public function fetchPairs($columnKey, $columnValue, array $criteria = array())
	{
		$select = $this->select()->from($this, array($columnKey, $columnValue));
        $select->setIntegrityCheck(false);
        foreach($criteria as $k=>$v){
            $select->where($k, $v);
        }
        return $this->getDefaultAdapter()->fetchPairs($select);
	}
    
	public function findById($id)
	{
		if(empty($id)){
		  return null;
		}
        return $this->_checkRow($this->find($id)->current());
	}
    
    public function findBySlug($slug)
	{
		if(empty($slug)){
		  return null;
		}
        $where = array('slug=?'=>$slug);
        return $this->_checkRow($this->fetchRow($where));
	}
    
    public function findOneBy(array $criteria)
	{
		$where = array();
        foreach($criteria as $k=>$v){
            $where[$k . '=?'] = $v;
        }
        return $this->_checkRow($this->fetchRow($where));
	}
    
    public function count(array $criteria = array())
	{
		$select = $this->select()->from($this, array('amount'=>'COUNT(*)'));
        $select->setIntegrityCheck(false);
        foreach($criteria as $k=>$v){
            $select->where($k, $v);
        }
        return (int)$this->getDefaultAdapter()->fetchOne($select);
	}

    public function max($columnName, $criteria = null)
	{
		$select = $this->select()->from($this, array('max'=>'MAX('.$columnName.')'));
        $criteria = (array)$criteria;
        foreach($criteria as $k=>$v){
            $select->where($k, $v);
        }
        return (int)$this->getDefaultAdapter()->fetchOne($select);
	}

	public function getReferenceMapOrm()
	{
		return $this->_referenceMap;
	}

	public function getReferenceMapOrmKey()
	{
		return array_keys($this->_referenceMap);
	}
    
    public function prepareSelect($select)
    {
        $fromData = $select->getPart( Zend_Db_Select::FROM );
        $columns = $select->getPart( Zend_Db_Select::COLUMNS );
        
        

        $select->reset( Zend_Db_Select::COLUMNS );
        
        $firstTable = key($fromData);
        array_shift($fromData);
        
        $select->columns('*', $firstTable); 

        foreach($columns as $col)
        {
            if($col[1] == '*' && isset($fromData[ $col[0] ])){
                $fromData[ $col[0] ]['prepare'] = 1;    
            }
        }
        foreach($fromData as $k=>$item)
        {
            if(!empty($item['prepare'])){
                $table = Orm::table($item['tableName']);
                $cols = $table->info('cols');
                $newCols = array();
                foreach($cols as $col)
                {
                    $newCols[$item['tableName'] . '_' . $col] = $col;
                }
                $select->columns($newCols, $k); 
            }
        }
        return $select;
    }
    
    public function getPrimaryKeys(){
        $this->_getPrimaryKey();
    }
    
}
