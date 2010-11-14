<?php header("Content-type: text/xml"); print "<?xml version=\"1.0\"?>\n";?>
<?php print "<?xml-stylesheet type=\"text/xsl\" href=\"http://rdf.openmolecules.net/html.xsl\"?>\n"; ?>
<?php
  $inchi = substr($_SERVER['REQUEST_URI'],2);

  $pos = strpos($inchi, 'info:inchi/');
  if ($pos === 0) {
    $inchi = substr($inchi, 11);
  }

  if (strlen($inchi) === 0) {
    $inchi = "InChI=1/CH4/h1H4";
  }
  if (strlen($inchi) < 8 ||
      (substr($inchi, 0,8) != "InChI=1/" &&
       substr($inchi, 0,9) != "InChI=1S/")) {
    $inchi = "InChI=1/CH4/h1H4";
  }
?>
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:iupac="http://www.iupac.org/"
xmlns:rdfomn="http://rdf.openmolecules.net/#"
xmlns:foaf="http://xmlns.com/foaf/0.1/"
xmlns:owl="http://www.w3.org/2002/07/owl#">

<rdf:Description
 rdf:about="http://rdf.openmolecules.net/?<?php echo $inchi;?>">

 <dc:identifier>info:inchi/<?php echo $inchi;?></dc:identifier>
 <iupac:inchi><?php echo $inchi;?></iupac:inchi>

</rdf:Description>


<?php include 'rdf_module_cb.php'?>
<?php include 'rdf_module_chebi.php'?>
<?php // include 'rdf_module_connotea.php'?>
<?php include 'rdf_module_dbpedia.php'?>
<?php include 'rdf_module_nmrshiftdb.php'?>
<?php include 'rdf_module_chemspider.php'?>

</rdf:RDF>

