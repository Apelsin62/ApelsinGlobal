<?php
class MySqlHelper {
    private $data;
    
    public function __construct($query) {
        $this->data = array();
        $mysqli = MySqliConnectHelper::getConection();
        $result = $mysqli->query($query);
        $i=0;
        if($result!=null) {
            while($row = $result->fetch_assoc()){
                foreach (array_keys($row) as $key) {
                    $this->data[$i][$key] = $row[$key];
                }
                $i++;
            }
        } else {
            $this->data = null;
        }
    }
    
    public function getAllData(){
        return $this->data;
    }
    
    public function getDataRow($i){
        if(count($this->data)>($i)) {
            return $this->data[$i];
        } else {
            return null;
        }
    }
    
    public function getDataKeys(){
        $keys = array();
        if(count($this->data)>0){
            foreach ($this->data as $date){
                foreach (array_keys($date) as $key) {
                    if(!in_array($key, $keys)) {
                        $keys[]=$key;
                    }
                }
            }
        }
        return $keys;
    }
}

class MySqlInserHelper {
    private $mysqli;
    private $query;
    
    public function __construct($query) {
        global $_DBSETTINGS;
        $this->query = $query;
        $this->mysqli = MySqliConnectHelper::getConection();
    }
    
    public function insert() {
        $this->mysqli->query($this->query);
    }
}
?>
