<!DOCTYPE html>
    <html>
    <head>
    <title>Checker BINs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</head>
    <body> 
        <br><br><br><br><br><br><br><br><br><br><br><br><br><center><div class="card" style="width:100rem;">
            <center><h5 class="card-header">Informação de BIN's</h5></center>
            <div class="card-body" >
              <center><h5 class="card-title">Coloca a BIN que desejas checkar no espaço abaixo ⬇️</h5><br></center>
			  <?php
			  if(isset($_POST['checkBIN'])){
				$bin = strip_tags($_POST['bin']);
				
				$Api_url = "https://lookup.binlist.net/$bin";
					  
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_URL, $Api_url);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       
					
				$data = curl_exec($ch);
				
				$responsecode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
				
				curl_close($ch);    
					
				$json = json_decode($data, true);
				if($responsecode != 400) {
					$type = ucfirst($json["type"]);
					if($type != null) {
						$brand = ucfirst($json["scheme"]);
						$brandemoji = "<i class='fa-brands fa-cc-" . $json["scheme"] . "'></i>";
						$level = $json["brand"];
						$country = $json["country"]["name"];
						$country_alpha = $json["country"]["alpha2"];
						$countrycurrency = $json["country"]["currency"];
						$bank = $json["bank"]["name"];
				
			  ?>
              <div class="alert alert-success" style="width:80rem;" role="alert">
                Conseguimos obter os seguintes resultados: ⬇️<br>
				<br>💳 BIN: <?php echo $bin; ?>
				<br>💳 MARCA: <?php echo $brandemoji . " " . $brand; ?>
				<br>💳 TIPO: <?php echo $type; ?>
				<br>💳 NIVEL: <?php echo $level; ?>
                <br>💳 BANCO: <?php echo $bank; ?>
                <br>💳 MOEDA: <?php echo $countrycurrency; ?> 
                <br>💳 PAÍS: <?php echo $country; ?> (<?php echo $country_alpha; ?>)  
              </div>
			  <?php
			  } else {
			  ?>
			  <div class="alert alert-danger" style="width:80rem;" role="alert">
                A BIN introduzida está inválida!
              </div>
			  <?php
			  }} else {
			  ?>
			  <div class="alert alert-danger" style="width:80rem;" role="alert">
                A BIN introduzida está inválida!
              </div>
			  <?php 
			  }}
			  ?>
			  <form action="" method="POST">
              <input type="text" class="form-control" id="bin" name="bin" style="width:50rem;" placeholder="Coloca aqui a BIN...">
              <br><br><center><button type="submit" name="checkBIN" class="btn btn-warning">Checkar BIN</button></form></center>
            </div> 
          </div></center>
    </body>
    </html>
