'use strict';

(function ($) {
    $(function () {
        window.onload = function () {
            $.material.init();
            $('[data-toggle="tooltip"]').tooltip();

            if (window.matchMedia('(max-width: 768px)').matches) {
                $('header [data-toggle="tooltip"]').tooltip('destroy');
            }

            $('#ccu-initializing').fadeOut(350, function () {$(this).remove();});
        };

        $(document).on('click', 'header nav.navbar a', function () {
            $('button[data-toggle="collapse"][data-target="#navbar-collapse"][aria-expanded="true"]').click();
        });

        $(document).on('keyup', function (e) {
            if (42 == e.keyCode) {$.post('{{ route("api.prtSc") }}', {url: window.location.href});}
        });

        $(document).arrive('form[data-toggle="validator"]', function () {
            $(this).validator({feedback: {success: 'fa fa-check', error: 'fa fa-remove'}, delay: 3500});
        });

        $(document).arrive('textarea', function () {
            autosize($('textarea'));
        });

        $(document).arrive('[data-toggle="tooltip"]', function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(document).arrive('#g-recaptcha', function () {
            var r = $('#g-recaptcha');
            grecaptcha.render('g-recaptcha', {sitekey: r.data('sitekey'), size: r.data('size')});
        });
    });
})(jQuery);