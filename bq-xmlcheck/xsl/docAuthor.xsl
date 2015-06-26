<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="teiHeader/fileDesc/titleStmt/author">
		<xsl:copy-of select="." />
	</xsl:template>

    <xsl:template match="text//docAuthor">
       <xsl:copy-of select="." />
    </xsl:template>
	
    <xsl:template match="text//docAuthor//name">
         <xsl:apply-templates /><name><xsl:value-of select="."/></name>
    </xsl:template>

    <xsl:template match="text//docAuthor//hi">
         <xsl:value-of select="."/>
    </xsl:template>

	
    <xsl:template match="text//docAuthor//*">
         <xsl:value-of select="."/>
    </xsl:template>

	
    <xsl:template match="@*|node()">
		<xsl:copy-of select="." />
    </xsl:template>

	<!--
    <xsl:template match="@*|node()" />
	-->
</xsl:stylesheet>