<div x-data="{ import_fields: false, import_btn: true, openSearch: false}">
    <div class="row">
        <div wire:loading>
            @include('layouts/components/loading-indicator')
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button" wire:click.defer="createRecord()" class="btn btn-app">
                                <i class="fas fa-file"></i> New
                            </button>
                            <button type="button" x-on:click="openSearch = !openSearch" class="btn btn-app">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <button type="button" x-on:click="import_fields = !import_fields"
                                class="btn btn-app">
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
                                <form action="{{ url('assessor/import_assessment_roll')}}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input wire:model="upload_file" type="file" name="rpt_excell"
                                                class="custom-file-input ">
                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                file</label>
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
                                            <option value="assmt_roll_td_arp_no">TD/ARP No.</option>
                                            <option value="assmt_roll_pin">PIN.</option>
                                            <option value="assmt_roll_td_arp_no_prev">TD/ARP No. Previous</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Sort By:</label>
                                        <select wire:model.debounce.500="sortBy" class="form-control loat-right">
                                            <option value="assmt_roll_td_arp_no">TD/ARP No.</option>
                                            <option value="assmt_roll_pin">PIN.</option>
                                            <option value="assmt_roll_td_arp_no_prev">TD/ARP No. Previous</option>
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
                                <input wire:model.debounce.500="searchTerm" type="search"
                                    class="form-control form-control-lg" placeholder="Type your keywords here">
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
                        <div class="card-body table-responsive p-0">
                            <div class="text-center">
                                <h4>ASSESSMENT ROLL - DUPLICATES</h4>
                            </div>
                            <table class="table table-hover table-bordered table-sm">
                                <thead>
                                    <tr class="text-center text-nowrap bg-primary">
                                        <th rowspan="3" class="text-center p-0 py-1">
                                        </th>
                                        <th>TD/ARP No.</th>
                                        <th>PIN</th>
                                        <th>PROPERTY OWNER</th>
                                        <th>ADDRESS OF PROPERTY</th>
                                    </tr>
                                </thead>
                                <tbody class="text-nowrap">
                                    @if(!is_null($rptAccountDuplicates) || !empty($rptAccountDuplicates))
                                    @foreach ($rptAccountDuplicates as $duplicate)
                                    <tr>
                                        <td class="no-print text-center m-0"
                                            style="padding-left: 6px;padding-right: 6px;">
                                            <button class="btn btn-sm btn-primary" data-toggle="dropdown">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                            <div style=" border: transparent; width: 10px;" class="dropdown-menu p-0">


                                                <button wire:click="viewRecord({{$duplicate->id}})" href="#"
                                                    class="dropdown-item text-info keychainify-checked">
                                                    <i class="fas fa-eye"></i> Verify
                                                </button>
                                                <a href="#"
                                                    onclick="confirm('Delete this record?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteSingleRecord({{$duplicate->id}})"
                                                    class="dropdown-item text-danger keychainify-checked">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ $duplicate->assmt_roll_td_arp_no }}</td>
                                        <td>{{ $duplicate->assmt_roll_pin }}</td>
                                        <td>
                                            @if (strlen($duplicate->assmt_roll_owner) > 70)
                                            {{ substr($duplicate->assmt_roll_owner, 0, 70). " ... "}}
                                            @else
                                            {{ $duplicate->assmt_roll_owner }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (strlen($duplicate->assmt_roll_address) > 70)
                                            {{ substr($duplicate->assmt_roll_address, 0, 70). " ... "}}
                                            @else
                                            {{ $duplicate->assmt_roll_address }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.card-body -->
                    @endif

                    {{-- ALL Records --}}
                    <div class="card card-primary card-outline">
                        <div class="card-body table-responsive p-0">
                            <div class="text-center">
                                <h4>ASSESSMENT ROLL</h4>
                            </div>
                            <div class="row m-2">
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <strong>PROVINCE: </strong><br>
                                        <select wire:model.debounce.500ms="searchProvince" class="form-control">
                                            <option value="">All</option>
                                            @foreach ($list_province as $item)
                                            <option value="{{$item['index']}}">{{$item['name']}}</option>
                                            @endforeach
                                        </select>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <strong>MUNICIPALITY: </strong><br>
                                        <select wire:model.debounce.500ms="searchMunicipality" class="form-control">
                                            <option value="">All</option>
                                            @foreach ($list_municity as $item)
                                            <option value="{{$item['index']}}">{{$item['name']}}</option>
                                            @endforeach
                                        </select>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <strong>BARANGAY: </strong><br>
                                        <select wire:model.debounce.500ms="searchBarangay" class="form-control">
                                            <option value="">All</option>
                                            @foreach ($list_barangay as $item)
                                            <option value="{{$item['index']}}">{{$item['name']}}</option>
                                            @endforeach
                                        </select>
                                    </address>
                                </div>
                                <!-- /.col -->
                            </div>
                            <table class="table table-hover table-bordered table-sm">
                                <thead>
                                    <tr class="text-center text-nowrap bg-primary">
                                        <th rowspan="3" class="text-center p-0 py-1">
                                        </th>
                                        <th>TD/ARP No.</th>
                                        <th>PIN</th>
                                        <th>Lot/Blk. No.</th>
                                        <th>PROPERTY OWNER</th>
                                        <th>ADDRESS OF PROPERTY</th>
                                        <th>KIND</th>
                                        <th>Classification</th>
                                        <th>AV</th>
                                        <th>Effectivity</th>
                                        <th>Prev TD/ARP No.</th>
                                        <th>Prev AV</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-nowrap">
                                    @forelse ($rptAccount as $item)
                                    <tr>
                                        <td class="no-print text-center m-0"
                                            style="padding-left: 6px;padding-right: 6px;">
                                            <button class="btn btn-sm btn-primary" data-toggle="dropdown">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                            <div style=" border: transparent; width: 10px;" class="dropdown-menu p-0">
                                                <button wire:click="viewRecord({{$item->id}})"
                                                    class="dropdown-item text-info keychainify-checked"><i class="fas fa-eye"></i>
                                                    {{$item->assmt_roll_status == 'verified' ? 'View' : 'Verify'}}
                                                </button>
                                                <a href="#"
                                                    onclick="confirm('Delete this record?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteSingleRecord({{$item->id}})"
                                                    class="dropdown-item text-danger keychainify-checked">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ $item->assmt_roll_td_arp_no }}
                                            {{-- @if ($item->rtdp_status == 'new')
                                            <span class="badge bg-success">NEW</span>
                                            @endif --}}
                                        </td>
                                        <td>{{ $item->assmt_roll_pin }}
                                            {{-- @foreach ($duplicate_data as $dups)
                                            @if ($item->assmt_roll_pin == $dups->assmt_roll_pin)
                                            <span class="badge bg-warning">D</span>
                                            @endif
                                            @endforeach --}}
                                            {{-- {{dd($duplicate_data)}} --}}
                                            {{-- @foreach ($verified_data as $verified)
                                            @if ($item->assmt_roll_pin == $verified['assmt_roll_pin'])
                                            <span class="badge bg-info">V</span>
                                            @endif
                                            @endforeach --}}

                                        </td>
                                        <td>{{ $item->assmt_roll_lot_blk_no }}</td>
                                        <td>
                                            @if (strlen($item->assmt_roll_owner) > 15)
                                            {{ substr($item->assmt_roll_owner, 0, 15). " ... "}}
                                            @else
                                            {{ $item->assmt_roll_owner }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (strlen($item->assmt_roll_address) > 20)
                                            {{ substr($item->assmt_roll_address, 0, 20). " ... "}}
                                            @else
                                            {{ $item->assmt_roll_address }}
                                            @endif
                                        </td>
                                        <td>{{ $item->assmt_roll_kind }}</td>
                                        <td>{{ $item->assmt_roll_class }}</td>
                                        <td>
                                            {{ number_format($item->assmt_roll_av, 2, '.', ',') }}
                                        </td>
                                        <td>{{ $item->assmt_roll_effective }}</td>
                                        <td>{{ $item->assmt_roll_td_arp_no_prev }}</td>
                                        <td>{{ $item->assmt_roll_av_prev }}</td>
                                        <td>
                                            @if (strlen($item->assmt_roll_remarks) > 15)
                                            {{ substr($item->assmt_roll_remarks, 0, 15). " ... "}}
                                            @else
                                            {{ $item->assmt_roll_remarks }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->assmt_roll_status == 'new')
                                            <span class="right badge badge-danger">U</span>
                                            @else
                                            <span class="right badge badge-success">V</span>
                                            @endif

                                        </td>
                                    </tr>
                                    @empty

                                    @endforelse
                                    <tr>
                                        <td colspan="14">{{$rptAccount->links()}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.card-body -->


                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <!-- The Modal -->
    <div wire:ignore.self class="modal" id="modal-assessmentRollRegistry">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class=" modal-content">
                <!-- Modal body -->
                <div class="modal-body p-0">
                    <livewire:assessor.forms.assessment-roll-registry />
                </div>

            </div>
        </div>
    </div>
</div>

