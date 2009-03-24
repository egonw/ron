<?php
  $inchi = substr($_SERVER['REQUEST_URI'],2);

  print "<!-- $inchi -->\n";

  $pos = strpos($inchi, 'info:inchi/');
  if ($pos === 0) {
    $inchi = substr($inchi, 11);
  }

  print "<!-- $inchi -->\n";

  if (strlen($inchi) === 0) {
    $inchi = "InChI=1/CH4/h1H4";
  }
?>

<rdf:Description
 rdf:about="http://rdf.openmolecules.net/?<?php echo $inchi;?>">

  <dc:source>ChemSpider</dc:source>

<?php

include_once("getcontent.php");

$url = "http://inchis.chemspider.com/Resolver.aspx?q=" . urlencode($inchi);
$content = get_content($url);
# aspx?id=1& 
preg_match("/aspx\?id=(\d*)/", $content, $matches, PREG_OFFSET_CAPTURE);

foreach ($matches as $value) {
  # pick only one, the last
  echo "<!-- CSID found: " . $value[0] . " -->\n";
  # $chebi = $value[0];
  echo "<rdfomn:csid>" . $value[0] . "</rdfomn:csid>";
  # echo "<owl:sameAs rdf:resource=\"http://bio2rdf.org/chebi:" . $value[0] . "\"/>";
}

?>

</rdf:Description>
