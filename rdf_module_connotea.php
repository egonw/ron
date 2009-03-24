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

  <dc:source>Connotea</dc:source>

<?php

include_once("getcontent.php");

$url = "http://www.connotea.org/data/tags/uri/http://rdf.openmolecules.net/?" . $inchi;
$content = get_content($url);

echo "  <!-- $url -->\n";

preg_match_all("/<rdf:value>(.*)<\/rdf:value>/", $content, $matches, PREG_SET_ORDER);
foreach ($matches as $value) {
    echo "  <!-- $matches -->\n";
    echo "  <rdfomn:tag>" . $value[1] . "</rdfomn:tag>";
}

$url = "http://www.connotea.org/data/tags/uri/http://cb.openmolecules.net/rdf/?" . $inchi;
$content = get_content($url);

echo "  <!-- $url -->\n";

preg_match_all("/<rdf:value>(.*)<\/rdf:value>/", $content, $matches, PREG_SET_ORDER);
foreach ($matches as $value) {
    echo "  <!-- $matches -->\n";
    echo "  <rdfomn:tag>" . $value[1] . "</rdfomn:tag>";
}

#$url = "http://www.connotea.org/data/tags/uri/http://rdf.openmolecules.net/?" . $inchi;
#$content = get_content($url);

#echo "  <!-- $url -->\n";

#preg_match_all("/<rdf:value>(.*)<\/rdf:value>/", $content, $matches, PREG_SET_ORDER);
#foreach ($matches as $value) {
#    echo "  <!-- $matches -->\n";
#    echo "  <rdfomn:tag>" . $value[1] . "</rdfomn:tag>";
#}

?>

</rdf:Description>
