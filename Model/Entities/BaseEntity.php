<?php

namespace jb\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * 
 *
 * @author Jakub Bárta <jakub.barta@gmail.com>
 */
abstract class BaseEntity extends \Kdyby\Doctrine\Entities\IdentifiedEntity {

    public function getRelations() {
        return null;
    }
    
    public function setValues($values = array()) {
        $values = (array) $values;
        $properties = $this->getPropertiesNames();
	foreach ($values as $k => $v) {
	   	if (in_array($k, $properties)) {
                    $setterName = "set".ucfirst($k);
                    $reflection = new \ReflectionClass($this);
                    if ($reflection->hasMethod($setterName)) {
                        $this->{$setterName}($v);
                    }
                    else {
                        $this->$k = $v;
                    }
                }
	}
    }
    public function toArray() {
        $result = array();
        foreach ($this->getPropertiesNames() as $name) {
            
            $result[$name] = $this->$name;
        }
        $result['id'] = $this->getId();
        
        return $result;
    }
    
    protected function getPropertiesNames() {
        $reflection = new \ReflectionClass($this);
        $result = array();
        foreach ($reflection->getProperties() as $reflectionProperty) {
            if (!$reflectionProperty->isStatic()) {
                $result[] = $reflectionProperty->name;
            }
        }
        
        return $result;
    }
    
    public function &__get($name) {
        $val = parent::__get($name);
        if (is_array($val)) {
            $this->$name = new ArrayCollection($val);
            return $this->$name;
        }
        else {
            return $val;
        }
    }
    

}

?>
