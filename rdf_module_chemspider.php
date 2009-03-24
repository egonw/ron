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

  $inchi = "InChI=1/CH4/h1H4"; 
?>

<rdf:Description
 rdf:about="http://rdf.openmolecules.net/?<?php echo $inchi;?>">

  <dc:source>ChemSpider</dc:source>

<?php

include_once("getcontent.php");

# because a nasty redirect is involved, it is a double loop :(

$url = "http://inchis.chemspider.com/Resolver.aspx?q=" . $inchi;
print "<!-- $url -->\n";
$content = get_content($url);
# print "<!-- " . $content . " -->";
# first, deal with the redirect
preg_match("/%2fRecord.aspx%3fid%3d(\d*)/", $content, $matches, PREG_OFFSET_CAPTURE);

foreach ($matches as $value) {
  if (!ereg("Record.aspx", $value[0])) {
    $url2 = "http://inchis.chemspider.com/Record.aspx?id=" . $value[0];
    $content2 = get_content($url2);
    # print "<!-- " . $content2 . " -->";
    # first, deal with the redirect
    preg_match("/ctl00_ContentPlaceHolder1_CompoundViewControl1_HyperLink2.*www.chemspider.com\/(\d*)/", $content2, $matches2, PREG_OFFSET_CAPTURE); 
    foreach ($matches2 as $value2) {
      if (!ereg("chemspider.com", $value2[0])) {
        echo "<!-- CSID found: " . $value2[0] . " -->\n";
        echo "<rdfomn:csid>" . $value2[0] . "</rdfomn:csid>";
        # echo "<owl:sameAs rdf:resource=\"http://bio2rdf.org/chebi:" . $value[0] . "\"/>";
      }
    }
  }
}

?>

</rdf:Description>
