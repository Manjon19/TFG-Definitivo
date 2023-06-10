<section>
    <div class="row mt-2" id="listado">
        <?php echo $listado; ?>
    </div>
</section>
<script defer>
    function actualizarVP(dni){
        window.location.href = "./actualizarVP/"+dni;       
    }
</script>