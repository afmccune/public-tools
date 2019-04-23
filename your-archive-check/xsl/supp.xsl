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
	
    <xsl:template match="desc//supplemental">
         <xsl:value-of select="@objectid"/>
    </xsl:template>

	<xsl:template match="desc//*" />
	
	<!--
    <xsl:template match="@*|node()" />
	-->
</xsl:stylesheet>