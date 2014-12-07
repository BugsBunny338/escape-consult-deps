<?php

namespace jb\Model\Facades;

use jb\Model\Entities\BaseEntity,
    jb\Model\Exceptions\DBException;
use Kdyby\Doctrine\EntityDao;
/**
 * Description of AbstractFacade
 *
 * @author Jakub Barta <jakub.barta@gmail.com>
 */
class BaseFacade extends \Nette\Object {
    /** @var EntityDao */
    protected $dao;
    
    public function startTransaction() {
        $this->dao->getEntityManager()->beginTransaction();
    }
    
    public function commit() {
        $this->dao->getEntityManager()->commit();
    }
    
    public function rollback() {
        $this->dao->getEntityManager()->rollback();
    }
    
    public function __construct(EntityDao $dao) {
        $this->dao = $dao;
    }
    
    public function create(BaseEntity $entity) {
        try {
            $this->startTransaction();
            $this->doCreate($entity);
            $this->commit();
        }
        catch (\Exception $e) {
            $this->rollback();
            throw $this->handleDBException($e);
        }
    }
    
    protected function doCreate(BaseEntity $entity) {
        $this->dao->save($entity, $entity->getRelations());
    }
    
    public function update(BaseEntity $entity) {
        try {
            $this->startTransaction();
            $this->doUpdate($entity);
            $this->commit();
        }
        catch (\Exception $e) {
            $this->rollback();
            throw $this->handleDBException($e);
        }
    }
    
    protected function doUpdate(BaseEntity $entity) {
        $this->dao->save();
    }


    public function remove(BaseEntity $entity) {
        try {
            $this->startTransaction();
            $this->doRemove($entity);
            $this->commit();
        }
        catch (\Exception $e) {
            $this->rollback();
            throw $this->handleDBException($e);
        }
    }
    
    protected function doRemove(BaseEntity $entity) {
        $this->dao->delete($entity, $entity->getRelations());
    }
    
    protected function handleDBException(\Exception $e) {
        return new DBException($e->getMessage(), $e->getCode());
    }
    
    public function get($id) {
        return $this->dao->find($id);
    }
    
    public function getAll() {
        return $this->dao->findAll();
    }
    
    public function getByCriteria($criteria, $orderBy = null, $limit = null, $offset = null) {
        return $this->dao->findBy($criteria, $orderBy, $limit, $offset);
    }
    
    public function getOneByCriteria($criteria) {
        return $this->dao->findOneBy($criteria);
    }
    
    public function getByColumn($column, $value) {
        return $this->getByCriteria(array($column => $value));
    }
    
    public function getOneByColumn($column, $value) {
        return $this->getOneByCriteria(array($column => $value));
    }
}

?>
