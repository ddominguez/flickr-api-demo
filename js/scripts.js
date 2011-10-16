$(function() {
    $('div.foto a').click(function(event) {
        event.preventDefault();

        // build img popup html
        html = '<img src="'+this.href+'" />'

        // make sure the popup is empty first
        $('div.foto_popup').empty();

        // add/display the image
        $('div.foto_popup').append(html).css('display', 'block');
    });

    $('div.foto_popup img').live('click', function() {
        // close the popup and remove the content
        $(this).parent().css('display', 'none').empty();
    });
});