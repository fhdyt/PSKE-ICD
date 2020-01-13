 <?php
//class untuk perintah cepat seperti view info user login
CLASS INVENTORY{

	public function __construct(){
		$this->CONFIG=new CONFIG();
		$this->INVENTORY_CONFIG=new INVENTORY_CONFIG();
		$this->ICD_STATION_ID=new ICD_STATION_ID();
	}

	public function inventory_requester($params){
		$this->load->module=$this->ICD_STATION_ID->load($params);
		return $this;
	}

	public function help(){
		$result=get_class_methods($this);
		return $result;
	}

}//end class

$INVENTORY=new INVENTORY(); //aktifkan RECRUITMENT class
?>
