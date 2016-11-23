<!-- William Blake Archive erdman.xsl Last Modified 2005-03-20 Aziza Technology Associates,LLC
This stylesheet transforms a section of the Erdman for display 
in the righthand frame of the frameset or as a note in a new window.
 -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xalan="http://xml.apache.org/xalan" xmlns:exist="http://exist.sourceforge.net/NS/exist" exclude-result-prefixes="xalan" version="1.0">
<!-- 2005-03 erdman.xsl  Transforms the 
Erdman XML (the results from erdman.xq). 
This is either displayed in the right hand frame or is displayed in a new window as a note  -->
    <xsl:include href="xmldb:exist:///db/blake/xsl/globals.xsl"/>
    <xsl:include href="xmldb:exist:///db/blake/xsl/includes.xsl"/>
    <xsl:param name="baseuri">
        <xsl:value-of select="$blakeroot"/>archive/erdman.xq</xsl:param>
    <xsl:param name="java">yes</xsl:param>
    <xsl:param name="querystring"/>
    <xsl:template match="/">
        <html>
            <xsl:call-template name="htmlhead"/>
            <body>
                <xsl:choose>
                    <xsl:when test="//document/@notepage ='yes'"/>
                    <xsl:otherwise>
                        <table width="100%" border="0">
                            <tr>
                                <td align="left">
                                    <xsl:choose>
                                        <xsl:when test="not(.//psibling)">
                                            <img border="0">
                                                <xsl:attribute name="src">/blake/dwicons/d_prev.gif</xsl:attribute>
                                            </img>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <a border="0" target="_top">
                                                <xsl:attribute name="href">
                                                    <xsl:value-of select="$blakeroot"/>archive/erdgen.xq?id=<xsl:value-of select=".//psibling/@id"/>
                                                </xsl:attribute>
                                                <img border="0">
                                                    <xsl:attribute name="src">/blake/dwicons/b_prev.gif</xsl:attribute>
                                                </img>
                                            </a>
                                        </xsl:otherwise>
                                    </xsl:choose>&#160;&#160;
<xsl:choose>
                                        <xsl:when test="not(.//fsibling)">
                                            <img border="0">
                                                <xsl:attribute name="src">
                                                    <xsl:value-of select="$blakeroot"/>dwicons/d_next.gif</xsl:attribute>
                                            </img>
                                        </xsl:when>
                                        <xsl:when test=".//fsibling">
                                            <a border="0" target="_top">
                                                <xsl:attribute name="href">
                                                    <xsl:value-of select="$blakeroot"/>archive/erdgen.xq?id=<xsl:value-of select=".//fsibling/@id"/>
                                                </xsl:attribute>
                                                <img border="0">
                                                    <xsl:attribute name="src">/blake/dwicons/b_next.gif</xsl:attribute>
                                                </img>
                                            </a>
                                        </xsl:when>
                                    </xsl:choose>&#160;&#160;
</td>
                                <td align="right">
                                    <form method="GET" target="_top">
                                        <xsl:attribute name="action">
                                            <xsl:value-of select="$blakeroot"/>archive/erdgen.xq</xsl:attribute>
                                        <input type="text" name="page" size="3"/>
                                        <input type="submit" value="Go To Page"/>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </xsl:otherwise>
                </xsl:choose>
                <hr/>
                <div>
                    <xsl:apply-templates select="//body"/>
                </div>
            </body>
        </html>
    </xsl:template>
    <xsl:template name="htmlheadder">
        <head>
            <title>
                <xsl:value-of select="//head/title"/>
            </title>
            <link>
                <xsl:attribute name="rel">stylesheet</xsl:attribute>
                <xsl:attribute name="type">text/css</xsl:attribute>
                <xsl:attribute name="href">/blake/style.css</xsl:attribute>
            </link>
            <script>
                <xsl:attribute name="src">/blake/functions.js</xsl:attribute>
            </script>
        </head>
    </xsl:template>
    <xsl:template match="body">
        <xsl:apply-templates/>
    </xsl:template>
    <xsl:template match="hi">
        <span>
            <xsl:call-template name="render"/>
            <xsl:apply-templates/>
        </span>
    </xsl:template>
    <xsl:template match="milestone">
[ <xsl:value-of select="./@unit"/>
        <xsl:text> </xsl:text>
        <xsl:value-of select="./@n"/> ]<xsl:apply-templates/>
    </xsl:template>
    <xsl:template match="div1|div2|div3|div4|div5">
        <div>
            <xsl:if test="@type='preliminaries'">
                <xsl:attribute name="align">center</xsl:attribute>
            </xsl:if>
            <xsl:if test="@rend">
                <xsl:attribute name="style">text-align:<xsl:value-of select="@rend"/>
                </xsl:attribute>
            </xsl:if>
            <xsl:apply-templates/>
        </div>
    </xsl:template>
    <xsl:template match="head">
        <xsl:variable name="divlevel">
            <xsl:value-of select="name(..)"/>
        </xsl:variable>
        <xsl:choose>
            <xsl:when test="$divlevel='list'">
                <dt>
                    <xsl:apply-templates/>
                </dt>
            </xsl:when>
            <xsl:when test="contains($divlevel, 'div')">
                <xsl:variable name="wrapelement">h<xsl:value-of select="translate($divlevel, 'div', '') + 1"/>
                </xsl:variable>
                <xsl:element name="{$wrapelement}">
                    <xsl:if test="@rend">
                        <xsl:call-template name="render"/>
                    </xsl:if>
                    <xsl:apply-templates/>
                </xsl:element>
            </xsl:when>
            <xsl:when test="$divlevel='lg'  or $divlevel='table'">
                <caption>
                    <xsl:if test="@rend">
                        <xsl:call-template name="render"/>
                    </xsl:if>
                    <xsl:apply-templates/>
                </caption>
            </xsl:when>
            <xsl:when test="$divlevel='list'">
                <h4>
                    <xsl:if test="@rend">
                        <xsl:call-template name="render"/>
                    </xsl:if>
                    <xsl:apply-templates/>
                </h4>
            </xsl:when>
            <xsl:otherwise>
                <xsl:element name="{$divlevel}">
                    <xsl:if test="@rend">
                        <xsl:call-template name="render"/>
                    </xsl:if>
                    <xsl:apply-templates/>
                </xsl:element>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="xptr">
        <div align="center">
            <img>
                <xsl:attribute name="src">/blake/erdman/images/<xsl:value-of select="@doc"/>.jpg</xsl:attribute>
            </img>
        </div>
    </xsl:template>
    <xsl:template match="figure">
        <xsl:choose>
            <xsl:when test="contains(@entity, 'inline')">
                <img>
                    <xsl:attribute name="src">/blake/erdman/images/<xsl:value-of select="@entity"/>.jpg</xsl:attribute>
                    <xsl:attribute name="alt">
                        <xsl:value-of select="figdesc"/>
                    </xsl:attribute>
                </img>
            </xsl:when>
            <xsl:otherwise>
                <div align="center">
                    <img>
                        <xsl:attribute name="src">/blake/erdman/images/<xsl:value-of select="@entity"/>.jpg</xsl:attribute>
                        <xsl:attribute name="alt">
                            <xsl:value-of select="figdesc"/>
                        </xsl:attribute>
                    </img>
                    <br/>
                    <xsl:apply-templates select="head|p"/>
                </div>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="lg">
        <p/>
        <table border="0" width="90%">
            <xsl:apply-templates/>
        </table>
        <p/>
    </xsl:template>
    <xsl:template match="table">
        <table>
            <xsl:attribute name="width">90%</xsl:attribute>
            <xsl:if test="@rend">
                <xsl:attribute name="align">
                    <xsl:value-of select="@rend"/>
                </xsl:attribute>
            </xsl:if>
            <xsl:apply-templates/>
        </table>
    </xsl:template>
    <xsl:template match="row">
        <tr>
            <xsl:apply-templates/>
        </tr>
    </xsl:template>
    <xsl:template match="cell">
        <td>
            <xsl:call-template name="render"/>
            <xsl:apply-templates/>
        </td>
    </xsl:template>
<!-- prints lines that are multiples of 5 -->
    <xsl:template match="l">
        <xsl:choose>
            <xsl:when test="name(..) !='div3'">
                <tr>
                    <td width="90%">
                        <xsl:apply-templates/>
                    </td>
                    <td width="10%">
                        <xsl:if test="(@n mod 5) = 0">
                            <xsl:value-of select="@n"/>
                        </xsl:if>
                    </td>
                </tr>
            </xsl:when>
            <xsl:otherwise>
                <xsl:apply-templates/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="note">
        <xsl:if test="@id">
            <a>
                <xsl:attribute name="name">
                    <xsl:value-of select="@id"/>
                </xsl:attribute>
            </a>
        </xsl:if>
        <div>
            <xsl:apply-templates/>
        </div>
    </xsl:template>
    <xsl:template match="ptr">
        <span>
            <sup>
                <a>
                    <xsl:attribute name="href">javascript:START('<xsl:value-of select="$blakeroot"/>archive/erdmanptr.xq?ptr=<xsl:value-of select="@target"/>', 'notewindow')</xsl:attribute>t</a>
            </sup>
        </span>
    </xsl:template>
    <xsl:template match="lb">
        <xsl:choose>
            <xsl:when test="@rend='hardrule'">
                <hr/>
            </xsl:when>
            <xsl:otherwise>
                <br/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="name|resp">
&#160;<xsl:apply-templates/>
    </xsl:template>
    <xsl:template match="p|closer|dateline|epigraph|opener">
        <xsl:choose>
            <xsl:when test="@rend">
                <p>
                    <xsl:call-template name="render"/>
                    <xsl:apply-templates/>
                </p>
            </xsl:when>
            <xsl:otherwise>
                <p>
                    <xsl:apply-templates/>
                </p>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="list">
        <dl>
            <xsl:apply-templates/>
        </dl>
    </xsl:template>
    <xsl:template match="item">
        <dd>
            <br/>
            <xsl:apply-templates/>
        </dd>
    </xsl:template>
    <xsl:template match="signed|salute|dateline">
        <xsl:choose>
            <xsl:when test="@rend">
                <div>
                    <xsl:call-template name="render"/>
                    <xsl:apply-templates/>
                </div>
            </xsl:when>
            <xsl:otherwise>
                <div>
                    <xsl:apply-templates/>
                </div>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="date|publisher|pubplace|respstmt|edition|editor|author">
        <div>
            <xsl:apply-templates/>
        </div>
    </xsl:template>
    <xsl:template match="monogr">
        <div style="text-align:center">
            <xsl:apply-templates/>
        </div>
    </xsl:template>
    <xsl:template match="pb">
        <a>
            <xsl:attribute name="name">
                <xsl:value-of select="@n"/>
            </xsl:attribute>
        </a>
        <xsl:choose>
            <xsl:when test=" name(..) ='lg'">
                <tr>
                    <td width="90%" style="text-align:center;font-size:smaller;color:#000080">[Begin Page <xsl:value-of select="@n"/>]</td>
                    <td width="10%"/>
                </tr>
            </xsl:when>
            <xsl:otherwise>
                <div style="text-align:center;font-size:smaller;color:#000080">[Begin Page <xsl:value-of select="@n"/>]</div>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="title">
        <xsl:choose>
            <xsl:when test="name(..) ='monogr'">
                <p>
                    <b>
                        <xsl:apply-templates/>
                    </b>
                </p>
            </xsl:when>
            <xsl:otherwise>
                <i>
                    <xsl:apply-templates/>
                </i>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

<!-- speeches -->
    <xsl:template match="sp">
        <p>
            <xsl:apply-templates/>
        </p>
    </xsl:template>
    <xsl:template match="speaker">
        <div style="margin-left:1em">
            <xsl:apply-templates/>
        </div>
    </xsl:template>
    <xsl:template match="stage">
        <xsl:choose>
            <xsl:when test="@rend">
                <p>
                    <xsl:attribute name="style">font-style:italic;text-align:<xsl:value-of select="@rend"/>
                    </xsl:attribute>
                    <xsl:apply-templates/>
                </p>
            </xsl:when>
            <xsl:otherwise>
                <p style="font-style:italic">
                    <xsl:apply-templates/>
                </p>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="tablebanner">
        <xsl:copy-of select="."/>
    </xsl:template>
    <xsl:template match="exist:match">
        <span style="color:red" id="match">
            <big>
                <b>
                    <xsl:apply-templates/>
                </b>
            </big>
        </span>
    </xsl:template>

<!-- uses rendering information to assign a style -->
    <xsl:template name="render">
        <xsl:choose>
            <xsl:when test="@rend = 'center' or @rend = 'right' or @rend='left'">
                <xsl:attribute name="style">text-align:<xsl:value-of select="@rend"/>
                </xsl:attribute>
            </xsl:when>
            <xsl:when test="@rend ='i'">
                <xsl:attribute name="style">font-style:italic</xsl:attribute>
            </xsl:when>
            <xsl:when test="@rend='small, italics' or @rend='smallItalics'">
                <xsl:attribute name="style">font: small italic</xsl:attribute>
            </xsl:when>
            <xsl:when test="@rend='small'">
                <xsl:attribute name="style">font-size:small</xsl:attribute>
            </xsl:when>
            <xsl:when test="@rend='sup'">
                <xsl:attribute name="style">vertical-align:super</xsl:attribute>
            </xsl:when>
            <xsl:when test="@rend='rowspan'">
                <xsl:attribute name="rowspan">3</xsl:attribute>
            </xsl:when>
            <xsl:otherwise/>
        </xsl:choose>
    </xsl:template>
<!-- constructs beginning of document -->
</xsl:stylesheet><!-- elements not processed 
add, del, foreign, 
date
milestones
quote,q
corr (1 instance)
sic (1 instance) 
supplied 
bibl (all formatting in sub elements)

in the teiheader
biblfull
filedesc
publicagtionstmt
notesstmt
seriesstmt
refsdecl

sourcedesc
titlestmt (in teiheader) and its children author,editor which occur no where else
availability
creation
profiledesc
projectdesc
encodingdesc


--><!-- Stylus Studio meta-information - (c)1998-2004. Sonic Software Corporation. All rights reserved.
<metaInformation>
<scenarios/><MapperMetaTag><MapperInfo srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/><MapperBlockPosition></MapperBlockPosition></MapperMetaTag>
</metaInformation>
-->