<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!--
	<xsl:template match="@*|node()">
		<xsl:copy>
			<xsl:apply-templates select="@*|node()"/>
		</xsl:copy>
	</xsl:template>
-->
<!--
    <xsl:template match="@*|node()">
        <xsl:copy>
            <xsl:apply-templates select="@*|node()"/>
        </xsl:copy>
    </xsl:template>
-->
    <xsl:template match="@*|node()">
      <xsl:if test="descendant-or-self::figure">
		  <xsl:copy>
			<xsl:apply-templates select="@*|node()"/>
		  </xsl:copy>
	  </xsl:if>
    </xsl:template>
    <xsl:template match="TEI.2">
        <xsl:apply-templates/>
    </xsl:template>
    <xsl:template match="tei.2">
        <xsl:apply-templates/>
    </xsl:template>
    <xsl:template match="div1">
        <xsl:choose>
            <xsl:when test="@id='cover'"/>
            <xsl:when test="@id != ''">
				<div>
					<xsl:attribute name="id">
                        <xsl:value-of select="@id"/>
                    </xsl:attribute>
					<xsl:apply-templates/>
				</div>
			</xsl:when>
            <xsl:otherwise>
                <xsl:apply-templates/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="div2">
        <xsl:apply-templates/>
    </xsl:template>
    <xsl:template match="div3">
        <xsl:choose>
            <xsl:when test="@type != ''">
				<div>
					<xsl:attribute name="class">
                        <xsl:value-of select="@type"/>
                    </xsl:attribute>
					<xsl:apply-templates/>
				</div>
			</xsl:when>
            <xsl:otherwise>
                <xsl:apply-templates/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="text()">
      <xsl:choose>
    	<xsl:when test="ancestor::figure">
    		<xsl:copy>
            	<xsl:apply-templates select="@*|node()"/>
        	</xsl:copy>
    	</xsl:when>
    	<xsl:otherwise/>
      </xsl:choose>
    </xsl:template>
    <xsl:template match="p|q|lb">
      <xsl:choose>
    	<xsl:when test="ancestor::figure">
    		<xsl:copy>
            	<xsl:apply-templates select="@*|node()"/>
        	</xsl:copy>
    	</xsl:when>
    	<xsl:when test="descendant::figure">
    		<xsl:copy>
            	<xsl:apply-templates select="@*|node()"/>
        	</xsl:copy>
    	</xsl:when>
    	<xsl:otherwise/>
      </xsl:choose>
    </xsl:template>
    <xsl:template match="hi">
      <xsl:choose>
    	<xsl:when test="ancestor::figure">
          <xsl:choose>
            <xsl:when test="@rend = 'b'">
				<xsl:choose>
					<xsl:when test="ancestor::title[@type='section'] or ancestor::title[@type='section-subtitle'] or ancestor::title[ancestor::table[@id='contents']]">
						<xsl:apply-templates/>
					</xsl:when>
					<xsl:otherwise>
						<strong>
							<xsl:apply-templates/>
						</strong>
					</xsl:otherwise>
				</xsl:choose>
            </xsl:when>
            <xsl:when test="@rend = 'i'">
				<xsl:choose>
					<xsl:when test="ancestor::title[@type='section'] or ancestor::title[@type='section-subtitle'] or ancestor::title[ancestor::table[@id='contents']]">
						<xsl:apply-templates/>
					</xsl:when>
					<xsl:otherwise>
						<em>
							<xsl:apply-templates/>
						</em>
					</xsl:otherwise>
				</xsl:choose>
            </xsl:when>
            <xsl:when test="@rend = 'u'">
				<xsl:choose>
					<xsl:when test="ancestor::title[@type='section'] or ancestor::title[@type='section-subtitle'] or ancestor::title[ancestor::table[@id='contents']]">
						<xsl:apply-templates/>
					</xsl:when>
					<xsl:otherwise>
						<span class="underline">
							<xsl:apply-templates/>
						</span>
					</xsl:otherwise>
				</xsl:choose>
            </xsl:when>
            <xsl:when test="@rend = 'uu'">
				<span class="double-underline">
					<xsl:apply-templates/>
				</span>
            </xsl:when>
            <xsl:when test="@rend = 'uthick'">
				<span class="thick-underline">
					<xsl:apply-templates/>
				</span>
            </xsl:when>
            <xsl:when test="@rend = 'overline'">
				<span class="overline">
					<xsl:apply-templates/>
				</span>
            </xsl:when>
            <xsl:when test="@rend = 's'">
                <sup>
                    <xsl:apply-templates/>
                </sup>
            </xsl:when>
            <xsl:when test="@rend = 'sub'">
                <sub>
                    <xsl:apply-templates/>
                </sub>
            </xsl:when>
            <xsl:when test="@rend = 'smallcaps'">
                <span class="small-caps">
                    <xsl:apply-templates/>
                </span>
            </xsl:when>
            <xsl:when test="@rend = 'strike'">
                <strike>
                    <xsl:apply-templates/>
                </strike>
            </xsl:when>
            <xsl:when test="@rend = 'gray'">
				<span class="gray">
					<xsl:apply-templates/>
				</span>
            </xsl:when>
            <xsl:otherwise>
                <xsl:apply-templates/>
            </xsl:otherwise>
        </xsl:choose>
      </xsl:when>
        <xsl:when test="descendant::figure">
    		<xsl:copy>
            	<xsl:apply-templates select="@*|node()"/>
        	</xsl:copy>
        </xsl:when>
        <xsl:otherwise/>
      </xsl:choose>
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
     <xsl:when test="./figTranscr"/>
     <xsl:otherwise>
	  <xsl:choose>
	   <xsl:when test="ancestor::table">
        <img>
            <xsl:attribute name="class">table-image</xsl:attribute>
            <xsl:attribute name="src">../../bq/img/illustrations/<xsl:value-of select="./@n"/>.png</xsl:attribute>
			<xsl:if test="./@height">
			 <xsl:attribute name="height"><xsl:value-of select="./@height"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="./@width">
			 <xsl:attribute name="width"><xsl:value-of select="./@width"/></xsl:attribute>
			</xsl:if>
            <xsl:attribute name="alt">
                <xsl:value-of select="./figTranscr"/>
            </xsl:attribute>
        </img>
	   </xsl:when>
	   <xsl:otherwise>
		<xsl:if test="./@n or ./head or ./figDesc">
			<div class="image">
				<div class="image-inner">
					<xsl:if test="./@n">
					<xsl:choose>
						<xsl:when test="@n = ''"/>
						<xsl:when test="@rend = 'db'">
							<xsl:variable name="src">http://www.blakearchive.org/blake/images/<xsl:value-of select="./@n"/>.300.jpg</xsl:variable>
							<a>
								<xsl:attribute name="class">image-expand</xsl:attribute>
								<xsl:attribute name="href">
									<xsl:value-of select="$src"/>
								</xsl:attribute>
								<img>
									<xsl:attribute name="src">
										<xsl:value-of select="$src"/>
									</xsl:attribute>
									<xsl:attribute name="alt">
										<xsl:value-of select="./figTranscr"/>
									</xsl:attribute>
									<xsl:if test="./@height">
									 <xsl:attribute name="height"><xsl:value-of select="./@height"/></xsl:attribute>
									</xsl:if>
									<xsl:if test="./@width">
									 <xsl:attribute name="width"><xsl:value-of select="./@width"/></xsl:attribute>
									</xsl:if>
								</img>
							</a>
						</xsl:when>
						<xsl:otherwise>
							<xsl:choose>
								<xsl:when test="contains(@n, 'bqscan')">
									<xsl:variable name="src">../../bq/img/illustrations/<xsl:value-of select="./@n"/>.png</xsl:variable>
									<a>
										<xsl:attribute name="class">image-expand</xsl:attribute>
										<xsl:attribute name="href">
											<xsl:value-of select="$src"/>
										</xsl:attribute>
										<img>
											<xsl:attribute name="src">
												<xsl:value-of select="$src"/>
											</xsl:attribute>
											<xsl:attribute name="alt">
												<xsl:value-of select="./figTranscr"/>
											</xsl:attribute>
											<xsl:if test="./@height">
											 <xsl:attribute name="height"><xsl:value-of select="./@height"/></xsl:attribute>
											</xsl:if>
											<xsl:if test="./@width">
											 <xsl:attribute name="width"><xsl:value-of select="./@width"/></xsl:attribute>
											</xsl:if>
										</img>
									</a>
								</xsl:when>
								<xsl:when test="contains(@n, '.100') or contains(@n, '.bonus')">
									<xsl:variable name="src">../../bq/img/illustrations/<xsl:value-of select="./@n"/>.jpg</xsl:variable>
									<a>
										<xsl:attribute name="class">image-expand</xsl:attribute>
										<xsl:attribute name="href">
											<xsl:value-of select="$src"/>
										</xsl:attribute>
										<img>
											<xsl:attribute name="src">
												<xsl:value-of select="$src"/>
											</xsl:attribute>
											<xsl:attribute name="alt">
												<xsl:value-of select="./figTranscr"/>
											</xsl:attribute>
											<xsl:if test="./@height">
											 <xsl:attribute name="height"><xsl:value-of select="./@height"/></xsl:attribute>
											</xsl:if>
											<xsl:if test="./@width">
											 <xsl:attribute name="width"><xsl:value-of select="./@width"/></xsl:attribute>
											</xsl:if>
										</img>
									</a>
								</xsl:when>
								<xsl:otherwise>
									<xsl:variable name="src">../../bq/img/illustrations/<xsl:value-of select="./@n"/>.300.jpg</xsl:variable>
									<a>
										<xsl:attribute name="class">image-expand</xsl:attribute>
										<xsl:attribute name="href">
											<xsl:value-of select="$src"/>
										</xsl:attribute>
										<img>
											<xsl:attribute name="src">
												<xsl:value-of select="$src"/>
											</xsl:attribute>
											<xsl:attribute name="alt">
												<xsl:value-of select="./figTranscr"/>
											</xsl:attribute>
											<xsl:if test="./@height">
											 <xsl:attribute name="height"><xsl:value-of select="./@height"/></xsl:attribute>
											</xsl:if>
											<xsl:if test="./@width">
											 <xsl:attribute name="width"><xsl:value-of select="./@width"/></xsl:attribute>
											</xsl:if>
										</img>
									</a>
								</xsl:otherwise>
							</xsl:choose>
						</xsl:otherwise>
					</xsl:choose>
				</xsl:if>
				<div class="caption">
					<!--<div style="color: #FF0000;"><xsl:apply-templates select="./figTranscr"/></div>-->
					<xsl:apply-templates/>
					<xsl:if test="@id">
						<!--and @rend = 'db'-->
						<br/>
						<a>
							<xsl:attribute name="href">http://www.blakearchive.org/exist/blake/archive/object.xq?objectid=<xsl:value-of select="@id"/>&amp;java=no</xsl:attribute>
							<xsl:attribute name="target">_blank</xsl:attribute>
							[View this object in the William Blake Archive]
						</a>
					</xsl:if>
				</div>
			</div>
			</div>
		</xsl:if>
	   </xsl:otherwise>
	  </xsl:choose>
	 </xsl:otherwise>
	</xsl:choose>
   </xsl:template>
   <xsl:template match="figDesc">
        <xsl:apply-templates/>
   </xsl:template>
   <xsl:template match="figTranscr"/>


    <xsl:template match="head">
        <xsl:choose>
			<xsl:when test="parent::figure">
				<span class="caption-head">
					<xsl:apply-templates/>
				</span> &#160; 
			</xsl:when>
			<xsl:otherwise>
                <xsl:apply-templates/>
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