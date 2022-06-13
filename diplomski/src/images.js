my_images = $('img.img-fluid');

my_images.each(function (index){
    let element = $(this)
    while (true){
        if (element.parent().prop("tagName") === 'P'){
            $(this)[0].addEventListener('error', function handleError() {
                // $(this).parent().parent().parent().parent()[0].innerHTML = '';
                // $(this).parent().parent().parent().parent().next()[0].innerHTML = '';
                element.parent().next().html('');
                element.parent().html('');
            });
            break;
        } else {
            element = element.parent()
        }

    }

});