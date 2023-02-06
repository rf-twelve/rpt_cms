<div x-data="{}">
    <div class="row">
        <div class="col-lg-4">
            <div class="mx-2 mt-2 input-group">
                <div class="input-group-prepend">
                    <select wire:model="search_option" class="btn btn-primary">
                        <option value="rpt_pin" selected>PIN</option>
                        <option value="rpt_td_no">TD Number</option>
                        <option value="rpt_arp_no">ARP Number</option>
                    </select>
                </div>
                <input wire:model='search_input' style="width:140px;" type="search" class="form-control"
                    placeholder="Type keywords...">
                <div class="input-group-append">
                    <button wire:click='searchRecord()' type="button" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
        </div>
        <div class="col-lg-3">
            <div class="mx-2 mt-2 mb-2 input-group ">
                <div class="input-group-prepend">
                    <button style="width:80px;" type="button" class="btn btn-primary">DATE : </button>
                </div>
                <input wire:model='input_date' style="width:120px;" type="date" class="form-control"
                    placeholder="Type TD or ARP Number">
                <div class="mr-2 input-group-append">
                    <div class="input-group-text">
                        <a wire:click.prevent='setDate()' href="#"><i class="fas fa-check"></i>Set</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        @if ($viewSearchList)
       {{-- search list --}}
        @if(!is_null($foundRecords) || !empty($foundRecords))
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="p-0 card-body table-responsive">
                    <div class="card-header ui-sortable-handle">
                        <div class="card-tools">
                        <ul class="pagination pagination-sm">
                        <li class="page-item"><strong><i><span class="badge bg-primary">N</span> New</i></strong></li>
                        <li class="page-item">&nbsp|&nbsp</li>
                        <li class="page-item"><strong><i><span class="badge bg-warning">D</span> Duplicate</i></strong></li>
                        <li class="page-item">&nbsp|&nbsp</li>
                        <li class="page-item"><strong><i><span class="badge bg-success">V</span> Verified</i></strong></li>
                        <li class="page-item">&nbsp|&nbsp</li>
                        <li class="page-item"><strong><i><span class="badge bg-danger">U</span> Unverified</i></strong></li>
                        </ul>
                        </div>
                    </div>

                    <table class="table table-hover table-bordered table-sm">
                        <thead>
                            <tr class="text-center text-nowrap bg-primary">
                                <th>PIN</th>
                                <th>TD/ARP No.</th>
                                <th>PROPERTY OWNER</th>
                                <th>ADDRESS OF PROPERTY</th>
                                <th>KIND</th>
                                <th>CLASS</th>
                                <th>PAYMENT COVERED</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-nowrap">
                            @forelse ($foundRecords as $item)
                            <tr>
                                <td>{{ $item->rpt_pin }}</td>
                                <td>{{ $item->rpt_td_no }}</td>
                                <td>
                                    @if (strlen($item->ro_name) > 20)
                                    {{ substr($item->ro_name, 0, 20). " ... "}}
                                    @else
                                    {{ $item->ro_name }}
                                    @endif
                                </td>
                                <td>
                                    @if (strlen($item->ro_address) > 20)
                                    {{ substr($item->ro_address, 0, 20). " ... "}}
                                    @else
                                    {{ $item->ro_address }}
                                    @endif
                                </td>
                                <td>{{ $item->rpt_kind }}</td>
                                <td>{{ $item->rpt_class }}</td>
                                <td>{{ $item->rtdp_payment_covered_year }}</td>
                                <td>
                                    @if ($item->rtdp_status == 0)
                                    <span class="right badge badge-danger">U</span>
                                    @else
                                    <span class="right badge badge-success">V</span>
                                    @endif
                                <td>
                                    <button wire:click='verify_record({{$item->id}})' type="button" class="btn btn-outline-primary btn-block btn-sm"><i class="fa fa-check"></i> Select</button>
                                </td>
                            </tr>
                            @empty
                            {{-- <div class="col-12">
                                <div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-info-circle"></i>No Record!</h5>
                                    Please double check PIN/TD/ARP Number.
                                </div>
                            </div> --}}
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div><!-- /.card-body -->
        </div>
        @endif
        @endif

        @if ($viewSearchFieldEmpty)
        <div class="col-12">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-info-circle"></i> Search Record!</h5>
                Please type PIN, TD or ARP number into search field.
            </div>
        </div>
        @endif


        @if ($viewAccountInfo)

        <div class="col-sm-12 col-lg-3">
            <div class="card">
                <div class="p-1 card-header bg-primary">
                    <h3 class="card-title">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <i>ACCOUNT INFORMATION</i>
                    </h3>
                </div>

                <!-- /.card-header -->
                <div class="p-2 card-body table-responsive" style="height: 550px;">

                    <div class="card-body">
                        <strong><i class="mr-1 fas fa-book"></i> PIN:</strong>
                        <p class="text-muted">
                            {{$account_data->rpt_pin}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-book"></i> TD No.:</strong>
                        <p class="text-muted">
                            {{$account_data->rpt_td_no}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-users"></i> KIND:</strong>
                        <p class="text-muted">
                            {{$account_data->rpt_kind}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-users"></i> OWNER(s):</strong>
                        <p class="text-muted">
                            {{$account_data->ro_name}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-map-marker-alt"></i> ADDRESS:</strong>
                        <p class="text-muted">
                            {{$account_data->ro_address}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-info-circle"></i> LAST PAYMENT:</strong>
                        <p class="text-muted">
                            {{$account_data->rtdp_payment_covered_year}}
                        </p>
                        <hr>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
        @endif

        {{-- @if ($viewTaxdue1)
        @livewire('real-property-tax.collection.components.taxdue1')
        @else
        @livewire('real-property-tax.collection.components.taxdue2')
        @endif --}}

        <div class="col-sm-12 col-lg-9">
            <div class="row">
                {{-- AV RECORD(s) --}}
            @if ($viewAssessedValues)
                <div class="col-12">
                    <div class="card">
                        <div class="p-1 card-header bg-primary">
                            <h3 class="card-title">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <i>ASSESSED VALUE RECORD(s)</i>
                            </h3>
                        </div>
                        <div class="p-0 card-body table-responsive">
                            <table class="table table-head-fixed table-bordered text-nowrap">
                                <tbody>
                                    <tr class="bg-secondary">
                                        {{-- {{dd($account_data->assessed_values->count());}} --}}
                                        @forelse ($account_data->assessed_values as $item)
                                        @if ($item->av_value != 0)
                                        <td class="p-0 text-center
                                                        @if ($loop->last)
                                                        <?php $num_rows = $loop->iteration - 1; ?>
                                                        bg-indigo
                                                        @endif
                                                        @if ($loop->iteration == count($assessed_values)-1)
                                                         bg-lightblue
                                                        @endif
                                                        ">
                                            @if ($loop->last)
                                            <?php $num_rows = $loop->iteration - 1; ?>
                                            NEW AV
                                            @endif
                                            @if ($loop->iteration == count($assessed_values)-1)
                                            OLD AV
                                            @endif
                                            @if ($item->av_year_from == $item->av_year_to)
                                            {{ $item->av_year_from }}
                                            @else
                                            {{ $item->av_year_from .'-'. $item->av_year_to}}
                                            @endif
                                        </td>
                                        @endif
                                        @empty
                                        @endforelse
                                    </tr>
                                    <tr>
                                        @forelse ($assessed_values as $item)
                                        @if ($item->av_value != 0)
                                        <td>
                                            @if (strpos($item->av_value, ',') !== false)
                                            {{'P '.$item->av_value}}
                                            @else
                                            {{'P '.number_format($item->av_value, 2, '.', ',')}}
                                            @endif
                                        </td>
                                        @endif
                                        @empty
                                        @endforelse

                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            @endif

            {{-- Payment PAYMENT RECORD(s) --}}
            @if ($viewPaymentRecords)
            <div class="col-12">
                <div class="card">
                    <div class="p-1 card-header bg-primary">
                        <h3 class="card-title">
                            <i class="nav-icon fas fa-info-circle"></i>
                            <i>PAYMENT RECORD(s)</i>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="p-0 card-body table-responsive table-sm">
                        {{-- @if (count($payment_record)) --}}
                        <table class="table table-head-fixed table-bordered">
                            <tbody>
                                <tr class="bg-secondary">
                                    <td class="p-0 text-center" >DATE</td>
                                    <td class="p-0 text-center" >BRACKET</td>
                                    <td class="p-0 text-center" >ASSESSED VALUE</td>
                                    <td class="p-0 text-center" >TAX DUE</td>
                                    <td class="p-0 text-center" >PENALTY/DISCOUNT</td>
                                    <td class="p-0 text-center" >TOTAL</td>
                                    <td class="p-0 text-center" >REMARKS</td>
                                    <td class="p-0 text-center" >TELLER</td>

                                </tr>
                                <?php $total_payment_records  = 0; ?>
                                @forelse ($account_data->payment_records as $key => $item)
                                <tr>
                                    <td class="text-center">{{$item->pay_date}}</td>
                                    <td class="text-center">
                                        @if ($item->pay_year_from != $item->pay_year_to)
                                        {{$item->pay_year_from.'-'.$item->pay_year_to}}
                                        @else
                                        {{ $item->pay_year_from}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (strpos($item->pay_basic, ',') !== false)
                                        {{'P '.$item->pay_basic}}
                                        @else
                                        {{'P '.number_format($item->pay_basic, 2, '.', ',')}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (strpos($item->pay_sef, ',') !== false)
                                        {{'P '.$item->pay_sef}}
                                        @else
                                        {{'P '.number_format($item->pay_sef, 2, '.', ',')}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (strpos($item->pay_penalty, ',') !== false)
                                        {{'P '.$item->pay_penalty}}
                                        @else
                                        {{'P '.number_format($item->pay_penalty, 2, '.', ',')}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (strpos($item->pay_total, ',') !== false)
                                        {{'P '.$item->pay_total}}
                                        @else
                                        {{'P '.number_format($item->pay_total, 2, '.', ',')}}
                                        @endif
                                    </td>
                                    <td class="text-center">{{$item->pay_remarks}}</td>
                                    <td class="text-center">{{$item->TellerName}}</td>

                                </tr>
                                <?php $total_payment_records = $total_payment_records + $item['pr_amount_due'] ?>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            @endif

            {{-- Tax Due --}}
            @if ($viewPaymentUpdated)
            <div class="col-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-info-circle"></i> Payment Updated!</h5>
                    This RPT Account has no pending payment due.
                </div>
            </div>
            @endif

            @if ($viewTaxDue)
            <div class="col-12">
                <div class="card">
                    <div class="p-1 card-header bg-primary">
                        <h3 class="card-title">
                            <i class="nav-icon fas fa-info-circle"></i>
                            <i>TAX DUE</i>
                        </h3>
                        <div class="py-0 card-header ui-sortable-handle">
                            <div class="card-tools">
                                <div class="custom-control custom-switch custom-switch-off-white custom-switch-on-warning">
                                    <input wire:click="removePenalty()" type="checkbox"
                                    class="custom-control-input" id="cSwitch1" {{($cbt) ? 'checked':''}}>
                                    <label class="custom-control-label" for="cSwitch1">CBT</label>
                                </div>
                                <div class="custom-control custom-switch custom-switch-off-white custom-switch-on-warning">
                                    <input wire:click="switchComputeResult()" type="checkbox"
                                    class="custom-control-input" id="cSwitch2" {{($resultSelection) ? 'checked':''}}>
                                    <label class="custom-control-label" for="cSwitch2">Pay Option</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="p-0 card-body table-responsive table-sm">
                        {{-- @if (count($payment_record)) --}}
                        <table class="table table-head-fixed table-bordered text-nowrap">
                            <tbody>
                                <tr class="bg-secondary">
                                    <td class="text-center" rowspan="2"></td>
                                    <td class="text-center" rowspan="2">BRACKET</td>
                                    <td class="text-center" rowspan="2">YEAR</td>
                                    <td class="text-center" colspan="3">TAX DUE</td>
                                    <td class="text-center" rowspan="2">CBT</td>
                                    <td class="text-center" colspan="3">PENALTY</td>
                                    <td class="text-center" style="width:170px" rowspan="2">TOTAL AMOUNT DUE </td>
                                    {{-- <td class="text-center"></td> --}}
                                </tr>
                                <tr class="bg-secondary">
                                    <td class="text-center">BASIC</td>
                                    <td class="text-center">SEF</td>
                                    <td class="text-center">TOTAL</td>
                                    <td class="text-center">BASIC</td>
                                    <td class="text-center">SEF</td>
                                    <td class="text-center">TOTAL</td>
                                    {{-- <td class="text-center"></td> --}}
                                </tr>
                                @if ($payment_dues)
                                @forelse ($payment_dues as $key => $item)
                                <tr class="{{($item['status'] == 2)  ? '':'bg-gray'}}" >
                                    {{-- IF STATUS IS TRUE AND CBT IS FALSE --}}
                                    @if ($item['status'] == 2 && $cbt == false)
                                        <td style="width:4px;" class="p-2 text-center bg-white">
                                            <div class="custom-control custom-checkbox">
                                                <input
                                                wire:click="uncheckList({{$item['count']}})"
                                                class="custom-control-input" type="checkbox" id="checkbox{{$item['count']}}"
                                                {{($item['status'] == 2 ? 'checked' : '')}}>
                                                <label for="checkbox{{$item['count']}}" class="custom-control-label"></label>
                                            </div>
                                        </td>
                                        <td class="bg-info" style="width:170px">
                                            {{ $item['label']}}
                                        </td>
                                        <td class="text-center">{{$item['year_no']}}</td>
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
                                        <td style="width:4px;" class="p-2 text-center bg-white">
                                            <div class="custom-control custom-checkbox">
                                                <input wire:click="checkCBT({{$item['count']}})"
                                                class="custom-control-input" type="checkbox" id="cbt-{{$item['count']}}"
                                                {{($item['cbt_year'] == 1 ? 'checked' : '')}}>
                                                <label for="cbt-{{$item['count']}}" class="custom-control-label"></label>
                                            </div>
                                        </td>
                                        <td class="{{($item['cbt_year'] == 1)  ? 'bg-gray' : ''}}">
                                            @if (strpos($item['pen_basic'], ',') !== false)
                                            {{'P '.$item['pen_basic']}}
                                            @elseif($item['cbt_year'] == 1){{ "-" }}
                                            @else
                                            {{'P '.number_format($item['pen_basic'], 2, '.', ',')}}
                                            @endif
                                        </td>
                                        <td class="{{($item['cbt_year'] == 1)  ? 'bg-gray' : ''}}">
                                            @if (strpos($item['pen_sef'], ',') !== false)
                                            {{'P '.$item['pen_sef']}}
                                            @elseif($item['cbt_year'] == 1){{ "-" }}
                                            @else
                                            {{'P '.number_format($item['pen_sef'], 2, '.', ',')}}
                                            @endif
                                        </td>
                                        <td class="{{($item['cbt_year'] == 1)  ? 'bg-gray' : ''}}">
                                            @if (strpos($item['pen_total'], ',') !== false)
                                            {{'P '.$item['pen_total']}}
                                            @elseif($item['cbt_year'] == 1){{ "-" }}
                                            @else
                                            {{'P '.number_format($item['pen_total'], 2, '.', ',')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (strpos($item['amount_due'], ',') !== false)
                                            {{'P '.$item['amount_due']}}
                                            @else
                                            {{'P '.number_format($item['amount_due'], 2, '.', ',')}}
                                            @endif
                                        </td>
                                    {{-- IF STATUS IS TRUE AND CBT IS TRUE --}}
                                    @elseif($item['status'] == 2 && $cbt == true)
                                        <td style="width:4px;" class="p-2 text-center bg-white">
                                            <div class="custom-control custom-checkbox">
                                                <input
                                                wire:click="uncheckList({{$item['count']}})"
                                                class="custom-control-input" type="checkbox" id="checkbox{{$item['count']}}"
                                                {{($item['status'] == 2 ? 'checked' : '')}}>
                                                <label for="checkbox{{$item['count']}}" class="custom-control-label"></label>
                                            </div>
                                        </td>
                                        <td class="bg-info" style="width:170px">
                                            {{ $item['label']}}
                                        </td>
                                        <td class="text-center">{{$item['year_no']}}</td>
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
                                        <td style="width:4px;" class="bg-secondary">
                                            <div class="custom-control custom-checkbox">
                                                <input wire:click="uncheckCBT({{$item['count']}})"
                                                class="custom-control-input" type="checkbox" id="cbt-{{$item['count']}}" checked>
                                                <label for="cbt-{{$item['count']}}" class="custom-control-label"></label>
                                            </div>
                                        </td>
                                        <td class="bg-secondary"> - </td>
                                        <td class="bg-secondary"> - </td>
                                        <td class="bg-secondary"> - </td>
                                        <td>
                                            @if (strpos($item['td_total'], ',') !== false)
                                            {{'P '.$item['td_total']}}
                                            @else
                                            {{'P '.number_format($item['td_total'], 2, '.', ',')}}
                                            @endif
                                        </td>
                                    {{-- IF STATUS IS FALSE CBT SHOULD ALSO FALSE --}}
                                    @else
                                        <td style="width:4px;" class="p-2 text-center bg-white">
                                            <div class="custom-control custom-checkbox">
                                                <input
                                                wire:click="checkList({{$item['count']}})"
                                                class="custom-control-input" type="checkbox" id="checkbox{{$item['count']}}">
                                                <label for="checkbox{{$item['count']}}" class="custom-control-label"></label>
                                            </div>
                                        </td>
                                        <td class="bg-gray" style="width:170px">
                                            {{ $item['label']}}
                                        </td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    @endif
                                </tr>
                                @empty
                                @endforelse
                                @endif
                                <tr>
                                    <td colspan="10" class="bg-primary" style="width:170px">
                                        TOTAL
                                    </td>
                                    <td>
                                        @if (strpos($amount_due, ',') !== false)
                                        {{'P '.$amount_due}}
                                        @else
                                        {{-- {{'P '.number_format(floor(($amount_due*100))/100, 4, '.', ',')}} --}}
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
                <div class="text-right">
                    <button wire:click.prevent="open_payment()" class="btn btn-primary" {{$payment_button}}>
                        <i class="fas fa-money-bill-wave"></i> Payment
                    </button>
                </div>
            </div>
            @endif

            </div>
        </div>
    </div>
    <hr>

    <!-- Payment modal -->
    <div wire:ignore.self class="modal" id="modal-payment">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class=" modal-content">
                <!-- Modal body -->
                <div class="modal-body">
                    <livewire:real-property-tax.collection.forms.payment/>
                </div>

            </div>
        </div>
    </div>
</div>
