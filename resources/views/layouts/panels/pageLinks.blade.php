@if ($paginator->hasPages())

<ul class="pagination pagination-sm m-0 float-right">
    @if ($paginator->onFirstPage())
        <li wire:click="previousPage" class="page-item"><button class="page-link text-secondary" disabled>« Prev</button></li>
    @else
        <li wire:click="previousPage" class="page-item"><button class="page-link" >« Prev</button></li>
    @endif

    @if ($paginator->hasMorePages())
        <li wire:click="nextPage" class="page-item"><button class="page-link" >Next »</button></li>
    @else
        <li wire:click="nextPage" class="page-item"><button class="page-link text-secondary" disabled>Next »</button></li>
    @endif
</ul>

@endif
