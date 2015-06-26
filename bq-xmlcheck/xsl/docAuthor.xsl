<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!--
	<xsl:template match="@*|node()">
		<xsl:copy>
			<xsl:apply-templates select="@*|node()"/>
		</xsl:copy>
	</xsl:template>
-->
	<xsl:template match="@*|node()">
		<xsl:apply-templates select="@*|node()"/>
	</xsl:template>

    <xsl:template match="TEI.2">
		<TEI.2><xsl:apply-templates /></TEI.2>
	</xsl:template>
	
    <xsl:template match="teiHeader/fileDesc/titleStmt/author">
		<xsl:copy-of select="." />
	</xsl:template>

    <xsl:template match="teiHeader/fileDesc/titleStmt/author/@n">
		<xsl:copy-of select="." />
	</xsl:template>
	
	<xsl:template match="text//docAuthor">
		<docAuthor>
			<xsl:value-of select="."/>
			<name><xsl:value-of select="./name"/></name>
		</docAuthor>
    </xsl:template>
	
    <xsl:template match="text//docAuthor//name">
         <xsl:value-of select="."/>
    </xsl:template>

	<!--
    <xsl:template match="hi"/>
	-->
	<!--
    <xsl:template match="text//docAuthor//hi"/>
    <xsl:template match="text//docAuthor//name//hi"/>
	-->
	<!--
    <xsl:template match="text//docAuthor//*">
         <xsl:value-of select="."/>
    </xsl:template>
	-->
	<!--
    <xsl:template match="@*|node()">
		<xsl:copy-of select="." />
    </xsl:template>
	-->
	<!--
    <xsl:template match="@*|node()" />
	-->
</xsl:stylesheet>