<?php
function deletecomm(){?>
<!-- Javascript function for deleting comments from news page -->
<script language="javascript">
    function deletecommm(delcommmid)
    {
        if(confirm("Da li sigurno želite da obrišete ovaj komentar?")){
            window.location.href='deletecomm.php?delcommm_id=' +delcommmid+'';
            alert('Uspešno ste izbrisali komentar');
            return true;
        }
    }


</script>


<?php }?>


