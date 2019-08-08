<!-- 
	XSL Transform, single issue, full page
	William Shaw 1/19/2010
	Joe Ryan, Adam McCune, Michael Fox 2013-2017
-->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exist="http://exist.sourceforge.net/NS/exist" version="1.0">
    <xsl:output method="html" doctype-system="about:legacy-compat"/>
    <xsl:variable name="idno"><xsl:value-of select="//div[@id='idno']"/></xsl:variable>
    <xsl:template match="div[@id='idno']"/>
	<xsl:variable name="lowercase" select="'abcdefghijklmnopqrstuvwxyzàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿžšœ'" />
	<xsl:variable name="uppercase" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞŸŽŠŒ'" />
    <xsl:template match="@*|node()">
        <xsl:copy>
            <xsl:apply-templates select="@*|node()"/>
        </xsl:copy>
    </xsl:template>
    <xsl:template match="/">
		<xsl:apply-templates/>
    </xsl:template>
	<xsl:template name="newKey">
		<xsl:param name="oldKey" />
        <xsl:variable name="oldKeyLength"><xsl:value-of select="string-length($oldKey)"/></xsl:variable>
		<xsl:variable name="idx"><xsl:value-of select="$oldKeyLength - 2"/></xsl:variable>
		<xsl:variable name="keySplit"><xsl:value-of select="translate(substring($oldKey,0,$idx), $uppercase, $lowercase)"/></xsl:variable>
		<xsl:variable name="keyVol"><xsl:value-of select="substring($oldKey,$idx,2)"/></xsl:variable>
		<xsl:variable name="keyIss"><xsl:value-of select="substring($oldKey,$oldKeyLength,1)"/></xsl:variable>
		<xsl:value-of select="$keyVol"/>.<xsl:value-of select="$keyIss"/>.<xsl:value-of select="$keySplit"/>
    </xsl:template>
    <xsl:template match="@src[parent::img]">
        <xsl:variable name="oldSrc"><xsl:value-of select="."/></xsl:variable>
		<xsl:attribute name="src">https://upload.wikimedia.org/wikipedia/commons/<xsl:value-of select="$oldSrc"/></xsl:attribute>
	</xsl:template>
	<xsl:template match="div[@id='custFooter']"/>
	<xsl:template match="corr[@type='emend']">
        <xsl:call-template name="emend"/>
    </xsl:template>
    <xsl:template match="gap[@type='emend']">
        <xsl:call-template name="emend"/>
    </xsl:template>
    <xsl:template match="supplied[@type='emend']">
        <xsl:call-template name="emend"/>
    </xsl:template>
    <xsl:template name="emend">
        <span class="emend">
            <xsl:apply-templates/>
        </span><xsl:choose>
            <xsl:when test="@rend = 'plain'"/>
            <xsl:otherwise><a title="Emendation" class="emend-link" href="Emend#{$idno}"><sup>[e]</sup></a></xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="style"/>
</xsl:stylesheet>