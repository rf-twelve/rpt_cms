<div>
    {{-- <div class="col-sm-12 col-lg-3"> --}}
        <div class="card">
            <div class="card-header bg-primary p-1">
                <h3 class="card-title">
                    <i class="nav-icon fas fa-info-circle"></i>
                    <i>ACCOUNT INFORMATION</i>
                </h3>
            </div>

            <!-- /.card-header -->
            <div class="card-body table-responsive p-2" style="height: 500px;">

                <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> PIN:</strong>
                    <p class="text-muted">
                        {{$rpt_pin}}
                    </p>
                    <hr>
                    <strong><i class="fas fa-book mr-1"></i> TD No.:</strong>
                    <p class="text-muted">
                        {{$rpt_td_no}}
                    </p>
                    <hr>
                    <strong><i class="fas fa-users mr-1"></i> KIND:</strong>
                    <p class="text-muted">
                        {{$rpt_kind}}
                    </p>
                    <hr>
                    <strong><i class="fas fa-users mr-1"></i> OWNER(s):</strong>
                    <p class="text-muted">
                        {{$ro_name}}
                    </p>
                    <hr>
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> ADDRESS:</strong>
                    <p class="text-muted">
                        {{$ro_address}}
                    </p>
                    <hr>
                    <strong><i class="fas fa-info-circle mr-1"></i> LAST PAYMENT:</strong>
                    <p class="text-muted">
                        {{$rtdp_payment_covered_year}}
                    </p>
                    <hr>
                </div>

            </div>
            <!-- /.card-body -->
        </div>
    {{-- </div> --}}
</div>
