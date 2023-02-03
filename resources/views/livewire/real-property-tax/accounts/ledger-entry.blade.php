<div>
    <div class="row">
        <div class="col-lg-9 col-sm-12">
            <div class="p-1 card card-primary">
            <div class="card-header">
            <h3 class="card-title">ACCOUNT INFORMATION</h3>
            </div>

                <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <strong><i class="mr-1 fas fa-book"></i>TD/ARP Number:</strong>
                        <p class="text-muted">
                            {{($selectedData->rpt_arp_no || $selectedData->rpt_td_no) ? $selectedData->rpt_arp_no.' | '.$selectedData->rpt_td_no : '(Empty)'}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-book"></i>PIN :</strong>
                        <p class="text-muted">
                            {{($selectedData->rpt_pin) ? $selectedData->rpt_pin : '(Empty)'}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-book"></i>Kind :</strong>
                        <p class="text-muted">
                            {{($selectedData->rpt_kind) ? $selectedData->rpt_kind : '(Empty)'}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-book"></i>Classification :</strong>
                        <p class="text-muted">
                            {{($selectedData->rpt_class) ? $selectedData->rpt_class : '(Empty)'}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-user"></i>Owner :</strong>
                        <p class="text-muted">{{($selectedData->ro_name) ? $selectedData->ro_name : '(Empty)'}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-map-marker-alt"></i>Address :</strong>
                        <p class="text-muted">
                            {{($selectedData->ro_address) ? $selectedData->ro_address : '(Empty)'}}
                        </p>
                        <hr>
                    </div>
                    <div class="col-6">
                        <strong><i class="mr-1 fas fa-map-marker-alt"></i>Lot / Blk No. :</strong>
                        <p class="text-muted">
                            {{($selectedData->lp_lot_blk_no) ? $selectedData->lp_lot_blk_no : '(Empty)'}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-map-marker-alt"></i>Street :</strong>
                        <p class="text-muted">
                            {{($selectedData->lp_street) ? $selectedData->lp_street : '(Empty)'}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-map-marker-alt"></i>Barangay :</strong>
                        <p class="text-muted">
                            {{($selectedData->lp_brgy)
                                ? (\App\Models\ListBarangay::where('index',$selectedData->lp_brgy)->first())->name : '(Empty)'}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-map-marker-alt"></i>Municipality :</strong>
                        <p class="text-muted">
                            {{($selectedData->lp_municity)
                                ? (\App\Models\ListMunicity::where('index',$selectedData->lp_municity)->first())->name : '(Empty)'}}
                        </p>
                        <hr>
                        <strong><i class="mr-1 fas fa-map-marker-alt"></i>Province :</strong>
                        <p class="text-muted">
                            {{($selectedData->lp_province)
                                ? (\App\Models\ListProvince::where('index',$selectedData->lp_province)->first())->name : '(Empty)'}}
                        </p>
                        <hr>
                        <div class="text-left">
                            <button wire:click.prevent="viewAccount({{$selectedData->id}})" class="my-2 text-center btn btn-sm btn-primary" type="button"><i class="fas fa-edit"></i> Edit</button>
                        </div>

                    </div>
                </div>


                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-12">
            <div class="card">
                <div class="p-1 card-header bg-primary">
                    <h3 class="card-title">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <i>ASSESSED VALUE</i>
                    </h3>
                    {{-- <button wire:click.prevent="addAssessedValue()" class="my-2 btn btn-sm btn-primary" type="button"><i class="fas fa-plus"></i></button> --}}
                </div>
                <!-- /.card-header -->
                <div class="p-0 card-body table-responsive">
                    <table class="table table-head-fixed table-bordered text-nowrap">
                        <tbody>
                            <tr class="bg-secondary">
                                <th>Year</th>
                                <th>Value</th>
                            </tr>
                            @foreach ($assessed_value as $item)
                            <tr class=" @if ($loop->first)
                                    <?php $num_rows = $loop->iteration - 1; ?>
                                    bg-indigo
                                    @endif
                                    @if ($loop->iteration == 2)
                                    bg-lightblue
                                    @endif">
                                <td >
                                    @if ($loop->first)
                                    <?php $num_rows = $loop->iteration - 1; ?>
                                    NEW AV
                                    @endif
                                    @if ($loop->iteration == 2)
                                    OLD AV
                                    @endif
                                    @if ($item['av_year_from'] == $item['av_year_to'])
                                    {{ $item['av_year_from'] }}
                                    @else
                                    {{ $item['av_year_from'] .'-'. $item['av_year_to']}}
                                    @endif
                                </td>
                                <td>
                                    @if ($item['av_value'] == 0)
                                    &nbsp-
                                    @else
                                        @if (strpos($item['av_value'], ',') !== false)
                                        {{'P '.$item['av_value']}}
                                        @else
                                        {{'P '.number_format($item['av_value'], 2, '.', ',')}}
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                            {{-- <tr class="bg-secondary">
                                <td rowspan="2" class="px-2 m-0 text-center bg-white" style="width: 50px">
                                    <button wire:click.prevent="addAssessedValue()" class="my-2 btn btn-sm btn-primary"
                                        type="button">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                                @forelse ($assessed_value as $item)
                                <td class="p-0 text-center
                                @if ($loop->last)
                                <?php $num_rows = $loop->iteration - 1; ?>
                                bg-indigo
                                @endif
                                @if ($loop->iteration == count($assessed_value)-1)
                                 bg-lightblue
                                @endif
                                ">
                                    @if ($loop->last)
                                    <?php $num_rows = $loop->iteration - 1; ?>
                                    NEW AV
                                    @endif
                                    @if ($loop->iteration == count($assessed_value)-1)
                                    OLD AV
                                    @endif
                                    @if ($item['av_year_from'] == $item['av_year_to'])
                                    {{ $item['av_year_from'] }}
                                    @else
                                    {{ $item['av_year_from'] .'-'. $item['av_year_to']}}
                                    @endif
                                </td>
                                @empty
                                @endforelse
                            </tr>
                            <tr>
                                @forelse ($assessed_value as $item)
                                <td>
                                @if ($item['av_value'] == 0)
                                    &nbsp-
                                @else
                                    @if (strpos($item['av_value'], ',') !== false)
                                    {{'P '.$item['av_value']}}
                                    @else
                                    {{'P '.number_format($item['av_value'], 2, '.', ',')}}
                                    @endif
                                @endif
                                </td>
                                @empty
                                @endforelse
                            </tr> --}}
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button wire:click.prevent="addAssessedValue()" class="my-2 text-center btn btn-sm btn-primary" type="button"><i class="fas fa-edit"></i> Edit</button>
                    </div>

                </div>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

    </div>
    @if (count($payment_record) == 0)
    <div class="col-12">
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-info-circle"></i> No Payment Recorded!</h5>
                <a wire:click.prevent="addPaymentRecord()" class="float-right" href="#"><i class="fas fa-hand-point-right"></i> Click here to add payment record!</a>
            RPT Account has no record of payment yet.
        </div>
    </div>
    @else
        <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="p-1 card-header bg-primary">
                    <h3 class="card-title">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <i>RECORDS OF PAYMENT</i>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="p-0 card-body table-responsive table-sm">
                    <table class="table table-head-fixed table-bordered text-nowrap">
                        <tbody>
                            <tr class="bg-primary">
                                <td class="text-center" rowspan="2"></td>
                                <td class="text-center" rowspan="2">#</td>
                                <td class="text-center" colspan="4">TAX COLLECTED</td>
                                <td class="text-center" rowspan="2">OR NUMBER</td>
                                <td class="text-center" rowspan="2">PAYMENT DATE</td>
                                <td class="text-center" colspan="3">PAYMENT COVERED</td>
                                <td class="text-center" rowspan="2">DIRECTORY</td>
                                <td class="text-center" rowspan="2">REMARKS</td>
                                <td class="text-center" rowspan="2">TELLER</td>
                            </tr>
                            <tr class="bg-secondary">
                                <td class="text-center">BASIC</td>
                                <td class="text-center">SEF</td>
                                <td class="text-center">PENALTY</td>
                                <td class="text-center">TOTAL</td>
                                <td class="text-center">FROM</td>
                                <td class="text-center">TO</td>
                                <td class="text-center">YEAR(s)</td>
                            </tr>
                            <?php $nums = 1?>
                            @forelse ($payment_record as $value)
                            <tr>
                                <td class="px-0 py-1 m-0 text-center bg-white">
                                    <button class="btn btn-sm btn-primary" data-toggle="dropdown">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                    <div style=" border: transparent; width: 10px;" class="p-0 dropdown-menu">

                                        <a wire:click.prevent="editPaymentRecord({{$value['id']}})" href="#"
                                            class="dropdown-item text-primary keychainify-checked">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="#" onclick="confirm('Delete this record?') || event.stopImmediatePropagation()"
                                            wire:click="deleteSingleRecord({{$value['id']}})" class="dropdown-item text-danger keychainify-checked">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </div>
                                </td>
                                <td>{{$nums++}}. </td>
                                <td>
                                    @if ($value['pay_basic'] == 0)
                                        &nbsp -
                                    @else
                                        @if (strpos($value['pay_basic'], ',') !== false)
                                        {{'P '.$value['pay_basic']}}
                                        @else
                                        {{'P '.number_format($value['pay_basic'], 2, '.', ',')}}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($value['pay_sef'] == 0)
                                        &nbsp -
                                    @else
                                        @if (strpos($value['pay_sef'], ',') !== false)
                                        {{'P '.$value['pay_sef']}}
                                        @else
                                        {{'P '.number_format($value['pay_sef'], 2, '.', ',')}}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($value['pay_penalty'] == 0)
                                        &nbsp -
                                    @else
                                        @if (strpos($value['pay_penalty'], ',') !== false)
                                        {{'P '.$value['pay_penalty']}}
                                        @else
                                        {{'P '.number_format($value['pay_penalty'], 2, '.', ',')}}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($value['pay_amount_due'] == 0)
                                        &nbsp -
                                    @else
                                        {{'P '.number_format($value['pay_amount_due'], 2, '.', ',')}}
                                        {{-- @if (strpos($value['pay_amount_due'], ',') !== false)
                                        {{'P '.$value['pay_amount_due']}}
                                        @else
                                        {{'P '.number_format($value['pay_amount_due'], 2, '.', ',')}}
                                        @endif --}}
                                    @endif
                                </td>
                                <td>{{$value['pay_serial_no']}}</td>
                                <td>{{$value['pay_date']}}</td>
                                <td>{{$value['pay_year_from']}}</td>
                                <td>{{$value['pay_year_to']}}</td>
                                <td>{{$value['pay_covered_year']}}</td>
                                <td>{{$value['pay_directory']}}</td>
                                <td>{{$value['pay_remarks']}}</td>
                                <td>{{App\Models\User::find($value['pay_teller'])->firstname ?? $value['pay_teller']}}</td>
                                {{-- <td>{{(App\Models\User::find($value['pay_teller']))->firstname ?? '(Unknown)'}}</td> --}}
                            </tr>
                            @empty

                            @endforelse
                            <tr>
                                <td colspan="14">
                                    <a wire:click.prevent="addPaymentRecord()" class="" href="#"><i class="fas fa-plus"></i> Add payment record!</a>
                                </td>
                            </tr>

                            {{-- <tr>
                                <td class="bg-indigo" colspan="3">
                                    <h4 class="m-0">GRAND TOTAL</h4>
                                </td>
                                <td></td>
                                <td class="bg-secondary" colspan="10"></td>

                            </tr> --}}
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    @endif

    <!-- The Modal -->
    <div wire:ignore.self class="modal" id="modal-assessed-value">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class=" modal-content">
                <!-- Modal body -->
                <div class="modal-body">
                    <livewire:real-property-tax.accounts.forms.assessed-value />
                </div>

            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal" id="modal-payment-record">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class=" modal-content">
                <!-- Modal body -->
                <div class="modal-body">
                    <livewire:real-property-tax.accounts.form-payment-record />
                </div>

            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal" id="modal-account-view">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="p-0 modal-body">
                    <livewire:real-property-tax.accounts.forms.account-view />
                </div>

            </div>
        </div>
    </div>


</div>
