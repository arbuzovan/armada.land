<?php

$i18n = Array(
	"header-content-sitetree"		=> "Site structure management",
	"header-content-edit"			=> "Edit page",
	"header-content-add"			=> "Add page",
	"header-content-config"			=> "Templates settings",

	// tickets
	"header-content-tickets"		=> "Tickets manager",
	"ticket-label-text"				=> "Text",
	"ticket-label-url"				=> "Page",
	"ticket-label-author"				=> "Author",
	"ticket-label-delete"				=> "Delete",
	// /tickets

	"label-template-name"			=> "Template name",
	"label-template-filename"		=> "File name",
	"label-template-is-default"		=> "Primary",
	"label-template-edit"			=> "Edit",
	"label-template-delete"			=> "Delete",

	"header-content-tpl_edit"		=> "Edit template",
	"group-template-props"			=> "Template properties",
	"label-template-used-pages"		=> "Using pages",
	'perms-content-content' => "View",
	'perms-content-sitetree' => "Change",
	'perms-content-tickets' => "Work with tickets",
	'perms-content-publish' => "Publish",

	'error-no-permissions'  => "You have no permissions to edit this element",
	"error-free-max-pages"	=> "Reached limit in 10 pages",
	'error-element-locked'	=>	"Element is locked by another user",
	'error-illegal-moving'	=> "Can not move this page",

	'eip-no-permissions'	=> "You are not allowed to edit this page",
	'eip-no-element'		=> "Page not found",
	'eip-no-object'			=> "Object not found",
	'eip-no-field'			=> "Field not found",
	'eip-nothing-found'		=> "No object or page found",

	'js-move-title'			=> "Are you sure, you want to move this page?",
	'js-move-shured'			=> "You are going to move this page. If you shure, press 'Move'.<br />Moving page may cause changes in site structure.<br />Be carefull: page url may change and it will become invisible for extra permanent links.",

	'js-move-do'			=> "Move",
	'js-cancel'			=> "Cancel",
	'js-mobile-app'		=> "Set up UMI.eManager",
	'js-mobile-info-content'	=>'You can set up free mobile application UMI.eManager for operational processing of orders via mobile devices.<p>You can download it from <a target="_blank" href="https://itunes.apple.com/ru/app/umi.emanager/id663311148">AppStore</a> (for devices based on iOS) and from <a target="_blank" href="https://play.google.com/store/apps/details?id=ru.umi_cms">GooglePlay</a> (for devices based on Android).</p>Read more about UMI.eManager advantages on <a target="_blank" href="http://www.umi-cms.ru/product/system/mobile_app/">www.umi-cms.ru</a>.',

    'js-add-field-header'          => 'Info',
    'js-add-field-part-one'        => 'Field will be added only to child data types with field group <b>',
    'js-add-field-part-two'        => '</b>. Data types without field group <b>',
    'js-add-field-part-three'      => '</b> will be omitted.',

	'js-del-title'			=> "Are you sure, you want to delete this page?",
	'js-del-short-title'	=> "Page deleting",
	'js-del-shured'			=> "You are going to delete page. If you shure, press 'Delete'.<br />After deleting page will appear in trash bin. Supervisor will be able restore it.",
	'js-del-do'			=> "Delete",

	'js-del-object-title'			=> "Are you sure, you want to delete this object?",
	'js-del-object-title-short'			=> "Object deleting",
	'js-del-object-sure' => '<p>You are going to delete this object. If you sure, press "Delete". After deleting it will be unrestorable.</p>',
	'js-del-object-shured'			=> "You are going to delete this object. If you sure, press 'Delete'.<br />After deleting it will be unrestorable.",

	'js-del-object-type-title'			=> "Are you sure, you want to delete this data type?",
	'js-del-object-type-shured'			=> "You are going to delete data type. If you sure, press 'Delete'.<br />Notice that all objects related to this type will be also deleted.<br /><b>After deleting it will be unrestorable.</b>",
	'js-del-object-type-title-short'			=> "Type removing",
	'js-del-object-type-sure' => '<p>Are you sure, you want to delete this data type? <br />Notice that all objects related to this type will be also deleted.<br /After deleting it will be unrestorable.</p>',

	'js-del-str'			=> "Delete page",

	'js-add-subpage'		=> "Add subpage",

	'js-edit-page'			=> "Edit page",

	'js-enable-page'			=> "Turn on page",
	'js-disable-page'			=> "Turn off page",
	'js-enable'			=> 'Turn on',
	'js-disable'			=> 'Turn off',

  'js-copy-all'					=> 'Copy page including all subpages',
	'js-copy-do'			=> "Copy",
	'js-copy-title'			=> "Choose copy mode?",
	'js-copy-shured'			=> "You are going to create copy of page with child pages.<br />If you want to copy only this page, press 'This page only' button.<br />If you want to copy both page and all subpages press 'Copy all'.",
	'js-copy-all-do'			=> "Copy all",
	'js-copy-page-do'			=> "This page only",
	'js-copy-str'			=> "Create copy",
	'js-copy-url'			=> "Copy URL",
	'js-choice-page'		=> "Choice page",
	'js-change-parent'		=> "Change parent",

  'js-vcopy-title'			=> "Choose virtual copy mode.",
	'js-vcopy-shured'			=> "You are going to create virtual copy of page with child pages.<br />If you want to copy only this page, press 'This page only' button.<br />If you want to copy both page and all subpages press 'Copy all'.",
	'js-vcopy-all-do'			=> "Copy all",
	'js-vcopy-page-do'			=> "This page only",
	'js-vcopy-str'			=> "Create virtual copy",

	'js-expand-big-title'			=> "There are lot of subpages, expand?",
	'js-expand-big-shured'			=> "You are going to expand item, with lots of subpages. This can take some time and make browser inactive for this time.",
	'js-expand-do'			=> "Expand",
	'js-edit-page'			=> "Edit page",

	'js-view-page'			=> "View",
	'notyfy-header'			=> "Page Expire Date",
	'field-expiration-date' => "Expiration date",
	'field-notification-date' => "Notification of expiration date",
	'field-publish-comments'	=> "Publish comments",
	'field-date-empty'			=>	'Never',
	'header-content-content_control'	=>	'Content control',


	'option-lock_pages'		=>	'Lock Pages',
	'option-lock_duration'	=>	'Lock duration (seconds)',
	'option-expiration_control'	=>	'Expiration control',
	'group-content_config'		=>	'Content control',

	'page_status_publish' => 'Published',
	'page_status_preunpublish' => 'Before unpublish',
	'page_status_unpublish' => 'Unpublished',
	'page_status_all'       => 'All',
	'page_filter'           => 'Filter',

	'js-content-alias-copy'	=> 'New alias',
	'js-content-alias-new'	=> 'Rename',
	'js-content-alias-change'	=> 'Change',


	'error-upload-broken'	=> 'File broken',
	'error-upload-error'	=> 'File upload error',
	'error-upload-directory-create' => 'Directory not created',
	'error-upload-directory-perms' => 'Directory must be writable',
	'error-users-swtich-activity-self' => 'Can not switch self-activity',
	'error-users-swtich-activity-sv' => 'Can not switch supervisor activity',
	'error-users-swtich-activity-guest' => 'Can not switch guest activity',

	'error-no-template-in-domain' => "Error: there is no template in this domain and lang. You can add in <a href=\"/%sadmin/content/config/\">Module config</a>",

	'ieditor-invalid-filename' => 'Invalid file name',
	'ieditor-uneditable-image' => 'This image can not be edited',
	'header-content-tree' => 'Content pages',
	'label-add-page' => 'Add page',
	'group-output_options' => 'Output options',
	'option-elements_count_per_page' => 'Number of elements per page'
);

?>
