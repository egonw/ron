<?php
  $inchi = substr($_SERVER['REQUEST_URI'],10); # 2 when no standalone

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
 rdf:about="http://cb.openmolecules.net/rdf/?<?php echo $inchi;?>">

  <dc:source>PubChem</dc:source>

<?php

function get_content($url)
{
    $ch = curl_init();

    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_HEADER, 0);

    ob_start();

    curl_exec ($ch);
    curl_close ($ch);
    $string = ob_get_contents();

    ob_end_clean();

    echo $string;
   
    return $string;    
}

$url = "http://www.ncbi.nlm.nih.gov/entrez/query.fcgi?CMD=search&DB=pcsubstance&term=%22". $inchi . "%22[InChI]";
echo "URL: " . $url;
$content = get_content($url);
echo $content;
preg_match("/sid=(\d*)/", $content, $matches, PREG_OFFSET_CAPTURE);
# pick only one, the first
foreach ($matches as $value) {
    echo "<!-- $matches -->";
    if (!ereg("CHEBI", $value[0])) {
        # echo "CHEBI found: " . $value[0] . "\n";
        # $chebi = $value[0];
        echo "<rdfomn:chebiid>CHEBI:" . $value[0] . "</rdfomn:chebiid>";
    }
}

?>

</rdf:Description>
