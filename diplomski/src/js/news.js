function likenews(likenewsid)
{
    if(confirm("Da li želite da lajkujete ovu vest?")){
        window.location.href='likenews.php?likenews_id=' +likenewsid+'&csrfToken='+'<?=generateCsrfToken()?>'

        alert('Lajkovali ste ovu vest');
        return true;
    }
}

function deletenewsme(delnewsid)
{
    if(confirm("Da li sigurno želite da obrišete ovu vest?")){
        window.location.href='deletenews.php?delnews_id=' +delnewsid+'&csrfToken='+'<?=generateCsrfToken()?>';
        alert('Uspešno ste izbrisali vest');
        return true;
    }
}