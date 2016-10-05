jQuery(document).ready(function ($) {

    $('.btn-load-more-ajax a').on('click', function () {
        var btn = $(this),
            contentTarget = btn.parent().data('target'),
            appendTo = btn.parent().data('append-to'),
            loadMore = btn.parent().data('load-more');

        $.get(btn.attr('href'), function (data) {
            var nextBtn = $(data).find(loadMore).attr('href');

            $(appendTo).append($(data).find(contentTarget));

            if (nextBtn) {
                btn.attr('href', nextBtn);
            } else {
                btn.parent().hide();
            }
        });

        return false;
    });

});