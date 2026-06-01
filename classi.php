<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Classi Php</title>
</head>

<body>
	<?php
	class Auto {
		
		//proprietà
		public $marca;
		public $modello;
		public $colore;
		
		public function __construct($marca, $modello, $colore){
			$this->$marca = $marca;
			$this->$modello = $modello;
			$this->$colore = $colore;
		}
	}
	?>
</body>
</html>