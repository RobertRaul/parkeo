<div>
    @if ($caja_aperturada >0)
    @include('livewire.egresos.listado')
    @else
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            Livewire.emit("egreso_mensaje");
        });
    </script>
    @endif

</div>

