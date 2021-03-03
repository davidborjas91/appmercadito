<?php
	//define('SERVIDOR','172.20.10.238'); //HOST CASA
	//define('SERVIDOR','192.168.2.204'); //HOST OFICINA
	define('SERVIDOR','bfdtechnologies.info'); //HOST OFICINA
	//define('SERVIDOR','localhost'); //HOST OFICINA
	define('USUARIO','bfdtechn_jborjas');
	define('PASS','Job.2021**');
	//define('BD','bfdtechn_mimercadito');

	define('BD','bfdtechn_app_mercadito_prod');
	$n=0;
	/*$host_db = "localhost";
	$user_db = "root";
	$pass_db = "";
	$db_name = "controlac";
	$n=0;
	$result;$conexion;
	//insert into sist_usuario_x_empresa SELECT null,'3',c_empresa,now(),'FERAZO','1',null,null FROM neg_empresa



	*/
	//$tbl_name = "tbl_usuarios";
	//$conexion = new mysqli(SERVIDOR, USUARIO, PASS, BD);
	class BaseDatos
	{
		public $conexion;
		public $conexion2;
		protected $db;
		protected $db2;

		public function conectar()
	    {
	    	$con=true;
			$this->conexion = new mysqli(SERVIDOR, USUARIO, PASS, BD);
			if ($this->conexion->connect_error) {
				$con=false;//die("La conexion falló: " . $this->conexion->connect_error);
			}
			$this->conexion->autocommit(FALSE);

			/*
	        $this->conexion = mysql_connect(HOST, USER, PASS);
	        if ($this->conexion == 0) DIE("Lo sentimos, no se ha podido conectar con MySQL: " . mysql_error());
	        $this->db = mysql_select_db(DBNAME, $this->conexion);
	        if ($this->db == 0) DIE("Lo sentimos, no se ha podido conectar con la base datos: " . DBNAME);*/

	        return $con;

	    }
	    public function conectar2()
	    {
	    	$con=true;
			$this->conexion2 = new mysqli(SERVIDOR, USUARIO, PASS, BD);
			if ($this->conexion2->connect_error) {
				$con=false;//die("La conexion falló: " . $this->conexion->connect_error);
			}

			/*
	        $this->conexion = mysql_connect(HOST, USER, PASS);
	        if ($this->conexion == 0) DIE("Lo sentimos, no se ha podido conectar con MySQL: " . mysql_error());
	        $this->db = mysql_select_db(DBNAME, $this->conexion);
	        if ($this->db == 0) DIE("Lo sentimos, no se ha podido conectar con la base datos: " . DBNAME);*/

	        return $con;

	    }

	    public function desconectar()
	    {
	        if ($this->conexion) {
	            mysqli_close($this->conexion);
	        }

	    }
	}

	$db = new BaseDatos();
	$db2 = new BaseDatos();


		/*if ($conexion->connect_error) {
		die("La conexion falló: " . $conexion->connect_error);
		}*/

		//$result = $conexion->query($sql);
		/*function consulta($query1)
		{
			echo "consulta: ".$query1;
			$result = $conexion->query($query1);
			return $result;
		}*//*
		function host($var)
		{
			$host_db=$var;
		} *//*
	echo "Host: ".$mysqli1->$host_db;
	$mysqli1->$host_db='prueba';
	echo "Host: ".$mysqli1->$host_db;*/

	/*class Foo {
    public $aMemberVar = 'aMemberVar Member Variable';
    public $aFuncName = 'aMemberFunc';


    function aMemberFunc() {
        print 'Inside `aMemberFunc()`';
    }
}

$foo = new Foo; */

?>
