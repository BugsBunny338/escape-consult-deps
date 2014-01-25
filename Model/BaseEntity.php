<?php

namespace jb\Model;

/**
 * 
 *
 * @author Jakub Bárta <jakub.barta@gmail.com>
 */
abstract class BaseEntity extends \Kdyby\Doctrine\Entities\IdentifiedEntity {

    public function setValues($values = array()) {
        $values = (array) $values;
        $properties = $this->getPropertiesNames();
	foreach ($values as $k => $v) {
	   	if (in_array($k, $properties)) {
                       $this->$k = $v;
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
            $result[] = $reflectionProperty->name;
        }
        
        return $result;
    }

}

?>
