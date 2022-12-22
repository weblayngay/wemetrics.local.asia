/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
    config.entities = false;
    config.filebrowserBrowseUrl = '/public/admin/vendors/ckfinder/ckfinder.html',
    config.filebrowserUploadUrl = '/public/admin/vendors/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
    config.entities = false;
    config.allowedContent = true;
};
