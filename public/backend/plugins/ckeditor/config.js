/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function(config) {
    config.filebrowserImageBrowseUrl = '/filemanager?type=Images',
    config.filebrowserImageUploadUrl = '/filemanager/upload?type=Images&_token=',
    config.filebrowserBrowseUrl = '/filemanager?type=Files',
    config.filebrowserUploadUrl = '/filemanager/upload?type=Files&_token='
};