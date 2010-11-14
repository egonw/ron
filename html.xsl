<?xml version='1.0' encoding='utf-8'?>

<!-- Convert rdf.openmolecules.org RDF to nice HTML for users to view in their web browsers. -->

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
    xmlns:iupac="http://www.iupac.org/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:rdfomn="http://rdf.openmolecules.net/#"
    xmlns:cb="http://cb.openmolecules.net/#"    
    xmlns:pubchem="http://pubchem.ncbi.nlm.nih.gov/#"
    xmlns:foaf="http://xmlns.com/foaf/0.1/"
    xmlns:owl="http://www.w3.org/2002/07/owl#"

    exclude-result-prefixes="rdf rdfs iupac dc">
 
    <xsl:output method="html" encoding="utf-8" indent="yes"/>

    <!-- Change this depending on where we are using the development or the production server -->
    <xsl:variable name="serverRoot" select="'http://cb.openmolecules.net/'"/>

    <xsl:template match="//rdf:RDF">
        <html xmlns:chem="http://www.blueobelisk.org/chemistryblogs/">
            <head>
                <title>
                    <xsl:value-of select="//@rdf:about"/>
                    <style type="text/css"> 
                      body { font-family: Verdana,Arial,Helvetica, sans-serif; font-size: 11px; }
                      td { font-family: Verdana,Arial,Helvetica, sans-serif; font-size: 11px; }
                      .header { text-align:right; font-weight:bold; color:rgb(0,0,0); }
                    </style>                
                </title>
            </head>
            <body>
               <h2>OpenMolecules RDF</h2>
               <xsl:element name="div">
                 <xsl:attribute name="about"><xsl:value-of select="//@rdf:about"/></xsl:attribute>
                        <table>
                            <tr>
                                <td class="header">About</td>
                                <td>
                                    <xsl:value-of select="//@rdf:about"/>
                                </td>
                            </tr>
                            
                            <xsl:for-each select="//rdf:Description">
                            <tr><td><br /></td><td/></tr>

                            <xsl:apply-templates select="./dc:source"/>
                            <xsl:apply-templates select="./dc:rights"/>
                            <xsl:apply-templates select="./dc:identifier"/>

                            <xsl:apply-templates select=".//iupac:inchi"/>
                            <xsl:apply-templates select=".//cb:discussedBy"/>
                            <xsl:apply-templates select=".//pubchem:cid"/>
                            <xsl:apply-templates select=".//pubchem:name"/>
                            <xsl:apply-templates select=".//rdfomn:chebiid"/>
                            <xsl:apply-templates select=".//rdfomn:tag"/>
                            <xsl:apply-templates select=".//owl:sameAs"/>
                            <xsl:apply-templates select=".//rdfomn:nmrmolid"/>
                            <xsl:apply-templates select=".//rdfomn:csid"/> 
                            <xsl:apply-templates select=".//foaf:homepage"/>

                            </xsl:for-each>

                            <tr><td><br /></td><td/></tr>
                            <xsl:call-template name="delicious">
                                <xsl:with-param name="title">OpenMolecules RDF for <xsl:value-of select="//iupac:inchi"/></xsl:with-param>
                            </xsl:call-template>

                        </table>
               </xsl:element>

<hr />

<a href="http://www.w3.org/RDF/" title="RDF Resource Description Framework"><img border="0" 
src="http://www.w3.org/RDF/icons/rdf_powered_button.32"
alt="RDF Resource Description Framework Powered Icon"/></a>

            </body>
        </html>
    </xsl:template>

    <xsl:template match="//owl:sameAs">
        <tr>
            <td class="header">
                <xsl:text>owl:sameAs</xsl:text>
            </td>
            <td>
                <xsl:element name="a">
                  <xsl:attribute name="href"><xsl:value-of select="./@rdf:resource"/></xsl:attribute>
                  <xsl:value-of select="./@rdf:resource"/>
                </xsl:element>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="//foaf:homepage">
        <tr>
            <td class="header">
                <xsl:text>foaf:homepage</xsl:text>
            </td>
            <td>
                <xsl:element name="a">
                  <xsl:attribute name="href"><xsl:value-of select="./@rdf:resource"/></xsl:attribute>
                  <xsl:value-of select="./@rdf:resource"/>
                </xsl:element>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="//iupac:inchi">
        <tr>
            <td class="header">
                <xsl:text>InChI</xsl:text>
            </td>
            <td>
                <span property="chem:inchi"><xsl:value-of select="."/></span>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="//cb:discussedBy">
        <tr>
            <td class="header">
                <xsl:text>Blog Discussion</xsl:text>
            </td>
            <td>
                <xsl:element name="a">
                  <xsl:attribute name="href"><xsl:value-of select="."/></xsl:attribute>
                  <xsl:value-of select="."/>
                </xsl:element>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="//pubchem:cid">
        <tr>
            <td class="header">
                <xsl:text>PubChem CID</xsl:text>
            </td>
            <td>
                <xsl:element name="a">
                  <xsl:attribute name="href">http://pubchem.ncbi.nlm.nih.gov/summary/summary.cgi?cid=<xsl:value-of select="."/></xsl:attribute>
                  <xsl:value-of select="."/>
                </xsl:element>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="//rdfomn:tag">
        <tr>
            <td class="header">
                <xsl:text>Tag</xsl:text>
            </td>
            <td>
                <xsl:value-of select="."/>
            </td>
        </tr>
   </xsl:template>

   <xsl:template match="//rdfomn:csid">
        <tr>
            <td class="header">
                <xsl:text>ChemSpider ID</xsl:text>
            </td>
            <td>
                <xsl:element name="a">
                  <xsl:attribute name="href">http://www.chemspider.com/<xsl:value-of select="."/></xsl:attribute>
                  <xsl:value-of select="."/>
                </xsl:element>
            </td>
        </tr>
        <tr>
            <td class="header"/>
            <td>
                <img src="http://rdf.openmolecules.net/powered-by-chemspider.png" />
            </td>
        </tr> 
   </xsl:template>
    
   <xsl:template match="//rdfomn:chebiid">
        <tr>
            <td class="header">
                <xsl:text>ChEBI ID</xsl:text>
            </td>
            <td>
                <xsl:element name="a">
                  <xsl:attribute name="href">http://www.ebi.ac.uk/chebi/searchId.do?chebiId=<xsl:value-of select="."/></xsl:attribute>
                  <xsl:value-of select="."/>
                </xsl:element>
            </td>
        </tr>
   </xsl:template>

   <xsl:template match="//rdfomn:nmrmolid">
        <tr>
            <td class="header">
                <xsl:text>NMRShiftDB mol ID</xsl:text>
            </td>
            <td>
                <xsl:element name="a">
                  <xsl:attribute name="href">http://nmrshiftdb.ice.mpg.de/portal/js_pane/P-Results/nmrshiftdbaction/showDetailsFromHome/molNumber/<xsl:value-of select="."/></xsl:attribute>
                  <xsl:value-of select="."/>
                </xsl:element>
            </td>
        </tr>
   </xsl:template>

   <xsl:template match="//pubchem:name">
        <tr>
            <td class="header">
                <xsl:text>Name</xsl:text>
            </td>
            <td>
                  <xsl:value-of select="."/>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="//dc:identifier">
        <tr>
            <td class="header">
                <xsl:text>Identifier</xsl:text>
            </td>
            <td>
                  <xsl:value-of select="."/>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="//dc:source">
        <tr>
            <td class="header">
                <xsl:text>Source</xsl:text>
            </td>
            <td>
                  <xsl:value-of select="."/>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="//dc:rights">
        <tr>
            <td class="header">
                <xsl:text>Copyright</xsl:text>
            </td>
            <td>
                  <xsl:value-of select="."/>
            </td>
        </tr>
    </xsl:template>

    <!-- Display link to add to del.icio.us so this object can be bookmarked. -->
    <xsl:template name="delicious">
        <!-- template copied from http://bioguid.info/html.xsl -->
        <xsl:param name="title" select="string()"/>
        <xsl:variable name="uri" select="//@rdf:about"/>
        <tr>
            <td class="header">
                <img border="0" align="absmiddle">
                    <xsl:attribute name="src">
                        <xsl:text>delicious9x9.png</xsl:text>
                    </xsl:attribute>

                </img>
            </td>
            <td>
                <a>
                    <xsl:attribute name="href">
                        <xsl:text>http://del.icio.us/post</xsl:text>
                    </xsl:attribute>
                    <xsl:attribute name="onclick">
                        
<xsl:text>window.open('http://del.icio.us/post?v=4&amp;noui&amp;jump=close&amp;url='+encodeURIComponent('</xsl:text>
                        <xsl:value-of select="$uri"/>
                        <xsl:text>')+'&amp;title='+encodeURIComponent('</xsl:text>
                        <xsl:value-of select="$title"/>
                        <xsl:text>'), 'delicious','toolbar=no,width=700,height=400'); return false;</xsl:text>
                    </xsl:attribute>

                    <xsl:text> Bookmark this on del.icio.us</xsl:text>
                </a>
            </td>
        </tr>
    </xsl:template>

</xsl:stylesheet>
