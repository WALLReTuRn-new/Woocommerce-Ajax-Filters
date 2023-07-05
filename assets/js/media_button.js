jQuery(function ($) {
    $(document).ready(function () {
        $('#insert-file-media').click(open_media_window);
    });

    function open_media_window() {
        if (this.window === undefined) {
            this.window = wp.media({
                title: 'Add File',
                library: {type: 'application/pdf'},
                multiple: false,
                button: {text: 'Atach to Email'}
            });

            var self = this;
            this.window.on('select', function () {
                var file = self.window.state().get('selection').first().toJSON();
                //console.log(file);
                console.log(file.filename);
                $('#name-file').html(file.filename);
                console.log(file.url);
                $('#url-file a').attr("href", file.url);
                // console.log('[attached file id="' + file.id + '"]');


                var url = file.url.slice(file.url.indexOf('uploads')+7);

                $('#nameoffile').val(file.filename);
                $('#urloffile').val(url);


            });
        }

        this.window.open();
        return false;
    }
});

