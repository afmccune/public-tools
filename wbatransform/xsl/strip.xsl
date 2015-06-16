<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">


    <xsl:template match="bad">
       <xsl:element name="bad">
         <xsl:copy-of select="@*" />
         <xsl:apply-templates />
       </xsl:element>
    </xsl:template>

    <xsl:template match="desc">
       <xsl:element name="desc">
         <xsl:copy-of select="@*" />
         <xsl:apply-templates />
       </xsl:element>
    </xsl:template>
	
    <xsl:template match="desc//phystext">
         <xsl:apply-templates />
    </xsl:template>
<!--
    <xsl:template match="desc//phystext">
       <xsl:element name="phystext">
         <xsl:copy-of select="@*" />
         <xsl:apply-templates />
       </xsl:element>
    </xsl:template>
-->

    <xsl:template match="phystext//note"/>
    <xsl:template match="phystext//choice/reg"/>
    <xsl:template match="phystext//del"/>

    <xsl:template match="phystext//l">
       <xsl:apply-templates select="node()" /><xsl:text>
</xsl:text>
    </xsl:template>
	
	<xsl:template match="phystext//space">
       <xsl:apply-templates select="node()" /><xsl:text> </xsl:text>
    </xsl:template>

    <xsl:template match="phystext//*">
       <xsl:apply-templates select="node()" />
    </xsl:template>

	<xsl:template match="bad/@*"/>
	<xsl:template match="bad/header"/>
	<xsl:template match="objdesc/source"/>
	<xsl:template match="desc/*"/>
	<!--
	<xsl:template match="desc/objtitle"/>
	<xsl:template match="desc/physdesc"/>
	<xsl:template match="desc/illusdesc"/>
	-->
	
    <xsl:template match="*">
      <xsl:apply-templates select="@*|node()"/>
    </xsl:template>
</xsl:stylesheet>