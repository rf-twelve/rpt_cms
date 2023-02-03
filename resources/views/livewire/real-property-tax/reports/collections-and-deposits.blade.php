<div class="row">

    <div class="col-lg-3 col-sm-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Collectible Reports</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="date_input">Date From:</label>
                    <input wire:model.lazy="date_from" type="date" class="form-control" id="date_input" placeholder="Report date">
                    @error('date_from')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="date_input">Date To:</label>
                    <input wire:model.lazy="date_to" type="date" class="form-control" id="date_input" placeholder="Report date">
                    @error('date_to')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                {{-- <div class="form-group">
                    <label for="as-of">As of:</label>
                    <input wire:model="temp_date" type="date" class="form-control" id="as-of" placeholder="Select date">
                </div> --}}
                <div class="form-group">
                    <label for="officer_name">Accountable Officer:</label>
                    <select wire:model.lazy="officer_name" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($list_officer as $item)
                        <option value="{{$item->id}}">{{$item->firstname}} {{$item->lastname}}
                        </option>
                        @endforeach
                    </select>
                    @error('officer_name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="cashier_name">Acting Cashier/Treasurer:</label>
                    <input wire:model="cashier_name" type="text" class="form-control" id="cashier_name" placeholder="Signatory designation">
                    @error('cashier_name')<span class="text-danger">{{ $message }}</span>@enderror
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

            {{-- <div class="text-center">
                Republic of the Philippines<br>
                Province of QUEZON<br>
                Municipality of LOPEZ<br>
                <strong>OFFICE OF THE MUNICIPAL TREASURER</strong><br>

            </div> --}}
            <div class="mt-2 text-center">
                <h5>REPORT OF COLLECTION AND DEPOSITS</h5>
            </div>
            <div class="mx-4">
                <table class="table table-bordered">
                    <tr>
                        <td width="250px">Fund:</td>
                        <td width="550px">GENERAL</td>
                        <td width="50px">Date:</td>
                        <td>{{ $date_to }}</td>
                    </tr>
                    <tr>
                        <td><i>Name of Accountable Officer:</i></td>
                        <td>{{ $officer_data['firstname'] ?? ''}} {{$officer_data['lastname'] ?? ''}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="mx-4">
                <table class="table-bordered text-center" style="width:100%">
                    <tr>
                      <td colspan="4"class="text-left"><h5>A. COLLECTIONS</h5></td>
                    </tr>
                    <tr class="font-weight-bold">
                      <td rowspan="2" width="200px">TYPE(Form No.)</td>
                      <td colspan="2">Official Receipt/Serial No.</td>
                      <td rowspan="2">Amount</td>
                    </tr>
                    <tr>
                      <td width="200px">From</td>
                      <td width="200px">To</td>
                    </tr>
                    @if (count($collections))
                    @forelse ($collections as $collection)
                        <tr class="text-left">
                            <td >{{ $collection['from'] }}</td>
                            <td>{{ $collection['from'] }}</td>
                            <td>{{ $collection['to'] }}</td>
                            <td class="text-right"><b>{{ $collection['amount'] }}</b></td>
                        </tr>
                    @empty

                    @endforelse
                    @endif

                  </table>
            </div>

            <div class="mx-4">
                <table class="table-bordered text-center" style="width:100%">
                    <tr>
                      <td colspan="10"class="text-left"><h5>C. ACCOUNTABILITY FOR ACCOUNTABLE FORMS</h5></td>
                    </tr>
                    <tr class="font-weight-bold">
                      <td rowspan="3" width="200px">TYPE(Form No.)</td>
                      <td colspan="3">Beginning Balance</td>
                      <td colspan="3">Issued</td>
                      <td colspan="3">Ending Balance</td>
                    </tr>
                    <tr>
                      <td rowspan="2" width="200px">Qty.</td>
                      <td colspan="2">Inclusive Serial No.</td>
                      <td rowspan="2" width="200px">Qty.</td>
                      <td colspan="2">Inclusive Serial No.</td>
                      <td rowspan="2" width="200px">Qty.</td>
                      <td colspan="2">Inclusive Serial No.</td>
                    </tr>
                    <tr>
                      <td  width="200px">FROM</td>
                      <td  width="200px">TO</td>
                      <td  width="200px">FROM</td>
                      <td  width="200px">TO</td>
                      <td  width="200px">FROM</td>
                      <td  width="200px">TO</td>
                    </tr>
                    @if (count($officer_data))

                    @forelse ($officer_data['booklets'] as $booklet)
                        <tr class="text-left">
                            <td>{{ $booklet['form']}}</td>
                            <td>{{ $booklet['begin_qty'] }}</td>
                            <td>{{ $booklet['begin_serial_fr'] }}</td>
                            <td>{{ $booklet['begin_serial_to'] }}</td>
                            <td>{{ $booklet['issued_qty'] }}</td>
                            <td>{{ $booklet['issued_serial_fr'] }}</td>
                            <td>{{ $booklet['issued_serial_to'] }}</td>
                            <td>{{ $booklet['end_qty'] }}</td>
                            <td>{{ $booklet['end_serial_fr'] }}</td>
                            <td>{{ $booklet['end_serial_to'] }}</td>
                        </tr>
                    @empty
                        <tr class="text-left">
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    @endforelse
                    @endif
                  </table>
            </div>

            <div class="mx-4 border mb-4">
                <table class="text-center" style="width:100%">
                    <tr>
                      <td colspan="7"class="text-left"><h5>D. SUMMARY OF COLLECTIONS AND REMITTANCES/DEPOSITS</h5></td>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="4">Beginning Balance</td>
                        <td colspan="3" class="text-left">List of Checks:</td>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="4">Add. Collections</td>
                        <td class="border">Check No.</td>
                        <td class="border">Payee</td>
                        <td class="border">Amount</td>
                    </tr>
                    <tr>
                        <td width="150px"></td>
                        <td class="text-left">Cash:</td>
                        <td class="text-right border-bottom">{{ $cash }}</td>
                        <td width="150px"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-left">Checks:</td>
                        <td class="text-right border-bottom">{{ $checks }}</td>
                        <td></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                    </tr>
                    <tr>
                        <td class="text-left">Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="table-bordered"></td>
                    </tr>
                    <tr>
                        <td colspan="7" class="text-left">Less: Remittance/Deposit to Cashier</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-left">Treasurer/Depository Bank</td>
                        <td class="text-right border-bottom">{{ $cash + $checks }}</td>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-left">Balance</td>
                        <td class="text-right border-bottom">     </td>
                        <td colspan="4"></td>
                    </tr>
                  </table>
            </div>

        </div>
    </div>
</div>
