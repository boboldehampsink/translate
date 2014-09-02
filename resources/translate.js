$(function() {

    // Get locale menu btn
    var $localeMenuBtn = $('.localemenubtn:first').menubtn().data('menubtn').menu;
    
    // Get locale form element
    var $localeFormElm = $('input[name="locale"]');
    
    // Init form with selected locale
    $localeFormElm.val(Craft.getLocalStorage('BaseElementIndex.locale'));
    
    // Change locale on select
    $localeMenuBtn.on('optionselect', function(ev) {
        $localeFormElm.val($(ev.selectedOption).data('locale'));
    });
    
    // Upload file on click
    $('.translations-upload-button').click(function() {
        $('input[name="translations-upload"]').click().change(function() {
            $(this).parent('form').submit();
        });
    });

});