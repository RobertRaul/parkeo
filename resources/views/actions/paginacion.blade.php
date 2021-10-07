<div>
    <p>
        Mostrando registros del {{ $data->firstItem() }} al {{ $data->lastItem() }} de un total de {{ $data->total() }} registros
    </p>
    <p>
        {{ $data->links() }}
    </p>
</div>  