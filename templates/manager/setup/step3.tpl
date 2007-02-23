{**
 * step3.tpl
 *
 * Copyright (c) 2003-2005 The Public Knowledge Project
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Step 3 of conference setup.
 *
 * $Id$
 *}

{assign var="pageTitle" value="manager.setup.layout.title}
{include file="manager/setup/setupHeader.tpl"}

<form method="post" action="{url op="saveSetup" path="3"}">
{include file="common/formErrors.tpl"}

<h3>3.1 {translate key="manager.setup.layout.homepageHeader"}</h3>

<p>{translate key="manager.setup.layout.homepageHeader.description"}</p>

<h4>{translate key="manager.setup.layout.conferenceTitle"}</h4>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label"><input type="radio" name="homeHeaderTitleType" id="homeHeaderTitleType-0" value="0"{if not $homeHeaderTitleType} checked="checked"{/if} /> {fieldLabel name="homeHeaderTitleType-0" key="manager.setup.layout.useTextTitle"}</td>
		<td width="80%" class="value"><input type="text" name="homeHeaderTitle" value="{$homeHeaderTitle|escape}" size="40" maxlength="255" class="textField" /></td>
	</tr>
	<tr valign="top">
		<td width="20%" class="label"><input type="radio" name="homeHeaderTitleType" id="homeHeaderTitleType-1" value="1"{if $homeHeaderTitleType} checked="checked"{/if} /> {fieldLabel name="homeHeaderTitleType-1" key="manager.setup.layout.useImageTitle"}</td>
		<td width="80%" class="value"><input type="file" name="homeHeaderTitleImage" class="uploadField" /> <input type="submit" name="uploadHomeHeaderTitleImage" value="{translate key="common.upload"}" class="button" /></td>
	</tr>
</table>

{if $homeHeaderTitleImage}
{translate key="common.fileName"}: {$homeHeaderTitleImage.name} {$homeHeaderTitleImage.dateUploaded|date_format:$datetimeFormatShort} <input type="submit" name="deleteHomeHeaderTitleImage" value="{translate key="common.delete"}" class="button" />
<br />
<img src="{$publicConferenceFilesDir}/{$homeHeaderTitleImage.uploadName}" width="{$homeHeaderTitleImage.width}" height="{$homeHeaderTitleImage.height}" border="0" alt="" />
{/if}

<h4>{translate key="manager.setup.layout.conferenceLogo"}</h4>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label">{translate key="manager.setup.layout.useImageLogo"}</td>
		<td width="80%" class="value"><input type="file" name="homeHeaderLogoImage" class="uploadField" /> <input type="submit" name="uploadHomeHeaderLogoImage" value="{translate key="common.upload"}" class="button" /></td>
	</tr>
</table>

{if $homeHeaderLogoImage}
{translate key="common.fileName"}: {$homeHeaderLogoImage.name} {$homeHeaderLogoImage.dateUploaded|date_format:$datetimeFormatShort} <input type="submit" name="deleteHomeHeaderLogoImage" value="{translate key="common.delete"}" class="button" />
<br />
<img src="{$publicConferenceFilesDir}/{$homeHeaderLogoImage.uploadName}" width="{$homeHeaderLogoImage.width}" height="{$homeHeaderLogoImage.height}" border="0" alt="" />
{/if}

{if $alternateLocale1}
<br />
<h4>{translate key="manager.setup.layout.conferenceTitle"} ({$languageToggleLocales.$alternateLocale1})</h4>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label"><input type="radio" name="homeHeaderTitleTypeAlt1" id="homeHeaderTitleTypeAlt1-0" value="0"{if not $homeHeaderTitleTypeAlt1} checked="checked"{/if} /> {fieldLabel name="homeHeaderTitleTypeAlt1-0" key="manager.setup.layout.useTextTitle"}</td>
		<td width="80%" class="value"><input type="text" name="homeHeaderTitleAlt1" value="{$homeHeaderTitleAlt1|escape}" size="40" maxlength="255" class="textField" /></td>
	</tr>
	<tr valign="top">
		<td width="20%" class="label"><input type="radio" name="homeHeaderTitleTypeAlt1" id="homeHeaderTitleTypeAlt1-1" value="1"{if $homeHeaderTitleTypeAlt1} checked="checked"{/if} /> {fieldLabel name="homeHeaderTitleTypeAlt1-1" key="manager.setup.layout.useImageTitle"}</td>
		<td width="80%" class="value"><input type="file" name="homeHeaderTitleImageAlt1" class="uploadField" /> <input type="submit" name="uploadHomeHeaderTitleImageAlt1" value="{translate key="common.upload"}" class="button" /></td>
	</tr>
</table>

{if $homeHeaderTitleImageAlt1}
{translate key="common.fileName"}: {$homeHeaderTitleImageAlt1.name} {$homeHeaderTitleImageAlt1.dateUploaded|date_format:$datetimeFormatShort} <input type="submit" name="deleteHomeHeaderTitleImageAlt1" value="{translate key="common.delete"}" class="button" />
<br />
<img src="{$publicConferenceFilesDir}/{$homeHeaderTitleImageAlt1.uploadName}" width="{$homeHeaderTitleImageAlt1.width}" height="{$homeHeaderTitleImageAlt1.height}" border="0" alt="" />
{/if}

<h4>{translate key="manager.setup.layout.conferenceLogo"} ({$languageToggleLocales.$alternateLocale1})</h4>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label">{translate key="manager.setup.layout.useImageLogo"}</td>
		<td width="80%" class="value"><input type="file" name="homeHeaderLogoImageAlt1" class="uploadField" /> <input type="submit" name="uploadHomeHeaderLogoImageAlt1" value="{translate key="common.upload"}" class="button" /></td>
	</tr>
</table>

{if $homeHeaderLogoImageAlt1}
{translate key="common.fileName"}: {$homeHeaderLogoImageAlt1.name} {$homeHeaderLogoImageAlt1.dateUploaded|date_format:$datetimeFormatShort} <input type="submit" name="deletehHomeHeaderLogoImageAlt1" value="{translate key="common.delete"}" class="button" />
<br />
<img src="{$publicConferenceFilesDir}/{$homeHeaderLogoImageAlt1.uploadName}" width="{$homeHeaderLogoImageAlt1.width}" height="{$homeHeaderLogoImageAlt1.height}" border="0" alt="" />
{/if}
{/if}

{if $alternateLocale2}
<br />
<h4>{translate key="manager.setup.layout.conferenceTitle"} ({$languageToggleLocales.$alternateLocale2})</h4>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label"><input type="radio" name="homeHeaderTitleTypeAlt2" id="homeHeaderTitleTypeAlt2-0" value="0"{if not $homeHeaderTitleTypeAlt2} checked="checked"{/if} /> {fieldLabel name="homeHeaderTitleTypeAlt2-0" key="manager.setup.layout.useTextTitle"}</td>
		<td width="80%" class="value"><input type="text" name="homeHeaderTitleAlt2" value="{$homeHeaderTitleAlt2|escape}" size="40" maxlength="255" class="textField" /></td>
	</tr>
	<tr valign="top">
		<td width="20%" class="label"><input type="radio" name="homeHeaderTitleTypeAlt2" id="homeHeaderTitleTypeAlt2-1" value="1"{if $homeHeaderTitleTypeAlt2} checked="checked"{/if} /> {fieldLabel name="homeHeaderTitleTypeAlt2-1" key="manager.setup.layout.useImageTitle"}</td>
		<td width="80%" class="value"><input type="file" name="homeHeaderTitleImageAlt2" class="uploadField" /> <input type="submit" name="uploadHomeHeaderTitleImageAlt2" value="{translate key="common.upload"}" class="button" /></td>
	</tr>
</table>

{if $homeHeaderTitleImageAlt2}
{translate key="common.fileName"}: {$homeHeaderTitleImageAlt2.name} {$homeHeaderTitleImageAlt2.dateUploaded|date_format:$datetimeFormatShort} <input type="submit" name="deleteHomeHeaderTitleImageAlt2" value="{translate key="common.delete"}" class="button" />
<br />
<img src="{$publicConferenceFilesDir}/{$homeHeaderTitleImageAlt2.uploadName}" width="{$homeHeaderTitleImageAlt2.width}" height="{$homeHeaderTitleImageAlt2.height}" border="0" alt="" />
{/if}

<h4>{translate key="manager.setup.layout.conferenceLogo"} ({$languageToggleLocales.$alternateLocale2})</h4>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label">{translate key="manager.setup.layout.useImageLogo"}</td>
		<td width="80%" class="value"><input type="file" name="homeHeaderLogoImageAlt2" class="uploadField" /> <input type="submit" name="uploadHomeHeaderLogoImageAlt2" value="{translate key="common.upload"}" class="button" /></td>
	</tr>
</table>

{if $homeHeaderLogoImageAlt2}
{translate key="common.fileName"}: {$homeHeaderLogoImageAlt2.name} {$homeHeaderLogoImageAlt2.dateUploaded|date_format:$datetimeFormatShort} <input type="submit" name="deletehHomeHeaderLogoImageAlt2" value="{translate key="common.delete"}" class="button" />
<br />
<img src="{$publicConferenceFilesDir}/{$homeHeaderLogoImageAlt2.uploadName}" width="{$homeHeaderLogoImageAlt2.width}" height="{$homeHeaderLogoImageAlt2.height}" border="0" alt="" />
{/if}
{/if}

<div class="separator"></div>

<h3>3.2 {translate key="manager.setup.layout.conferencePageHeader"}</h3>

<p>{translate key="manager.setup.layout.conferencePageHeader.description"}</p>

<h4>{translate key="manager.setup.layout.conferenceLogo"}</h4>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label"><input type="radio" name="pageHeaderTitleType" id="pageHeaderTitleType-0" value="0"{if not $pageHeaderTitleType} checked="checked"{/if} /> {fieldLabel name="pageHeaderTitleType-0" key="manager.setup.layout.useTextTitle"}</td>
		<td width="80%" class="value"><input type="text" name="pageHeaderTitle" value="{$pageHeaderTitle|escape}" size="40" maxlength="255" class="textField" /></td>
	</tr>
	<tr valign="top">
		<td width="20%" class="label"><input type="radio" name="pageHeaderTitleType" id="pageHeaderTitleType-1" value="1"{if $pageHeaderTitleType} checked="checked"{/if} /> {fieldLabel name="pageHeaderTitleType-1" key="manager.setup.layout.useImageTitle"}</td>
		<td width="80%" class="value"><input type="file" name="pageHeaderTitleImage" class="uploadField" /> <input type="submit" name="uploadPageHeaderTitleImage" value="{translate key="common.upload"}" class="button" /></td>
	</tr>
</table>

{if $pageHeaderTitleImage}
{translate key="common.fileName"}: {$pageHeaderTitleImage.name} {$pageHeaderTitleImage.dateUploaded|date_format:$datetimeFormatShort} <input type="submit" name="deletePageHeaderTitleImage" value="{translate key="common.delete"}" class="button" />
<br />
<img src="{$publicConferenceFilesDir}/{$pageHeaderTitleImage.uploadName}" width="{$pageHeaderTitleImage.width}" height="{$pageHeaderTitleImage.height}" border="0" alt="" />
{/if}

<h4>{translate key="manager.setup.layout.conferenceLogo"}</h4>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label">{translate key="manager.setup.layout.useImageLogo"}</td>
		<td width="80%" class="value"><input type="file" name="pageHeaderLogoImage" class="uploadField" /> <input type="submit" name="uploadPageHeaderLogoImage" value="{translate key="common.upload"}" class="button" /></td>
	</tr>
</table>

{if $pageHeaderLogoImage}
{translate key="common.fileName"}: {$pageHeaderLogoImage.name} {$pageHeaderLogoImage.dateUploaded|date_format:$datetimeFormatShort} <input type="submit" name="deletePageHeaderLogoImage" value="{translate key="common.delete"}" class="button" />
<br />
<img src="{$publicConferenceFilesDir}/{$pageHeaderLogoImage.uploadName}" width="{$pageHeaderLogoImage.width}" height="{$pageHeaderLogoImage.height}" border="0" alt="" />
{/if}

{if $alternateLocale1}
<br />
<h4>{translate key="manager.setup.layout.conferenceTitle"} ({$languageToggleLocales.$alternateLocale1})</h4>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label"><input type="radio" name="pageHeaderTitleTypeAlt1" id="pageHeaderTitleTypeAlt1-0" value="0"{if not $pageHeaderTitleTypeAlt1} checked="checked"{/if} /> {fieldLabel name="pageHeaderTitleTypeAlt1-0" key="manager.setup.layout.useTextTitle"}</td>
		<td width="80%" class="value"><input type="text" name="pageHeaderTitleAlt1" value="{$pageHeaderTitleAlt1|escape}" size="40" maxlength="255" class="textField" /></td>
	</tr>
	<tr valign="top">
		<td width="20%" class="label"><input type="radio" name="pageHeaderTitleTypeAlt1" id="pageHeaderTitleTypeAlt1-1" value="1"{if $pageHeaderTitleTypeAlt1} checked="checked"{/if} /> {fieldLabel name="pageHeaderTitleTypeAlt1-1" key="manager.setup.layout.useImageTitle"}</td>
		<td width="80%" class="value"><input type="file" name="pageHeaderTitleImageAlt1" class="uploadField" /> <input type="submit" name="uploadPageHeaderTitleImageAlt1" value="{translate key="common.upload"}" class="button" /></td>
	</tr>
</table>

{if $pageHeaderTitleImageAlt1}
{translate key="common.fileName"}: {$pageHeaderTitleImageAlt1.name} {$pageHeaderTitleImageAlt1.dateUploaded|date_format:$datetimeFormatShort} <input type="submit" name="deletePageHeaderTitleImageAlt1" value="{translate key="common.delete"}" class="button" />
<br />
<img src="{$publicConferenceFilesDir}/{$pageHeaderTitleImageAlt1.uploadName}" width="{$pageHeaderTitleImageAlt1.width}" height="{$pageHeaderTitleImageAlt1.height}" border="0" alt="" />
{/if}

<h4>{translate key="manager.setup.layout.conferenceLogo"} ({$languageToggleLocales.$alternateLocale1})</h4>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label">{translate key="manager.setup.layout.useImageLogo"}</td>
		<td width="80%" class="value"><input type="file" name="pageHeaderLogoImageAlt1" class="uploadField" /> <input type="submit" name="uploadPageHeaderLogoImageAlt1" value="{translate key="common.upload"}" class="button" /></td>
	</tr>
</table>

{if $pageHeaderLogoImageAlt1}
{translate key="common.fileName"}: {$pageHeaderLogoImageAlt1.name} {$pageHeaderLogoImageAlt1.dateUploaded|date_format:$datetimeFormatShort} <input type="submit" name="deletePageHeaderLogoImageAlt1" value="{translate key="common.delete"}" class="button" />
<br />
<img src="{$publicConferenceFilesDir}/{$pageHeaderLogoImageAlt1.uploadName}" width="{$pageHeaderLogoImageAlt1.width}" height="{$pageHeaderLogoImageAlt1.height}" border="0" alt="" />
{/if}
{/if}

{if $alternateLocale2}
<br />
<h4>{translate key="manager.setup.layout.conferenceTitle"} ({$languageToggleLocales.$alternateLocale2})</h4>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label"><input type="radio" name="pageHeaderTitleTypeAlt2" id="pageHeaderTitleTypeAlt2-0" value="0"{if not $pageHeaderTitleTypeAlt2} checked="checked"{/if} /> {fieldLabel name="pageHeaderTitleTypeAlt2-0" key="manager.setup.layout.useTextTitle"}</td>
		<td width="80%" class="value"><input type="text" name="pageHeaderTitleAlt2" value="{$pageHeaderTitleAlt2|escape}" size="40" maxlength="255" class="textField" /></td>
	</tr>
	<tr valign="top">
		<td width="20%" class="label"><input type="radio" name="pageHeaderTitleTypeAlt2" id="pageHeaderTitleTypeAlt2-1" value="1"{if $pageHeaderTitleTypeAlt2} checked="checked"{/if} /> {fieldLabel name="pageHeaderTitleTypeAlt2-1" key="manager.setup.layout.useImageTitle"}</td>
		<td width="80%" class="value"><input type="file" name="pageHeaderTitleImageAlt2" class="uploadField" /> <input type="submit" name="uploadPageHeaderTitleImageAlt2" value="{translate key="common.upload"}" class="button" /></td>
	</tr>
</table>

{if $pageHeaderTitleImageAlt2}
{translate key="common.fileName"}: {$pageHeaderTitleImageAlt2.name} {$pageHeaderTitleImageAlt2.dateUploaded|date_format:$datetimeFormatShort} <input type="submit" name="deletePageHeaderTitleImageAlt2" value="{translate key="common.delete"}" class="button" />
<br />
<img src="{$publicConferenceFilesDir}/{$pageHeaderTitleImageAlt2.uploadName}" width="{$pageHeaderTitleImageAlt2.width}" height="{$pageHeaderTitleImageAlt2.height}" border="0" alt="" />
{/if}

<h4>{translate key="manager.setup.layout.conferenceLogo"} ({$languageToggleLocales.$alternateLocale2})</h4>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label">{translate key="manager.setup.layout.useImageLogo"}</td>
		<td width="80%" class="value"><input type="file" name="pageHeaderLogoImageAlt2" class="uploadField" /> <input type="submit" name="uploadPageHeaderLogoImageAlt2" value="{translate key="common.upload"}" class="button" /></td>
	</tr>
</table>

{if $pageHeaderLogoImageAlt2}
{translate key="common.fileName"}: {$pageHeaderLogoImageAlt2.name} {$pageHeaderLogoImageAlt2.dateUploaded|date_format:$datetimeFormatShort} <input type="submit" name="deletePageHeaderLogoImageAlt2" value="{translate key="common.delete"}" class="button" />
<br />
<img src="{$publicConferenceFilesDir}/{$pageHeaderLogoImageAlt2.uploadName}" width="{$pageHeaderLogoImageAlt2.width}" height="{$pageHeaderLogoImageAlt2.height}" border="0" alt="" />
{/if}
{/if}

<h4>{translate key="manager.setup.layout.alternateHeader"}</h4>

<p>{translate key="manager.setup.layout.alternateHeaderDescription"}</p>

<p><textarea name="conferencePageHeader" id="conferencePageHeader" rows="12" cols="60" class="textArea">{$conferencePageHeader|escape}</textarea></p>


<div class="separator"></div>


<h3>3.3 {translate key="manager.setup.layout.conferencePageFooter"}</h3>

<p>{translate key="manager.setup.layout.conferencePageFooterDescription"}</p>

<p><textarea name="conferencePageFooter" id="conferencePageFooter" rows="12" cols="60" class="textArea">{$conferencePageFooter|escape}</textarea></p>


<div class="separator"></div>

<h3>3.4 {translate key="manager.setup.layout.lists"}</h3>

<p>{translate key="manager.setup.layout.lists.description"}</p>

<table width="100%" class="data">
	<tr valign="top">
		<td width="20%" class="label">{translate key="manager.setup.layout.itemsPerPage"}</td>
		<td width="80%" class="value"><input type="text" size="3" name="itemsPerPage" class="textField" value="{$itemsPerPage|escape}" /></td>
	</tr>
	<tr valign="top">
		<td width="20%" class="label">{translate key="manager.setup.layout.numPageLinks"}</td>
		<td width="80%" class="value"><input type="text" size="3" name="numPageLinks" class="textField" value="{$numPageLinks|escape}" /></td>
	</tr>
</table>

<div class="separator"></div>

<p><input type="submit" value="{translate key="common.saveAndContinue"}" class="button defaultButton" /> <input type="button" value="{translate key="common.cancel"}" class="button" onclick="document.location.href='{url op="setup" escape=false}'" /></p>

<p><span class="formRequired">{translate key="common.requiredField"}</span></p>

</form>

{include file="common/footer.tpl"}
