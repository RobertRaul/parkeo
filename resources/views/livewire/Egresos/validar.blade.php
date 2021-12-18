@if ($caja_aperturada >0)
@include('livewire.egresos.listado')
@include('livewire.egresos.crear')
@else
<script>
    window.addEventListener("DOMContentLoaded", function() {
        Livewire.emit("egreso_mensaje");
    });
</script>
@endif
