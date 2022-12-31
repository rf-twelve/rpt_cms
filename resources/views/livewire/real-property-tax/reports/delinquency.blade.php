
<div class="row">

    <div class="col-lg-3 col-sm-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Delinquency Reports</h3>
            </div>
            <div class="card-body">
                    <div class="form-group">
                        <label for="from">From:</label>
                        <input wire:model="start_year" type="number" class="form-control" id="from" placeholder="From what year?">
                        @error('start_year')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="to">To:</label>
                        <input wire:model="end_year" type="number" class="form-control" id="to" placeholder="up to year?">
                        @error('end_year')<span class="text-danger">{{ $message }}</span>@enderror

                    </div>
                    {{-- <div class="form-group">
                        <label for="as-of">As of:</label>
                        <input wire:model="temp_date" type="date" class="form-control" id="as-of" placeholder="Select date">
                    </div> --}}
                    <div class="form-group">
                        <label for="signatory">Signatory</label>
                        <input wire:model="signatory" type="text" class="form-control" id="signatory" placeholder="Name of Signatory">
                        @error('signatory')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="designation">Designation:</label>
                        <input wire:model="designation" type="text" class="form-control" id="designation" placeholder="Signatory designation">
                        @error('designation')<span class="text-danger">{{ $message }}</span>@enderror
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
                <strong>{{$start_year}} - {{$end_year}} </strong><br>
                {{-- As of {{ $invoice->getDate() }}<br> --}}
                {{-- As of December 31, 2022<br> --}}
                {{-- as of {{ $as_of }}<br> --}}

            </div>
            <div class="mt-2 text-center">
                <h5>SUMMARY OF REAL PROPERTY TAX DELINQUENCIES PER BARANGAY</h5>
            </div>
            <div class="mx-4 text-center">
                <table class="table table-bordered">
                    <thead>
                        <tr style="font-size: 10pt">
                            <th style="p-1 width: 10px">#</th>
                            <th class="p-1 text-center">BARANGAY</th>
                            <th class="p-1 text-center" style="width:15%;">Sum of ASSESSED VALUE</th>
                            <th class="p-1 text-center" style="width:15%;">Sum of BASIC</th>
                            <th class="p-1 text-center" style="width:15%;">Sum of SEF</th>
                            <th class="p-1 text-center" style="width:15%;">Sum of PENALTY</th>
                            <th class="p-1 text-center" style="width:15%;">Sum of TOTAL DELINQUENCY</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $num = 1 ?>
                        @forelse ($delinquencies as $item)
                        <tr>
                            <td class="p-1 text-right">{{$num++}}.</td>
                            <td class="p-1 text-left">{{$item['brgy']}}</td>
                            <td class="p-1 text-right">{{number_format($item['av_sum'], 2, '.', ',')}}</td>
                            <td class="p-1 text-right">{{number_format($item['basic_sum'], 2, '.', ',')}}</td>
                            <td class="p-1 text-right">{{number_format($item['sef_sum'], 2, '.', ',')}}</td>
                            <td class="p-1 text-right">{{number_format($item['penalty_sum'], 2, '.', ',')}}</td>
                            <td class="p-1 text-right">{{number_format($item['delinquency_sum'], 2, '.', ',')}}</td>
                        </tr>
                        @empty

                        @endforelse
                        @if ($grandTotal)
                        <tr>
                            <td></td>
                            <td class="p-1 text-center"><strong><i>Grand Total</i></strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['av'], 2, '.', ',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['basic'], 2, '.', ',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['sef'], 2, '.', ',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['penalty'], 2, '.', ',')}}</strong></td>
                            <td class="p-1 text-right"><strong>{{number_format($grandTotal['delinquency'], 2, '.', ',')}}</strong></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="my-4 text-align-left">
            </div>

            <div class="my-4 text-align-left" style="width:300px">
                <div class="text-center">
                    <p class="mb-0"><strong>{{$signatory}}</strong></p>
                    <span>{{$designation}}</span>
                </div>
            </div>
        </div>
    </div>
</div>



