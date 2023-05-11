<div class="container">
    <div class="col-10 offset-1 card border-primary">
        <div class="card-header">
            <div class="d-flex align-items-center">
            <div class="bg-primary p-1">
                <img src="vendor/images/logo.png">    
            </div>
            <div class="p-2 flex-fill pt-3 pl-5">
                <h2>Selamat Datang di Aplikasi Fleet Management</h2>
            </div> 
        </div>
        </div>
        <div class="card-body">            
            <div class="container">
                <div class="row">Dashboard</div>                              
            </div>
        </div>
        <div class="card-footer">
            <div class="col-md-12 mt5">{{ env('GREETING_DASHBOARD', '') }}</div>
        </div>
    </div>    
</div>
@push('breadcrumb')
    Dashboard
@endpush