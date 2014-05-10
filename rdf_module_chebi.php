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
  if (strlen($inchi) < 8 ||
      (substr($inchi, 0,8) != "InChI=1/" &&
       substr($inchi, 0,9) != "InChI=1S/")) {
    $inchi = "InChI=1/CH4/h1H4";
  }
?>

<rdf:Description
 rdf:about="http://rdf.openmolecules.net/?<?php echo $inchi;?>">

  <dc:source>ChEBI</dc:source>

<?php

include_once("getcontent.php");

$url = "http://www.ebi.ac.uk/chebi/searchFreeText.do?searchString=" . urlencode($inchi);
$content = get_content($url);
preg_match("/CHEBI:(\d*)/", $content, $matches, PREG_OFFSET_CAPTURE);
# pick only one, the last
foreach ($matches as $value) {
    if (!ereg("CHEBI", $value[0])) {
        # echo "CHEBI found: " . $value[0] . "\n";
        # $chebi = $value[0];
        if ($value[0] != "15377") { // the default 'water' if nothing was found
          echo "<rdfomn:chebiid>CHEBI:" . $value[0] . "</rdfomn:chebiid>";
          echo "<owl:sameAs rdf:resource=\"http://bio2rdf.org/chebi:" . $value[0] . "\"/>";
        }
    }
}

?>

</rdf:Description>
