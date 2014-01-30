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
abstract class AbstractFacade extends \Nette\Object {
    /** @var EntityDao */
    protected $dao;
    
    public function __construct(EntityDao $dao) {
        $this->dao = $dao;
    }
    
    public function create(BaseEntity $entity) {
        try {
            $this->doCreate($entity);
        }
        catch (\Exception $e) {
            throw $this->handleDBException($e);
        }
    }
    
    protected function doCreate(BaseEntity $entity) {
        $this->dao->save($entity, $entity->getRelations());
    }
    
    public function update(BaseEntity $entity) {
        try {
            $this->doUpdate($entity);
        }
        catch (\Exception $e) {
            throw $this->handleDBException($e);
        }
    }
    
    protected function doUpdate(BaseEntity $entity) {
        $this->dao->save();
    }


    public function remove(BaseEntity $entity) {
        try {
            $this->doRemove($entity);
        }
        catch (\Exception $e) {
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
