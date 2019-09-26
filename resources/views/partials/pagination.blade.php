<div class="data_paginate paging_bootstrap paginations_custom" style="text-align: center">

    {{ $paginator->appends(request()->all())->links() }}

</div>