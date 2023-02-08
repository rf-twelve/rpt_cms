<div class="row">

    <div class="col-lg-3 col-sm-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Collectible Reports</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="date_from">From:</label>
                    <input wire:model.lazy="date_from" type="date" class="form-control" id="date_from" placeholder="Report date">
                    @error('date_from')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="date_to">To:</label>
                    <input wire:model.lazy="date_to" type="date" class="form-control" id="date_to" placeholder="Report date">
                    @error('date_to')<span class="text-danger">{{ $message }}</span>@enderror
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
                {{ $date_from }} - {{ $date_to }}<br>

            </div>
            <div class="mt-2 text-center">
                <h5>SUMMARY OF RPT COLLECTIBLE PER BARANGAY</h5>
            </div>
            <div class="mx-4 text-center">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th class="p-0 text-center" style="width:4%">NO.</th>
                        <th class="p-0 text-center" style="width:16%">BARANGAY</th>
                        <th class="p-0 text-center" style="width:16%">NEW ASSESSED VALUE</th>
                        <th class="p-0 text-center" style="width:16%">OLD ASSESSED VALUE</th>
                        <th class="p-0 text-center" style="width:16%">OLD AV 1%</th>
                        <th class="p-0 text-center" style="width:16%">NEW AV 70%</th>
                        <th class="p-0 text-center" style="width:16%">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($assessed_values as $item)
                        <tr>
                            <td class="p-1 text-right ">{{ $item['count'] }}</td>
                            <td class="p-1 text-left ">{{ $item['barangay'] }}</td>
                            <td class="p-1 text-right ">{{ number_format($item['new_av'],2,'.',',') }}</td>
                            <td class="p-1 text-right ">{{ number_format($item['old_av'],2,'.',',') }}</td>
                            <td class="p-1 text-right ">{{ number_format($item['old_av_1'],2,'.',',') }}</td>
                            <td class="p-1 text-right ">{{ number_format($item['new_av_70'],2,'.',',') }}</td>
                            <td class="p-1 text-right ">{{ number_format($item['total'],2,'.',',') }}</td>
                        </tr>
                        @empty

                        @endforelse
                        @if ($grandTotal)
                        <tr>
                            <td colspan="2" class="p-1 text-right"><strong><i>Grand Total:</i></strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['new_av'],2,'.',',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['old_av'],2,'.',',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['old_av_1'],2,'.',',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['new_av_70'],2,'.',',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['total'],2,'.',',')}}</strong></td>
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
            </div>
        </div>
    </div>
</div>



