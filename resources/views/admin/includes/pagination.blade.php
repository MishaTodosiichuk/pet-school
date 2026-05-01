<div class="row align-items-center px-3 py-2 mt-2">
    <div class="col-sm-12 col-md-5">
        <div class="dataTables_info">
            Показано від {{ $items->firstItem() }} до {{ $items->lastItem() }} з {{ $items->total() }}
        </div>
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate d-flex justify-content-end">
            {{ $items->links() }}
        </div>
    </div>
</div>
