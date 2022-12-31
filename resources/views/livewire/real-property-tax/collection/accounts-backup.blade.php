<div>
    <div class="row">
        <div class="col-lg-4">
            <div class="input-group mt-2 mx-2">
                <div class="input-group-prepend">
                    <button style="width:120px;" type="button" class="btn btn-primary">PIN :</button>
                </div>
                <input wire:model.debounce.500ms='input_pin' style="width:140px;" type="search" class="form-control"
                    placeholder="Type PIN number">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <a wire:click.prevent='search_pin()' href="#"><i class="fas fa-search"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="input-group mt-2 mb-2 mx-2">
                <div class="input-group-prepend">
                    <button style="width:120px;" type="button" class="btn btn-primary">TD / ARP NO. :</button>
                </div>
                <input wire:model.debounce.500ms='input_td' style="width:140px;" type="search" class="form-control"
                    placeholder="Type TD or ARP Number">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <a wire:click.prevent='search_td()' href="#"><i class="fas fa-search"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
        <div class="col-lg-3">
            <div class="input-group mt-2 mb-2 mx-2 ">
                <div class="input-group-prepend">
                    <button style="width:80px;" type="button" class="btn btn-primary">DATE : </button>
                </div>
                <input wire:model.debounce.500ms='input_date' style="width:120px;" type="date" class="form-control"
                    placeholder="Type TD or ARP Number">
                <div class="input-group-append mr-2">
                    <div class="input-group-text">
                        <a wire:click.prevent='date_set()' href="#"><i class="fas fa-check"></i>Set</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">

        @if ($input_pin == null)
        <div class="col-12">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-info-circle"></i> Search Record!</h5>
                Please type PIN, TD or ARP number into search field.
            </div>
        </div>
        @endif

        @if ($rpt_account_exist == true)
        <div class="col-sm-12 col-lg-3">
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
                        <strong><i class="fas fa-book mr-1"></i> KIND:</strong>
                        <p class="text-muted">
                            {{$ai_kind}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-book mr-1"></i> CLASS:</strong>
                        <p class="text-muted">
                            {{$ai_class}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-users mr-1"></i> OWNER(s):</strong>
                        <p class="text-muted">
                            {{$ai_owner}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> ADDRESS:</strong>
                        <p class="text-muted">
                            {{$ai_address}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-money-bill-wave mr-1"></i> ASSESSED VALUE:</strong>
                        <p class="text-muted">
                            @if ($ai_assessed_value)
                            @if (strpos($ai_assessed_value, ',') !== false)
                            {{'P '.$ai_assessed_value}}
                            @else
                            {{'P '.number_format($ai_assessed_value, 2, '.', ',')}}
                            @endif
                            @endif
                        </p>
                        <hr>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-sm-12 col-lg-9">
            <div class="row">
                {{-- Payment Record --}}
                <div class="col-12">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary p-1">
                                <h3 class="card-title">
                                    <i class="nav-icon fas fa-info-circle"></i>
                                    <i>PAYMENT RECORD(s)</i>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive table-sm p-0">
                                {{-- @if (count($payment_record)) --}}
                                <table class="table table-head-fixed table-bordered table-head-fixed">
                                    <tbody>
                                        <tr class="bg-secondary">
                                            <td class="p-0 text-center" rowspan="2">YEAR</td>
                                            <td class="p-0 text-center" colspan="3">TAX COLLECTED</td>
                                            <td class="p-0 text-center" colspan="3">PENALTY</td>
                                            <td class="p-0 text-center" style="width:170px" rowspan="2">TOTAL AMOUNT DUE
                                            </td>
                                        </tr>
                                        <tr class="bg-secondary">
                                            <td class="p-0 text-center">BASIC</td>
                                            <td class="p-0 text-center">SEF</td>
                                            <td class="p-0 text-center">TOTAL</td>
                                            <td class="p-0 text-center">BASIC</td>
                                            <td class="p-0 text-center">SEF</td>
                                            <td class="p-0 text-center">TOTAL</td>
                                        </tr>
                                        <?php $total_payment_records  = 0; ?>
                                        @forelse ($payment_records as $key => $item)
                                        <tr class="
                                    {{ ($item['pr_status'] == 1) ? 'bg-success':''}}
                                    {{ ($item['pr_status'] == 0) ? 'bg-gray':''}}">
                                            <td class="bg-info" style="width:170px">
                                                @if ($item['pr_year_from'] != $item['pr_year_to'])
                                                {{$item['pr_year_from'].'-'.$item['pr_year_to']}}
                                                @else
                                                {{ $item['pr_year_to']}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['tc_basic'], ',') !== false)
                                                {{'P '.$item['tc_basic']}}
                                                @else
                                                {{'P '.number_format($item['tc_basic'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['tc_sef'], ',') !== false)
                                                {{'P '.$item['tc_sef']}}
                                                @else
                                                {{'P '.number_format($item['tc_sef'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['tc_total'], ',') !== false)
                                                {{'P '.$item['tc_total']}}
                                                @else
                                                {{'P '.number_format($item['tc_total'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['td_basic'], ',') !== false)
                                                {{'P '.$item['td_basic']}}
                                                @else
                                                {{'P '.number_format($item['td_basic'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['td_sef'], ',') !== false)
                                                {{'P '.$item['td_sef']}}
                                                @else
                                                {{'P '.number_format($item['td_sef'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['td_total'], ',') !== false)
                                                {{'P '.$item['td_total']}}
                                                @else
                                                {{'P '.number_format($item['td_total'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                {{-- {{array_keys($item)}} --}}
                                                @if (strpos($item['pr_amount_due'], ',') !== false)
                                                {{'P '.$item['pr_amount_due']}}
                                                @else
                                                {{'P '.number_format($item['pr_amount_due'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                        </tr>
                                        <?php $total_payment_records = $total_payment_records + $item['pr_amount_due'] ?>
                                        @empty
                                        @endforelse
                                        <tr>
                                            <td colspan="7" class="bg-primary" style="width:170px">
                                                TOTAL
                                            </td>
                                            <td>
                                                @if (strpos($total_payment_records, ',') !== false)
                                                {{'P '.$total_payment_records}}
                                                @else
                                                {{'P '.number_format($total_payment_records, 2, '.', ',')}}
                                                @endif</td>
                                        </tr>
                                        {{-- <tr>
                                            <td class="bg-indigo" style="width:170px">
                                                GRAND-TOTAL
                                            </td>
                                            <td colspan="2"></td>
                                            <td class="bg-secondary" colspan="6"></td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

                {{-- Payment Balance --}}
                <div class="col-12">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary p-1">
                                <h3 class="card-title">
                                    <i class="nav-icon fas fa-info-circle"></i>
                                    <i>PAYMENT RECORD(s)</i>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive table-sm p-0">
                                {{-- @if (count($payment_record)) --}}
                                <table class="table table-head-fixed table-bordered table-head-fixed">
                                    <tbody>
                                        <tr class="bg-secondary">
                                            <td class="p-0 text-center" rowspan="2">DATE</td>
                                            <td class="p-0 text-center" rowspan="2">YEAR COVERED</td>
                                            <td class="p-0 text-center" colspan="4">QUARTER</td>
                                            <td class="p-0 text-center" colspan="3">AMOUNT</td>
                                            <td class="p-0 text-center" rowspan="2">REMARKS</td>

                                        </tr>
                                        <tr class="bg-primary">
                                            <td class="p-0 text-center">1st</td>
                                            <td class="p-0 text-center">2nd</td>
                                            <td class="p-0 text-center">3rd</td>
                                            <td class="p-0 text-center">4th</td>
                                            <td class="p-0 text-center">DUE</td>
                                            <td class="p-0 text-center">PAID</td>
                                            <td class="p-0 text-center">BALANCE</td>
                                        </tr>
                                        <?php $total_payment_records  = 0; ?>
                                        @forelse ($payment_records as $key => $item)
                                        <tr>
                                            <td>2022-02-12</td>
                                            <td class="">
                                                @if ($item['pr_year_from'] != $item['pr_year_to'])
                                                {{$item['pr_year_from'].'-'.$item['pr_year_to']}}
                                                @else
                                                {{ $item['pr_year_to']}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['tc_basic'], ',') !== false)
                                                {{'P '.$item['tc_basic']}}
                                                @else
                                                {{'P '.number_format($item['tc_basic'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['tc_sef'], ',') !== false)
                                                {{'P '.$item['tc_sef']}}
                                                @else
                                                {{'P '.number_format($item['tc_sef'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['tc_total'], ',') !== false)
                                                {{'P '.$item['tc_total']}}
                                                @else
                                                {{'P '.number_format($item['tc_total'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['td_basic'], ',') !== false)
                                                {{'P '.$item['td_basic']}}
                                                @else
                                                {{'P '.number_format($item['td_basic'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['td_sef'], ',') !== false)
                                                {{'P '.$item['td_sef']}}
                                                @else
                                                {{'P '.number_format($item['td_sef'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['td_sef'], ',') !== false)
                                                {{'P '.$item['td_sef']}}
                                                @else
                                                {{'P '.number_format($item['td_sef'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['td_sef'], ',') !== false)
                                                {{'P '.$item['td_sef']}}
                                                @else
                                                {{'P '.number_format($item['td_sef'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strpos($item['td_sef'], ',') !== false)
                                                {{'P '.$item['td_sef']}}
                                                @else
                                                {{'P '.number_format($item['td_sef'], 2, '.', ',')}}
                                                @endif
                                            </td>
                                        </tr>
                                        <?php $total_payment_records = $total_payment_records + $item['pr_amount_due'] ?>
                                        @empty
                                        @endforelse
                                        {{-- <tr>
                                            <td colspan="5" class="bg-primary" style="width:170px">
                                                TOTAL
                                            </td>
                                            <td>
                                                @if (strpos($total_payment_records, ',') !== false)
                                                {{'P '.$total_payment_records}}
                                                @else
                                                {{'P '.number_format($total_payment_records, 2, '.', ',')}}
                                                @endif</td>
                                        </tr> --}}
                                        {{-- <tr>
                                            <td class="bg-indigo" style="width:170px">
                                                GRAND-TOTAL
                                            </td>
                                            <td colspan="2"></td>
                                            <td class="bg-secondary" colspan="6"></td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

                {{-- Tax Due --}}
                @if ($payment_status == 'paid')
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-info-circle"></i> Payment Updated!</h5>
                        This RPT Account has no pending payment due.
                    </div>
                </div>
                @else
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary p-1">
                            <h3 class="card-title">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <i>TAX DUE</i>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive table-sm p-0">
                            {{-- @if (count($payment_record)) --}}
                            <table class="table table-head-fixed table-bordered table-head-fixed">
                                <tbody>
                                    <tr class="bg-secondary">
                                        <td class="p-0 text-center" rowspan="2">YEAR</td>
                                        <td class="p-0 text-center" colspan="3">TAX COLLECTED</td>
                                        <td class="p-0 text-center" colspan="3">PENALTY</td>
                                        <td class="p-0 text-center" style="width:170px" rowspan="2">TOTAL AMOUNT DUE
                                        </td>
                                        <td class="p-0 text-center" style="width:50px" rowspan="2"></td>
                                    </tr>
                                    <tr class="bg-secondary">
                                        <td class="p-0 text-center">BASIC</td>
                                        <td class="p-0 text-center">SEF</td>
                                        <td class="p-0 text-center">TOTAL</td>
                                        <td class="p-0 text-center">BASIC</td>
                                        <td class="p-0 text-center">SEF</td>
                                        <td class="p-0 text-center">TOTAL</td>
                                    </tr>
                                    @forelse ($payment_dues as $key => $item)
                                    <tr class="
                                    {{ ($item['status'] == 1) ? 'bg-success':''}}
                                    {{ ($item['status'] == 0) ? 'bg-gray':''}}">
                                        <td class="bg-info" style="width:170px">
                                            {{ $item['label']}}
                                        </td>
                                        <td>
                                            @if (strpos($item['tc_basic'], ',') !== false)
                                            {{'P '.$item['tc_basic']}}
                                            @else
                                            {{'P '.number_format($item['tc_basic'], 2, '.', ',')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (strpos($item['tc_sef'], ',') !== false)
                                            {{'P '.$item['tc_sef']}}
                                            @else
                                            {{'P '.number_format($item['tc_sef'], 2, '.', ',')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (strpos($item['tc_total'], ',') !== false)
                                            {{'P '.$item['tc_total']}}
                                            @else
                                            {{'P '.number_format($item['tc_total'], 2, '.', ',')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (strpos($item['td_basic'], ',') !== false)
                                            {{'P '.$item['td_basic']}}
                                            @else
                                            {{'P '.number_format($item['td_basic'], 2, '.', ',')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (strpos($item['td_sef'], ',') !== false)
                                            {{'P '.$item['td_sef']}}
                                            @else
                                            {{'P '.number_format($item['td_sef'], 2, '.', ',')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (strpos($item['td_total'], ',') !== false)
                                            {{'P '.$item['td_total']}}
                                            @else
                                            {{'P '.number_format($item['td_total'], 2, '.', ',')}}
                                            @endif
                                        </td>
                                        {{-- {{dump($item)}} --}}
                                        <td>
                                            {{-- {{array_keys($item)}} --}}
                                            @if (strpos($item['amount_due'], ',') !== false)
                                            {{'P '.$item['amount_due']}}
                                            @else
                                            {{'P '.number_format($item['amount_due'], 2, '.', ',')}}
                                            @endif
                                        </td>
                                        <td style="width:8px;" class="text-center p-2">

                                            @switch($item['status'])
                                            @case(1)
                                            <i class="nav-icon fas fa-check text-white"></i>
                                            @break

                                            @case(2)
                                            <button class="btn btn-sm btn-primary" data-toggle="dropdown">
                                                <i class="fas fa-bars"></i>
                                            </button>

                                            <div style=" border: transparent; width: 10px;" class="dropdown-menu p-0">
                                                <a wire:click.prevent="unlisted({{$item['count']}})" href="#"
                                                    class="dropdown-item text-danger">
                                                    <i class="fas fa-times"></i> Remove
                                                </a>
                                            </div>
                                            @break

                                            @default
                                            <i class="nav-icon fas fa-times text-white"></i>
                                            @endswitch
                                        </td>
                                    </tr>
                                    @empty
                                    @endforelse
                                    <tr>
                                        <td colspan="7" class="bg-primary" style="width:170px">
                                            TOTAL
                                        </td>
                                        <td>
                                            @if (strpos($amount_due, ',') !== false)
                                            {{'P '.$amount_due}}
                                            @else
                                            {{'P '.number_format($amount_due, 2, '.', ',')}}
                                            @endif</td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="bg-indigo" style="width:170px">
                                            GRAND-TOTAL
                                        </td>
                                        <td colspan="2"></td>
                                        <td class="bg-secondary" colspan="6"></td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                @endif

            </div>
        </div>

    </div>

    <hr>
    @if (is_null($payment_status))
    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <div class="card">
                <div class="card-header bg-primary p-1">
                    <h3 class="card-title">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <i>AMOUNT DUE</i>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    {{-- @if (count($payment_record)) --}}
                    <table class="table table-head-fixed table-bordered table-head-fixed">
                        <tbody style="font-size:20px">
                            <tr>
                                <td style="width:200px;" class="bg-primary">TELLER NAME :</td>
                                <td><input wire:model.debounce.500ms="payment_teller" style="border:none;font-size:20px"
                                        type="text" class="form-control" placeholder="Name of teller"></td>
                            </tr>
                            <tr>
                                <td style="width:200px;" class="bg-primary">DATE OF PAYMENT :</td>
                                <td><input wire:model.debounce.500ms="payment_date" style="border:none;font-size:20px"
                                        type="text" class="form-control" placeholder="Date of payment"></td>
                            </tr>
                            <tr>
                                <td style="width:200px;" class="bg-primary">O.R. NUMBER :</td>
                                <td><input wire:model.debounce.500ms="payment_or" style="border:none;font-size:20px"
                                        type="text" class="form-control" placeholder="OR Number"></td>
                            </tr>
                            <tr>
                                <td style="width:200px;" class="bg-primary">AMOUNT DUE :</td>
                                <td>
                                    @if (strpos($amount_due, ',') !== false)
                                    {{'P '.$amount_due}}
                                    @else
                                    {{'P '.number_format($amount_due, 2, '.', ',')}}
                                    @endif
                                    {{-- <input wire:model.debounce.500ms="payment_amount_due"
                                        style="border:none;font-size:20px" type="text" class="form-control"
                                        placeholder="0.00">
                                    --}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:200px;" class="bg-primary">DIRECTORY :</td>
                                <td>
                                    <textarea wire:model.debounce.500ms="payment_directory" class="form-control"
                                        style="border:none;font-size:20px" rows="2"
                                        placeholder="Enter directory..."></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:200px;" class="bg-primary">REMARKS :</td>
                                <td>
                                    <textarea wire:model.debounce.500ms="payment_remarks" class="form-control"
                                        style="border:none;font-size:20px" rows="2"
                                        placeholder="Enter remarks..."></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <div class="col-sm-12 col-lg-6">
            <div class="card">
                <div class="card-header bg-primary p-1">
                    <h3 class="card-title">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <i>QUARTERLY COMPUTATION</i>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    {{-- @if (count($payment_record)) --}}
                    <table class="table table-head-fixed table-bordered table-head-fixed">
                        <tbody style="font-size:20px">
                            <tr>
                                <td class="bg-primary">1ST QUATER :</td>
                                <td>
                                    @if (strpos($quarter1_value, ',') !== false)
                                    {{'P '.$quarter1_value}}
                                    @else
                                    {{'P '.number_format($quarter1_value, 2, '.', ',')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-primary">2ND QUATER :</td>
                                <td>
                                    @if (strpos($quarter2_value, ',') !== false)
                                    {{'P '.$quarter2_value}}
                                    @else
                                    {{'P '.number_format($quarter2_value, 2, '.', ',')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-primary">3RD QUATER :</td>
                                <td>
                                    @if (strpos($quarter3_value, ',') !== false)
                                    {{'P '.$quarter3_value}}
                                    @else
                                    {{'P '.number_format($quarter3_value, 2, '.', ',')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-primary">4TH QUATER :</td>
                                <td>
                                    @if (strpos($quarter4_value, ',') !== false)
                                    {{'P '.$quarter4_value}}
                                    @else
                                    {{'P '.number_format($quarter4_value, 2, '.', ',')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-primary">
                                    <select wire:model.debounce.500ms="payment_quarter"
                                        style="border:none;font-size:20px" class="custom-select">
                                        <option value="1">Quarter 1 (Jan.Mar.)</option>
                                        <option value="2">Quarter 2 (Apr.-Jun.)</option>
                                        <option value="3">Quarter 3 (Jul.-Sept.)</option>
                                        <option value="4">Quarter 4 (Oct.-Dec.)</option>
                                    </select>
                                </td>
                                <td>
                                    @if (strpos($quarter_total, ',') !== false)
                                    {{'P '.$quarter_total}}
                                    @else
                                    {{'P '.number_format($quarter_total, 2, '.', ',')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-primary">CASH :</td>
                                <td>
                                    <input wire:model.debounce.500ms="payment_cash" style="border:none;font-size:20px"
                                        type="text" class="form-control" placeholder="0.00">
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-primary">CHANGE :</td>
                                <td>
                                    @if (strpos($change_amount, ',') !== false)
                                    {{'P '.$change_amount}}
                                    @else
                                    {{'P '.number_format($change_amount, 2, '.', ',')}}
                                    @endif
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <button wire:click.prevent="save_payment()" type="button" class="btn btn-success float-right m-1">
                        <i class="nav-icon fas fa-money-bill-wave m-1"></i>Save Payment</button>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>


    </div>
    @endif
    @endif
</div>
