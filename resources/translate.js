$(function() {

    // Get locale menu btn
    var $localeMenuBtn = $('.localemenubtn:first').menubtn().data('menubtn').menu;
    
    // Get locale form element
    var $localeFormElm = $('input[name="locale"]');
    
    // Get translations download button
    $downloadBtn = $('.translations-download-button');
    
    // Init form with selected locale, if any
    if(Craft.getLocalStorage('BaseElementIndex.locale')) {
        $localeFormElm.val(Craft.getLocalStorage('BaseElementIndex.locale'));
        $downloadBtn.attr('href', $downloadBtn.attr('href').replace(/locale=.*$/, 'locale=' + Craft.getLocalStorage('BaseElementIndex.locale')));
    }
    
    // Change locale on select
    $localeMenuBtn.on('optionselect', function(ev) {
        $localeFormElm.val($(ev.selectedOption).data('locale'));
        $downloadBtn.attr('href', $downloadBtn.attr('href').replace(/locale=.*$/, 'locale=' + $(ev.selectedOption).data('locale')));
    });
    
    // Upload file on click
    $('.translations-upload-button').click(function() {
        $('input[name="translations-upload"]').click().change(function() {
            $(this).parent('form').submit();
        });
    });

});