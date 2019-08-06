<!-- 
	Image Archive
	Journal Archive: XSL Transform, single issue, full page
	William Shaw 1/19/2010
	Joe Ryan, Adam McCune, Michael Fox 2013-2015
-->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exist="http://exist.sourceforge.net/NS/exist" version="1.0">
    <xsl:template match="@*|node()">
        <xsl:apply-templates select="@*|node()"/>
    </xsl:template>
    <xsl:template match="/">
		<text>
			<xsl:apply-templates/>
		</text>
	</xsl:template>
</xsl:stylesheet>