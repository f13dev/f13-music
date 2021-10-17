(function($) {

    $(document).on('change', '.f13-lastfm-auto-submit', function() {
        $(this).submit();
    });

    $(document).on('submit', '.f13-lastfm-ajax', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var target = "#"+$(this).data('target');

        var url = $(this).data('href');

        $(target).css('opacity', '0.3');

        $.ajax({
            type : 'POST',
            url : url,
            data : formData,
            processData: false,
            contentType: false,
        }).done(function(data) {
            $(target).html(data);
            $(target).css('opacity', '1');
        }).error(function(data) {
            alert('An error occured.');
            $(target).css('opacity', '1');
        });
    });

})(jQuery);