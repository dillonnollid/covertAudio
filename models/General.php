<?php 
namespace models;

use models\Database;
/**
 * Abstract General Model to encapsulate common functionality and properties used by Album, Artist, Song and Genre models. Reduced code duplication and enforced consistency. 
 */
abstract class General {
    protected $con;
    protected $id;
    protected $name;
    protected $mysqliData;

    public function __construct($id) {
        $this->con = Database::getInstance()->getConnection();
        $this->id = $id;
    }

    public function getID(){
        return $this->id;
    }

    public function getName() {
		return $this->name;
	}

    /* These abstract methods must be declared in each inheriting subclass! */
    abstract public function getProperties();

    abstract public function setProperties($mysqliData);
}

?>
