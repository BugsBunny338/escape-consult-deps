<?php

namespace jb\Model\Services;
/**
 * Description of BaseService
 *
 * @author Jakub Barta <jakub.barta@gmail.com>
 */
abstract class BaseService {
    private $className;
    
    public function __construct($entityName) {
        $this->className = $entityName;
    }
    
    public function buildFromFormData($data) {
        $entity = new $this->className;
        $entity->setValues($data);
        return $entity;
    }
}
