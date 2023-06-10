<section>
    <div class="row mt-2 d-flex flex-row justify-content-around" id="listado">
        <?php echo $listado;?>
    </div>
</section>
<script>
    function actualizarOferta(cod){
        window.location.href="./actualizarOferta/"+cod
    }
</script>