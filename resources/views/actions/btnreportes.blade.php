@can($reports)
<button type="button" class="btn btn-success" wire:click='report_xls'>
    <i class="fas fa-file-excel">
    </i>
</button>
<button type="button" class="btn btn-danger" wire:click="report_pdf">
    <i class="fas fa-file-pdf"></i>
</button>
@endcan