<?php

  // print "<!-- " . $_SERVER['REQUEST_URI'] . " -->\n";

  $inchi = substr($_SERVER['REQUEST_URI'],2);

  // print "<!-- $inchi -->\n";

  $pos = strpos($inchi, 'info:inchi/');
  if ($pos === 0) {
    $inchi = substr($inchi, 11);
  }

  // print "<!-- $inchi -->\n";

  if (strlen($inchi) === 0) {
    $inchi = "InChI=1S/CH4/h1H4";
  }

  $pos = strpos($inchi, 'InChI=1S/');
  print "<!-- $pos -->\n";
  if ($pos === 0) {

    print "<!-- $inchi -->\n";

    print "<rdf:Description\n";
    print "  rdf:about=\"http://rdf.openmolecules.net/?" . $inchi . "\">\n";
    print "  <dc:source>OpenTox</dc:source>\n";

    include_once("getcontent.php");

    $url = "http://apps.ideaconsult.net:8080/ambit2/query/compound/search/all?media=text/uri-list&search=" . urlencode($inchi);
    // echo " url: " . $url . " \n";
    $content = get_content($url);
    // echo " content: " . $content . "\n";
    # pick only one, the last
    if (strpos($content, "Not Found")) {
    } else {
      foreach (preg_split("/(\r?\n)/", $content) as $value) {
        if (strlen(trim($value)) > 0) {
          // echo " found: " . $value . "\n";
          echo "<foaf:homepage rdf:resource=\"" . $value . "\"/>";
        }
      }
    }

    print "</rdf:Description>\n";
}
