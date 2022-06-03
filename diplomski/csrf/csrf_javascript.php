<?php
require_once 'csrf.php';
?>
<script>
    window.onload = function () {
        let forms = $('form');
        let links = $('a');
        forms.each(function (index) {
             // let formData = form.serializeArray();
            $(this).submit(function (event) {
                    let input = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", "csrfToken").val('<?=generateCsrfToken()?>');
                    $(this).append(input);
                    return true;
                });
        })
        links.each(function (index) {
            let href = $(this).attr("href")
            let url = new URL(href, window.location.origin);
            url.searchParams.append('csrfToken', '<?=generateCsrfToken()?>');
            $(this).attr("href", url.toString())
        })
    //    let link = $('a');
    //    link.href = link.href + '?csrfToken=<?//=generateCsrfToken()?>//'
    }
</script>
