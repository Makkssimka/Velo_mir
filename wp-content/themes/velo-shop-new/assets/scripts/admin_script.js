jQuery(document).ready(function($){
    let custom_uploader;
    let banner_ids = [];
    let banner_list = $('input[name="banner_list"]');
    let product_images = $('.banner_images');

    $('#select-image').click(function (e) {
        e.preventDefault();

        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Изображения для баннера',
            button: {
                text: 'Выбрать изображение'
            },
            multiple: true
        });

        custom_uploader.on('select', function() {
            let attachment = custom_uploader.state().get('selection').toJSON();
            attachment.forEach(function (element) {
                let elem = '<li class="image" data-attachment_id="'+element.id+'">';
                elem += '<img src="'+element.sizes.thumbnail.url+'">';
                elem += '<div class="close-icon"><i class="las la-times"></i></div>';
                elem += '</li>';
                product_images.append(elem);

                banner_ids = JSON.parse(banner_list.val());
                banner_ids.push(element.id);
                banner_list.val(JSON.stringify(banner_ids));
            });

        });

        custom_uploader.open();
    });

    $('.close-icon').on('click', function (e) {
        e.preventDefault();
        let parent = $(this).parents('.image');

        banner_ids = JSON.parse(banner_list.val());
        banner_ids = banner_ids.filter(function (item) {
            return item != parent.data('attachment_id');
        });
        banner_list.val(JSON.stringify(banner_ids));

        parent.remove();
    })
});