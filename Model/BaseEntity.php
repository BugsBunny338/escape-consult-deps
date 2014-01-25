<?php

namespace jb\Model;

/**
 * 
 *
 * @author Jakub Bárta <jakub.barta@gmail.com>
 */
abstract class BaseEntity extends \Nella\Doctrine\Entity {

    public function setValues($values = array()) {
        $values = (array) $values;
	foreach ($values as $k => $v) {
	    if ($k != 'id'  && method_exists($this, "set".  ucfirst($k))) {
		$k = ucfirst($k);
		$this->{"set$k"}($v);
	    }
		
	}
    }
    public function toArray() {
        $reflection = new \ReflectionClass($this);
        $publicMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        
        $details = array();
        
        foreach ($publicMethods as $method) {
            $propertyName = lcfirst(substr($method->getName(), 3));
            if ((substr($method->getName(), 0, 3) == "get") and ($reflection->hasProperty($propertyName))) {
                $details[$propertyName] = $this->{$method->getName()}();
            }
        }
        $details['id'] = $this->getId();
        
        return $details;
    }

}

?>
