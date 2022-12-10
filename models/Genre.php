<?php
class Genre {

    private $con;
    private $id;
    private $mysqliData;
    private $name;

    public function __construct($con, $id) {
        $this->con = $con;
        $this->id = $id;

        //Query on creation, store data in myslqiData array and assign the vars values
        $query = mysqli_query($this->con, "SELECT * FROM genres WHERE id='$this->id'");
        $this->mysqliData = mysqli_fetch_array($query);
        $this->name = $this->mysqliData['name'];
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getMysqliData() {
        return $this->mysqliData;
    }

}
?>