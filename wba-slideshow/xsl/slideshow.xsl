<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
   <xsl:template match="@*|node()">
        <xsl:copy>
            <xsl:apply-templates select="@*|node()"/>
        </xsl:copy>
   </xsl:template>
   <xsl:template match="div1">
   		<bad>
   			<xsl:attribute name="type"><xsl:value-of select="./@type"/></xsl:attribute>
   			<xsl:apply-templates/>
   		</bad>
   </xsl:template>
   <xsl:template match="div2">
   		<xsl:apply-templates/>
   </xsl:template>
   <xsl:template match="list">
   		<xsl:apply-templates/>
   </xsl:template>
   <xsl:template match="list/head"/>
   <xsl:template match="item">
   		<xsl:apply-templates/>
   </xsl:template>
   <xsl:template match="figure">
   		<desc>
   			<xsl:attribute name="id"><xsl:value-of select="./@entity"/></xsl:attribute>
        	<xsl:apply-templates/>
   		</desc>
   </xsl:template>
    <xsl:template match="figure//head">
        <objtitle>
        	<title><xsl:apply-templates/></title>
        </objtitle>       
    </xsl:template>
   <xsl:template match="figure//figdesc">
   		<phystext>
   			<lg>
   				<l><xsl:apply-templates/></l>
   			</lg>
        </phystext>
   </xsl:template>
   <xsl:template match="hi[@rend='sup']">
   		<hi>
   			<xsl:attribute name="rend">superscript</xsl:attribute>
   			<xsl:apply-templates/>
   		</hi>
   </xsl:template>
   <xsl:template match="title[@level='m']">
   		<hi>
   			<xsl:attribute name="rend">i</xsl:attribute>
   			<xsl:apply-templates/>
   		</hi>
   </xsl:template>
	<!--
    <xsl:template match="@*|node()">
		<xsl:copy-of select="." />
    </xsl:template>
	-->
</xsl:stylesheet>