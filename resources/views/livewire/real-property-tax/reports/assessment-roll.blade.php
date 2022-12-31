
<div class="row">

    <div class="col-lg-3 col-sm-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Assessment Roll Reports</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="date_input">Date:</label>
                    <input wire:model.lazy="get_date" type="date" class="form-control" id="date_input" placeholder="Report date">
                    @error('get_date')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                {{-- <div class="form-group">
                    <label for="as-of">As of:</label>
                    <input wire:model="temp_date" type="date" class="form-control" id="as-of" placeholder="Select date">
                </div> --}}
                <div class="form-group">
                    <label for="signatory1">Prepared by:</label>
                    <input wire:model="signatory1" type="text" class="form-control" id="signatory1" placeholder="Name of Signatory">
                    @error('signatory1')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="designation1">Designation:</label>
                    <input wire:model="designation1" type="text" class="form-control" id="designation1" placeholder="Signatory designation">
                    @error('designation1')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="signatory2">Noted by:</label>
                    <input wire:model="signatory2" type="text" class="form-control" id="signatory2" placeholder="Name of Signatory">
                    @error('signatory2')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="designation2">Designation:</label>
                    <input wire:model="designation2" type="text" class="form-control" id="designation2" placeholder="Signatory designation">
                    @error('designation2')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="text-center form-group">
                    <a href="#" target="_blank" style="width: 30%" class="btn btn-primary" wire:click="print()">
                        Print
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-sm-12">
        <div class="card card-primary">
            <div class="pt-4 text-center">
                <img src="{{ asset('\img\lgulopezquezon.png') }}" alt="logo" height="50">
            </div>

            <div class="text-center">
                Republic of the Philippines<br>
                Province of QUEZON<br>
                Municipality of LOPEZ<br>
                <strong>OFFICE OF THE MUNICIPAL TREASURER</strong><br>
                As of {{ $as_of }}<br>

            </div>
            <div class="mt-2 text-center">
                <h5>ASSESSMENT ROLL SUMMARY</h5>
                <span>Taxable Properties</span>
            </div>
            <div class="mx-4 mt-2 mb-0 row">
                <div class="col-3">
                    <p class="mb-0">PROVINCE: &ensp;<u><strong>QUEZON</strong></u></p>
                    <p class="mb-0">MUNICIPALITY: &ensp;<u><strong>LOPEZ</strong></u></p>
                </div>
                <div class="col-6"></div>
                <div class="col-3">
                    <p class="mb-0">Index No.: &ensp;<u><strong>015</strong></u></p>
                    <p class="mb-0">Index No.: &ensp;<u><strong>16</strong></u></p>
                </div>
            </div>
            <div class="mx-4 text-center">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        {{-- <th style="width:2%">#</th> --}}
                        <th class="p-0 text-center" style="width:15%">Barangay</th>
                        <th class="p-0 text-center" style="width:8%">Code</th>
                        <th class="p-0 text-center" style="width:10%">Land</th>
                        <th class="p-0 text-center" style="width:10%">Building</th>
                        <th class="p-0 text-center" style="width:10%">Machineries</th>
                        <th class="p-0 text-center" style="width:10%">Total Assessed Value</th>
                        <th class="p-0 text-center" style="width:10%">Total Tax Collectibles(2%)</th>
                        <th class="p-0 text-center" style="width:10%">Previous Assessed value </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($assessed_values as $item)
                        <tr>
                            <td class="p-1 text-left ">{{ $item['barangay'] }}</td>
                            <td class="p-1 text-center ">{{ $item['code'] }}</td>
                            <td class="p-1 text-right ">{{ number_format($item['land'],2,'.',',') }}</td>
                            <td class="p-1 text-right ">{{ number_format($item['building'],2,'.',',') }}</td>
                            <td class="p-1 text-right ">{{ number_format($item['machineries'],2,'.',',') }}</td>
                            <td class="p-1 text-right ">{{ number_format($item['total_av'],2,'.',',') }}</td>
                            <td class="p-1 text-right ">{{ number_format($item['total_collectibles'],2,'.',',') }}</td>
                            <td class="p-1 text-right ">{{ number_format($item['total_av_prev'],2,'.',',') }}</td>
                        </tr>
                        @empty

                        @endforelse
                        @if ($grandTotal)
                        <tr>
                            <td colspan="2" class="p-1 text-right"><strong><i>Grand Total:</i></strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['land'],2,'.',',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['building'],2,'.',',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['machineries'],2,'.',',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['total_av'],2,'.',',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['total_collectibles'],2,'.',',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['total_av_prev'],2,'.',',')}}</strong></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="mx-4 mt-4 mb-0 row">
                <div class="col-3">
                    <div>
                    <span>Prepared by:</span>
                        <div class="mt-4 text-center">
                            <p class="mb-0"><strong>{{$signatory1}}</strong></p>
                            <span>{{$designation1}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6"></div>
                <div class="col-3">
                    <div>
                    <span>Noted by:</span>
                        <div class="mt-4 text-center">
                            <p class="mb-0"><strong>{{$signatory2}}</strong></p>
                            <span>{{$designation2}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



