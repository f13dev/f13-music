(function($) {

    $(document).on('change', '.f13-lastfm-auto-submit', function() {
        $(this).submit();
    });

    $(document).on('submit', '.f13-lastfm-ajax', function(e) {
        e.preventDefault();

        var string = '?';
        var target = $(this).data('target');
        var href = $(this).data('href');
        var action = $(this).data('action');

        $('#'+target).css('opacity', '0.3');
        $(this).find('select').each(function () {
            string = string + $(this).attr('name')+'='+encodeURIComponent($(this).val())+'&';
        });

        string = string + 'action='+action;

        $('#'+target).load(href+string, function() {
            $('#'+target).css('opacity', '1');
        });
    });

})(jQuery);