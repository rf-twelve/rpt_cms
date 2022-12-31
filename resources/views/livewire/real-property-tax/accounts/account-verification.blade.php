<div x-data="{ import_fields: false, import_btn: true, openSearch: false }">
    <div class="row">
        <div wire:loading>
            @include('layouts/components/loading-indicator')
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="text-center col-12">
                            <button type="button" wire:click.defer="createRecord()" class="btn btn-app">
                                <i class="fas fa-file"></i> New
                            </button>
                            <button type="button" x-on:click="openSearch = !openSearch" class="btn btn-app">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <button type="button" x-on:click="import_fields = !import_fields" class="btn btn-app">
                                <i class="fas fa-file-import"></i> Import
                            </button>
                            <button type="button" wire:click.defer="toggleDuplicate1()"
                            class="btn {{$toggleDuplicateSelected1 == true ? 'bg-success' : null}} btn-app">
                                <span class="badge bg-warning text-md">{{$duplicatePin}}</span>
                                <i class="fas fa-clone"></i> PIN
                            </button>
                            <button type="button" wire:click.defer="toggleDuplicate2()"
                            class="btn {{$toggleDuplicateSelected2 == true ? 'bg-success' : null}} btn-app">
                                <span class="badge bg-warning text-md">{{$duplicateTdArp}}</span>
                                <i class="fas fa-clone"></i> TD/ARP
                            </button>
                            <button type="button" wire:click.defer="toggleDuplicate3()"
                            class="btn {{$toggleDuplicateSelected3 == true ? 'bg-success' : null}} btn-app">
                                <span class="badge bg-warning text-md">{{$duplicatePinTdArp}}</span>
                                <i class="fas fa-clone"></i> PIN/TD/ARP
                            </button>
                            <button type="button" wire:click.defer="toggleVerified4()"
                            class="btn {{$toggleVerified4 == true ? 'bg-success' : null}} btn-app">
                                <span class="badge bg-success text-md">{{$verifiedStatus}}</span>
                                <i class="fas fa-check-circle"></i> Verified
                            </button>
                            <button type="button" wire:click.defer="toggleUnVerified5()"
                            class="btn {{$toggleUnVerified5 == true ? 'bg-success' : null}} btn-app">
                                <span class="badge bg-danger text-md">{{$unverifiedStatus}}</span>
                                <i class="fas fa-question-circle"></i> Unverified
                            </button>
                        </div>
                    </div>

                    <div class="row" x-show.transition.duration.200ms="import_fields">
                        <div class="col-lg-4 col-sm-12"></div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <form action="{{ url('assessor/import_accounts')}}" method="POST" enctype="multipart/form-data">
                                {{-- <form wire:submit="import_rpt" method="GET" enctype="multipart/form-data"> --}}
                                    @csrf
                                    <div class="input-group" >
                                        <div class="custom-file">
                                            <input wire:model="upload_file" type="file" name="rpt_excell" class="custom-file-input ">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button type="submit" class="input-group-text bg-primary"
                                                x-on:click="import_fields = false, import_btn = true">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    {{-- Show search and filter function --}}
                    <div x-show.transition.duration.200ms="openSearch">
                        <hr>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Search Type:</label>
                                        <select wire:model="searchType" class="form-control">
                                            <option value="rpt_pin">PIN</option>
                                            <option value="rpt_td_no">TD NO.</option>
                                            <option value="rpt_arp_no">ARP NO.</option>
                                            <option value="ro_name">OWNER/S NAME</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Sort By:</label>
                                        <select wire:model.debounce.500="sortBy" class="form-control loat-right">
                                            <option value="rpt_pin">PIN</option>
                                            <option value="rpt_td_no">TD NO.</option>
                                            <option value="rpt_arp_no">ARP NO.</option>
                                            <option value="rpt_kind">KIND</option>
                                            <option value="rpt_class">CLASS</option>
                                            <option value="ro_name">OWNER/S NAME</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Sort Type:</label>
                                        <select wire:model="sortType" class="form-control">
                                            <option value="asc">Asc</option>
                                            <option value="desc">Desc</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label>Per Page:</label>
                                    <select wire:model="perPage" class="form-control">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="30000">All</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <input wire:model.debounce.500="searchTerm" type="search" class="form-control form-control-lg"
                                    placeholder="Type your keywords here">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End of search and filter --}}
                </div>
                <div class="card-body">
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

                    {{-- ALL Duplicates --}}
                    @if($toggleDuplicateSelected1 || $toggleDuplicateSelected2 || $toggleDuplicateSelected3 || $toggleVerified4 || $toggleUnVerified5)
                    <div class="card card-primary card-outline">
                        <div class="p-0 card-body table-responsive">
                            <div class="text-center">
                                <h4>ACCOUNT VERIFICATION - {{ $toggleVerified4 ? 'VERIFIED' : 'DUPLICATES'}}</h4>
                            </div>
                            <table class="table table-hover table-bordered table-sm">
                                <thead>
                                    <tr class="text-center text-nowrap bg-primary">
                                        <th rowspan="3" class="p-0 py-1 text-center">
                                        </th>
                                        <th>PIN</th>
                                        <th>KIND</th>
                                        <th>CLASS</th>
                                        <th>TD/ARP</th>
                                        <th>PROPERTY OWNER</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody class="text-nowrap">
                                    @if(!is_null($rptAccountDuplicates) || !empty($rptAccountDuplicates))
                                    @foreach ($rptAccountDuplicates as $duplicate)
                                    <tr>
                                        <td class="m-0 text-center no-print"
                                            style="padding-left: 6px;padding-right: 6px;">
                                            <button class="btn btn-sm btn-primary" data-toggle="dropdown">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                            <div style=" border: transparent; width: 10px;" class="p-0 dropdown-menu">
                                                @if ($duplicate->rtdp_status == 'verified')
                                                <button wire:click="viewAccount({{$duplicate->id}})" href="#"
                                                    class="dropdown-item text-info keychainify-checked">
                                                    <i class="fas fa-eye"></i> View
                                                </button>
                                                @else
                                                <button wire:click="verifyRecord({{$duplicate->id}})" href="#"
                                                    class="dropdown-item text-info keychainify-checked">
                                                    <i class="fas fa-eye"></i> Verify
                                                </button>
                                                @endif
                                                <a href="#"
                                                    onclick="confirm('Delete this record?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteSingleRecord({{$duplicate->id}})"
                                                    class="dropdown-item text-danger keychainify-checked">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ $duplicate->rpt_pin }}</td>
                                        <td>{{ $duplicate->rpt_kind }}</td>
                                        <td>{{ $duplicate->rpt_class }}</td>
                                        <td>{{ $duplicate->rpt_td_no }}</td>
                                        <td>
                                            @if (strlen($duplicate->ro_name) > 70)
                                            {{ substr($duplicate->ro_name, 0, 70). " ... "}}
                                            @else
                                            {{ $duplicate->ro_name }}
                                            @endif
                                        </td>
                                        <td> @if ($duplicate->rtdp_status == 'new')
                                            <span class="right badge badge-danger">U</span>
                                            @else
                                            <span class="right badge badge-success">V</span>
                                            @endif</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.card-body -->
                    @endif

                    <div class="card card-primary card-outline">
                        <div class="p-0 card-body table-responsive">

                            <table class="table table-hover table-bordered table-sm">
                                <thead>
                                    <tr class="text-center text-nowrap bg-primary">
                                        <th rowspan="3" class="p-0 py-1 text-center">
                                        </th>
                                        <th rowspan="2">PIN</th>
                                        <th rowspan="2">KIND</th>
                                        <th rowspan="2">CLASS</th>
                                        <th rowspan="2">TD/ARP No.</th>
                                        {{-- <th rowspan="2">ARP No.</th> --}}
                                        <th rowspan="2">Owner/s Name</th>
                                        <th colspan="4">Tax Collected</th>
                                        <th rowspan="2">Date of Payment</th>
                                        <th rowspan="2">O.R. Number</th>
                                        <th rowspan="2">Payment Covered</th>
                                        <th rowspan="2">Status</th>
                                    </tr>
                                    <tr class="bg-secondary">
                                        <th>BASIC</th>
                                        <th>SEF</th>
                                        <th>PENALTY</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody class="text-nowrap">
                                    @forelse ($rptAccount as $item)
                                    <tr>
                                        <td class="m-0 text-center no-print"
                                            style="padding-left: 6px;padding-right: 6px;">
                                            <button class="btn btn-sm btn-primary" data-toggle="dropdown">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                            <div style=" border: transparent; width: 10px;" class="p-0 dropdown-menu">

                                                @if ($item->rtdp_status == 'verified')
                                                <button wire:click="viewAccount({{$item->id}})" type="button"
                                                    class="dropdown-item text-info keychainify-checked">
                                                    <i class="fas fa-eye"></i> View
                                                </button>
                                                <a href="{{url('rpt/accounts/ledger-entry/'.$item->id)}}"
                                                    class="dropdown-item text-primary keychainify-checked">
                                                    <i class="fas fa-list"></i> Ledger Entry
                                                </a>
                                                @else
                                                <button wire:click="verifyRecord({{$item->id}})" type="button"
                                                    class="dropdown-item text-info keychainify-checked">
                                                    <i class="fas fa-eye"></i> Verify
                                                </button>
                                                @endif
                                                <a href="#"
                                                    onclick="confirm('Delete this record?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteSingleRecord({{$item->id}})"
                                                    class="dropdown-item text-danger keychainify-checked">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ $item->rpt_pin }}
                                            @if ($item->rtdp_status == 'new')
                                            <span class="badge bg-primary">N</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->rpt_kind }}</td>
                                        <td>{{ $item->rpt_class }}</td>
                                        <td>{{ $item->rpt_td_no }}</td>
                                        {{-- <td>{{ $item->rpt_arp_no}}</td> --}}
                                        <td>
                                            @if (strlen($item->ro_name) > 15)
                                            {{ substr($item->ro_name, 0, 15). " ... "}}
                                            @else
                                            {{ $item->ro_name }}
                                            @endif
                                        </td>
                                        <td>{{ $item->rtdp_tc_basic }}</td>
                                        <td>{{ $item->rtdp_tc_sef }}</td>
                                        <td>{{ $item->rtdp_tc_penalty }}</td>
                                        <td>{{ $item->rtdp_tc_total }}</td>
                                        <td>{{ $item->rtdp_payment_date }}</td>
                                        <td>{{ $item->rtdp_or_no }}</td>
                                        <td>{{ $item->rtdp_payment_covered_year}} </td>


                                        <td>
                                            @if ($item->rtdp_status == 'new')
                                            <span class="right badge badge-danger">U</span>
                                            @else
                                            <span class="right badge badge-success">V</span>
                                            @endif

                                        </td>
                                    </tr>
                                    @empty

                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{$rptAccount->links()}}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <!-- The Modal -->
        <div wire:ignore.self class="modal" id="modal-account-registry">
            <div class="modal-dialog modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="p-0 modal-body">
                        <livewire:real-property-tax.accounts.forms.account-registry />
                    </div>

                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal" id="modal-account-verify">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="p-0 modal-body">
                        <livewire:real-property-tax.accounts.forms.account-verify />
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
