xquery version "1.0";
declare namespace xi="http://www.w3.org/2001/XInclude";
declare namespace request="http://exist-db.org/xquery/request";
declare namespace util="http://exist-db.org/xquery/util";
declare namespace transform="http://exist-db.org/xquery/transform";
declare namespace blake="http://www.blakearchive.org";
import module namespace g="http://www.blakearchive.org/xquerymods" 
    at "functions.xqm";

declare option exist:serialize "method=xhtml media-type=text/html";

declare function blake:erdman( )
as node( )*
{
let $divid := if(request:request-parameter("id", ()))
	then request:request-parameter("id", ())
	else "f1"
	let $query := if(request:request-parameter("query", ()))
	then request:request-parameter("query", ())
	else "f1"
	let $term := if(request:request-parameter("term", ())) then request:request-parameter("term", ()) else "!NoTermSelected!"
let $div := if(request:request-parameter("query", ()))
          then collection("/db/blake/erdman")//*[@id =$divid][. |= $query]
		  else collection("/db/blake/erdman")//*[@id = $divid]
let $id := $div/@id

return

<document>
<head><title>Erdman - {$div/head}</title>
<script language="javascript">
<![CDATA[
  $(document).ready(function(){
 $('div').highlight(']]>{$term}<![CDATA[');
});
]]>
</script>
</head>

<body>

{if($div/preceding-sibling::*[1][head]/@id) then <psibling>{$div/preceding-sibling::*[1][head]/@id}</psibling> else if ($div/parent::node()[head][@id]/@id) then <psibling>{$div/parent::node()[head][@id]/@id}</psibling> else ""}
{if($div/following-sibling::*[1][head]/@id) then <fsibling>{$div/following-sibling::*[1][head]/@id}</fsibling> else if ($div/parent::node()/following-sibling::*[head][@id][1]/@id) then <fsibling>{$div/parent::node()/following-sibling::*[head][@id][1]/@id}</fsibling> else ""}

{if(name($div) = 'div1' and $div/p)
then <div1>{$div/*[name() != 'div2']}</div1>
else $div
}
</body></document>
};

transform:transform( blake:erdman( ), doc( "/db/blake/xsl/erdman.xsl" ), ( ) )

(: Copyright April 2005 The Blake Archive http://www.blakearchive.org
Developed by Aziza Technology Associates, LLC http://www.azizatech.com
Last Modified April 12, 2005
:)

(: Stylus Studio meta-information - (c)1998-2004. Sonic Software Corporation. All rights reserved.
<metaInformation>
<scenarios/><MapperMetaTag><MapperInfo srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/><MapperBlockPosition></MapperBlockPosition></MapperMetaTag>
</metaInformation>
:)
