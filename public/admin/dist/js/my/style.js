var mainTable = 'table.js-main-table';
var mainForm = 'form#admin-form';
var mainAction = 'div.js-admin-action';
var mainSearch = 'div.js-admin-search';
var mainReport = 'div.js-admin-report';
var searchForm = 'form#search-form';
var reportForm = 'form#report-form';
var checkboxItem = mainTable + ' input.checkItem';

/**
 * Checkbox all
 */
$(mainTable + ' input.checkAll').click(function (){
    var isCheck = $(this).is(':checked');
    if (isCheck == true) {
        $(checkboxItem).prop( "checked", true );
    }else{
        $(checkboxItem).prop( "checked", false );
    }
});


/**
 * edit
 */
$(mainAction + ' .js-edit').click(function () {
    var url = $(this).data('url');
    var httpQuery = $(this).data('http-query');
    httpQuery = (httpQuery) ? httpQuery : '';
    var items = $(checkboxItem);
    $.each(items, function( index, item ) {
        var isCheck = $(this).is(':checked');
        if (isCheck == true) {
            window.location.replace(url + '?id=' + $(this).val() + httpQuery);
            return false;
        }
    });
});

/**
 * copy
 */
$(mainAction + ' .js-copy').click(function () {
    var url = $(this).data('url');
    var httpQuery = $(this).data('http-query');
    httpQuery = (httpQuery) ? httpQuery : '';
    var items = $(checkboxItem);
    $.each(items, function( index, item ) {
        var isCheck = $(this).is(':checked');
        if (isCheck == true) {
            window.location.replace(url + '?id=' + $(this).val() + httpQuery);
            return false;
        }
    });
});

/**
 * multiple delete
 */
$(mainAction + ' .js-deletes').click(function () {
    var url = $(this).data('url');
    if(!confirm("Bạn có chắc chắn muốn xóa? Dữ liệu sẽ không thể phục hồi!!!")) {
        return false;
    }
    $(mainForm).attr('action', url);
    $(mainForm).submit();
});


/**
 * multiple post data
 */
$(mainAction + ' .js-posts').click(function () {
    var url = $(this).data('url');
    $(mainForm).attr('action', url);
    $(mainForm).submit();
});


/**
 * multiple post edit by action type
 */
$(mainAction + ' .js-post-edit').click(function () {
    var url = $(this).data('url');
    var actionType = $(this).data('action-type');
    $(mainForm).attr('action', url);
    $(mainForm + " input[name='action_type']").attr('value', actionType);
    $(mainForm).submit();
});

/**
 * multiple post copy by action type
 */
$(mainAction + ' .js-post-copy').click(function () {
    var url = $(this).data('url');
    var actionType = $(this).data('action-type');
    $(mainForm).attr('action', url);
    $(mainForm + " input[name='action_type']").attr('value', actionType);
    $(mainForm).submit();
});


/**
 * multiple post add by action type
 */
$(mainAction + ' .js-post-add').click(function () {
    var url = $(this).data('url');
    var actionType = $(this).data('action-type');
    $(mainForm).attr('action', url);
    $(mainForm + " input[name='action_type']").attr('value', actionType);
    $(mainForm).submit();
});

/**
 * search
 */
$(mainSearch + ' .js-search').click(function () {
    var url = $(this).data('url');
    $(searchForm).attr('action', url);
    $(searchForm).submit();
});

/**
 * report
 */
$(mainReport + ' .js-report').click(function () {
    var url = $(this).data('url');
    $(reportForm).attr('action', url);
    $(reportForm).submit();
});

/**
 * show
 */
$(mainAction + ' .js-show').click(function () {
    var url = $(this).data('url');
    var httpQuery = $(this).data('http-query');
    httpQuery = (httpQuery) ? httpQuery : '';
    var items = $(checkboxItem);
    $.each(items, function( index, item ) {
        var isCheck = $(this).is(':checked');
        if (isCheck == true) {
            window.location.replace(url + '?id=' + $(this).val() + httpQuery);
            return false;
        }
    });
});

/**
 * validate number unsigned
 */
function validateUnsigned(e) {
  var ev = e || window.event;
  var key = ev.keyCode || ev.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]/;
  if( !regex.test(key) ) {
    ev.returnValue = false;
    if(ev.preventDefault) ev.preventDefault();
  }
}

/**
 * copy url
 */
function copyUrl() {
  /* Get the text field */
  var copyText = document.getElementById("url").href;

   /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText);

  /* Alert the copied text */
  alert("Copied the url: " + copyText);
}

/**
 * copy slug
 */
function copySlug() {
  /* Get the text field */
  var copyText = document.getElementById("slug").innerHTML;

   /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText);

  /* Alert the copied text */
  alert("Copied the slug: " + copyText);
}

/**
 * copy code
 */
function copyCode() {
  /* Get the text field */
  var copyText = document.getElementById("code").innerHTML;

   /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText);

  /* Alert the copied text */
  alert("Copied the code: " + copyText);
}

/**
 * copy generated url
 */
function copyGeneratedUrl() {
  /* Get the text field */
  var copyText = $("#generated_url").val();
   /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText);
  /* Alert the copied text */
  alert("Copied the url: " + copyText);
}

/**
 * valid url
 */
function validURL(str) {
  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
    '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
  return !!pattern.test(str);
}