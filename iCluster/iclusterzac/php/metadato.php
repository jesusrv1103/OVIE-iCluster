<?php
$dato=$_GET['dato'];
?>
<html>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<head>
<style>
button.accordion {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}

button.accordion.active, button.accordion:hover {
    background-color: #ddd;
}

button.accordion:after {
    content: '\002B';
    color: #777;
    font-weight: bold;
    float: right;
    margin-left: 5px;
}

button.accordion.active:after {
    content: "\2212";
}

div.panel {
    padding: 0 18px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
}
</style>
</head>
<body>
<?php
$conn = pg_connect("host=10.221.67.10 dbname=mdm6data_zac user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());
$query = "SELECT titulo,propo,pclave,fman,fref,tfec,nconta,norga,pconta,clo,cle,cls,cln,sref,uref,datum,elipso,pproc,fuente,entatr FROM metadatos where id_capa='$dato'";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
// Printing results in HTML
$line = pg_fetch_array($result);

echo "<h2>Metadato para capa $line[0]</h2>";
?>
<button class="accordion">1. Identificación del conjunto de datos espaciales o producto.</button>
<div class="panel">
  <?php echo "<p><b>1.1 Título:</b>$line[0]</p>";
   echo "<p><b>1.2 Propósito:</b>$line[1]</p>";
   echo "<p><b>1.3 Palabras clave:</b>$line[2]</p>";
   echo "<p><b>1.1 Frecuencia de mantenimiento:</b>$line[3]</p>";?>
</div>
<button class="accordion">2. Fechas relacionadas con el conjunto de datos espaciales o producto.</button>
<div class="panel">
  <?php echo "<p><b>2.1 Fecha de referencia:</b>$line[4]</p>";
   echo "<p><b>2.2 Tipo de fecha:</b>$line[5]</p>";
   ?>
</div>

<button class="accordion">3. Parte responsable del conjunto de datos espaciales o producto.</button>
<div class="panel">
  <?php echo "<p><b>3.1 Nombre del contacto:</b>$line[6]</p>";
   echo "<p><b>3.2 Nombre de la organización:</b>$line[7]</p>";
   echo "<p><b>3.3 Puesto del contacto:</b>$line[8]</p>";
   ?>
</div>

<button class="accordion">4. Localización geográfica del conjunto de datos espaciales o producto.</button>
<div class="panel">
  <?php echo "<p><b>4.1 Coordenada límite oeste:</b>$line[9]</p>";
   echo "<p><b>4.2 Coordenada límite este:</b>$line[10]</p>";
   echo "<p><b>4.3 Coordenada límite sur:</b>$line[11]</p>";
   echo "<p><b>4.4 Coordenada límite norte:</b>$line[12]</p>";?>
</div>
<button class="accordion">5. Sistema de referencia.</button>
<div class="panel">
  <?php echo "<p><b>5.1 Sistema de referencia:</b>$line[13]</p>";
   echo "<p><b>5.2 Unidades del sistema de referencia:</b>$line[14]</p>";
   echo "<p><b>5.3 Datum:</b>$line[15]</p>";
   echo "<p><b>5.4 Elipsoide:</b>$line[16]</p>";?>
</div>
<button class="accordion">6. Calidad de la información.</button>
<div class="panel">
  <?php echo "<p><b>6.1 Pasos del proceso:</b>$line[17]</p>";
   echo "<p><b>6.2 Fuente:</b>$line[18]</p>";?>
</div>
<button class="accordion">7. Atributos.</button>
<div class="panel">
  <?php 
   echo "<p><b>7.1 Entidades y atributos:</b>$line[19]</p>";
   pg_free_result($result);		
   pg_close($conn);?>
</div>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].onclick = function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
  	  panel.style.maxHeight = null;
    } else {
  	  panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  }
}
</script>

</body>
</html>
