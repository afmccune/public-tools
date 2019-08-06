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
        <xsl:copy>
            <xsl:apply-templates select="@*|node()"/>
        </xsl:copy>
    </xsl:template>
<!--
    <xsl:template match="TEI.2">
    	<xsl:copy/>
		<TEI.2><xsl:apply-templates /></TEI.2>
	</xsl:template>
	
	<xsl:template match="TEI.2/TEIheader">
		<TEIheader><xsl:apply-templates /></TEIheader>
	</xsl:template>
	<xsl:template match="TEI.2/TEIheader/fileDesc">
		<fileDesc><xsl:apply-templates /></fileDesc>
	</xsl:template>
	<xsl:template match="TEI.2/TEIheader/fileDesc/publicationStmt">
		<publicationStmt><xsl:apply-templates /></publicationStmt>
	</xsl:template>
	<xsl:template match="TEI.2/TEIheader/fileDesc/publicationStmt/date">
		<date><xsl:value-of select="."/></date>
	</xsl:template>
-->
	
    <xsl:template match="figure">
	  <xsl:choose>
	   <xsl:when test="ancestor::table">
        <img>
            <xsl:attribute name="src">img/illustrations/<xsl:value-of select="./@n"/>.png</xsl:attribute>
        </img>
	   </xsl:when>
	   <xsl:otherwise>
		<xsl:if test="./@n or ./head or ./figDesc">
					<xsl:if test="./@n">
					<xsl:choose>
						<xsl:when test="@n = ''"/>
						<xsl:when test="@rend = 'db'">
							<xsl:variable name="src">http://www.blakearchive.org/images/<xsl:value-of select="./@n"/>.300.jpg</xsl:variable>
								<img>
									<xsl:attribute name="src">
										<xsl:value-of select="$src"/>
									</xsl:attribute>
								</img>
						</xsl:when>
						<xsl:otherwise>
							<xsl:choose>
								<xsl:when test="contains(@n, 'bqscan')">
									<xsl:variable name="src">img/illustrations/<xsl:value-of select="./@n"/>.png</xsl:variable>
										<img>
											<xsl:attribute name="src">
												<xsl:value-of select="$src"/>
											</xsl:attribute>
										</img>
								</xsl:when>
								<xsl:when test="contains(@n, '.100') or contains(@n, '.bonus')">
									<xsl:variable name="src">img/illustrations/<xsl:value-of select="./@n"/>.jpg</xsl:variable>
										<img>
											<xsl:attribute name="src">
												<xsl:value-of select="$src"/>
											</xsl:attribute>
										</img>
								</xsl:when>
								<xsl:otherwise>
									<xsl:variable name="src">img/illustrations/<xsl:value-of select="./@n"/>.300.jpg</xsl:variable>
										<img>
											<xsl:attribute name="src">
												<xsl:value-of select="$src"/>
											</xsl:attribute>
										</img>
								</xsl:otherwise>
							</xsl:choose>
						</xsl:otherwise>
					</xsl:choose>
				</xsl:if>
		</xsl:if>
	   </xsl:otherwise>
	  </xsl:choose>
    </xsl:template>

	<!--
    <xsl:template match="@*|node()">
		<xsl:copy-of select="." />
    </xsl:template>
	-->
	<!--
    <xsl:template match="@*|node()" />
	-->
</xsl:stylesheet>