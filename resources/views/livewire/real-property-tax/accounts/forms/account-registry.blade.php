<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">RPT ACCOUNT REGISTRY</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" wire:click="closeRecord()"><i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <h4 class="pl-2 text-center bg-secondary">ACCOUNT INFORMATION</h4>
        {{-- RPT ACCOUNT CONTENT --}}
        <div class="form-group">
            <label>PIN :</label>
            <input wire:model.defer='uid' type="text" hidden>
            <input wire:model.defer='rpt_pin' type="text" class="form-control @error('rpt_pin') is-invalid @enderror" placeholder="Enter PIN">
            @error('rpt_pin')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>KIND : <span class="text-danger">({{$rpt_kind}})</span></label>
            <select wire:model.defer='rpt_kind' class="form-control @error('rpt_kind') is-invalid @enderror">
                <option value="">Please Select Kind</option>
                <option value="L">Land</option>
                <option value="B">Building</option>
                <option value="I">Improvements</option>
                <option value="M">Machinery</option>
            </select>
            @error('rpt_kind')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>CLASSIFICATION : <span class="text-danger">({{$rpt_class}})</span></label>
            <select wire:model.defer='rpt_class' class="form-control @error('rpt_class') is-invalid @enderror">
                <option value="">Please Select Class</option>
                <option value="RESIDENTIAL">RESIDENTIAL</option>
                <option value="AGRICULTURAL">AGRICULTURAL</option>
                <option value="COMMERCIAL">COMMERCIAL</option>
                <option value="INDUSTRIAL">INDUSTRIAL</option>
                <option value="MINERAL">MINERAL</option>
                <option value="TIMBERLAND">TIMBERLAND</option>
                <option value="SPECIAL">SPECIAL</option>
            </select>
            @error('rpt_class')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>TD/ARP NUMBER :</label>
            <input wire:model.defer='rpt_td_no' type="text" class="form-control @error('rpt_td_no') is-invalid @enderror" placeholder="Enter TD Number">
            @error('rpt_td_no')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        {{-- <div class="form-group">
            <label>ARP NUMBER :</label>
            <input wire:model.defer='rpt_arp_no' type="text" class="form-control @error('rpt_arp_no') is-invalid @enderror" placeholder="Enter ARP Number">
            @error('rpt_arp_no')<span class="text-danger">{{ $message }}</span>@enderror
        </div> --}}
        <div class="form-group">
            <label>Owner's Name :</label>
            <textarea wire:model.defer='ro_name' class="form-control @error('ro_name') is-invalid @enderror" rows="3"
                placeholder="Name of Owners"></textarea>
                @error('ro_name')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Owner's Address :</label>
            <textarea wire:model.defer='ro_address' class="form-control @error('ro_address') is-invalid @enderror" rows="3"
                placeholder="Owner's address"></textarea>
                @error('ro_address')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        {{-- ASSESSED VALUE CONTENT --}}
        <h4 class="pl-2 text-center bg-secondary">PROPERTY LOCATION</h4>
        <div class="form-group">
            <label>Lot/Blk No.:</label>
            <input wire:model.defer='lp_lot_blk_no' type="text" class="form-control @error('lp_lot_blk_no') is-invalid @enderror" placeholder="Enter Lot/Blk Number">
            @error('lp_lot_blk_no')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Street Name :</label>
            <input wire:model.defer='lp_street' type="text" class="form-control @error('lp_street') is-invalid @enderror" placeholder="Enter Street">
            @error('lp_street')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Barangay :</label>
            <select wire:model.defer='lp_brgy' class="form-control @error('lp_brgy') is-invalid @enderror">
                <option value="">Please Select Barangay</option>
                @foreach ($list_barangay as $item)
                <option value="{{$item['index']}}">{{$item['name']}}</option>
                @endforeach
            </select>
            @error('lp_brgy')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Municipality/City :</label>
            <select wire:model.defer='lp_municity' class="form-control @error('lp_municity') is-invalid @enderror">
                <option value="">Please Select Municipality</option>
                @foreach ($list_municity as $item)
                <option value="{{$item['index']}}">{{$item['name']}}</option>
                @endforeach
            </select>
            @error('lp_municity')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Province :</label>
            <select wire:model.defer='lp_province' class="form-control @error('lp_province') is-invalid @enderror">
                <option value="">Please Select Municipality</option>
                @foreach ($list_province as $item)
                <option value="{{$item['index']}}">{{$item['name']}}</option>
                @endforeach
            </select>
            @error('lp_province')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        {{-- ASSESSED VALUE CONTENT --}}

        <table class="table">
            <thead>
                <tr class="text-center bg-secondary">
                    <th colspan="4" class="p-0"><h4 class="m-0">ASSESSED VALUE</h4></th>
                </tr>
                <tr>
                    <th>From(Year)</th>
                    <th>To(Year)</th>
                    <th>Assessed Value</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($avDataArray as $index => $assessedValue)
                <tr>
                    <td style="width: 30%">
                    <input type="number" name="avDataArray[{{$index}}][id]" wire:model.defer="avDataArray.{{$index}}.id" hidden/>
                        <input type="number" name="avDataArray[{{$index}}][av_year_from]" class="form-control"
                            wire:model.debounce.500ms="avDataArray.{{$index}}.av_year_from" placeholder="Enter Year"/>
                    </td>
                    <td style="width: 30%">
                        <input type="number" name="avDataArray[{{$index}}][av_year_to]" class="form-control"
                            wire:model.debounce.500ms="avDataArray.{{$index}}.av_year_to"  placeholder="Enter Year"/>
                    </td>
                    <td style="width: 30%">
                        <input type="number" name="avDataArray[{{$index}}][av_value]" class="form-control"
                            wire:model.debounce.500ms="avDataArray.{{$index}}.av_value" />
                    </td>
                    <td>

                        <button wire:click.prevent="removeAssessedValue({{$index}})" class="btn btn-danger btn-sm" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4">
                        <button class="btn btn-sm btn-primary" wire:click.prevent="addAssessedValue()">
                            <i class="fas fa-plus"></i> Add AV
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        @if ($display_pr)

        {{-- TAX COLLECTED --}}
        <h4 class="pl-2 text-center bg-secondary">TAX COLLECTED</h4>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">BASIC :</label>
            <div class="col-sm-9">
                <input wire:model.debounce.500ms='rtdp_tc_basic' type="number" class="form-control  @error('rtdp_tc_basic') is-invalid @enderror" placeholder="Enter Tax Collected Basic">
                @error('rtdp_tc_basic')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">SEF :</label>
            <div class="col-sm-9">
                <input wire:model.debounce.500ms='rtdp_tc_sef' type="number" class="form-control  @error('rtdp_tc_sef') is-invalid @enderror" placeholder="Enter Tax Collected Sef">
                @error('rtdp_tc_sef')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">PENALTY :</label>
            <div class="col-sm-9">
                <input wire:model.debounce.500ms='rtdp_tc_penalty' type="number" class="form-control  @error('rtdp_tc_penalty') is-invalid @enderror" placeholder="Enter Tax Collected Penalty">
                @error('rtdp_tc_penalty')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">TOTAL :</label>
            <div class="col-sm-9">
                <button type="button" class="text-left form-control">{{$rtdp_tc_total}}</button>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Payment Date :</label>
            <div class="col-sm-8">
                <input wire:model.debounce.500ms='rtdp_payment_date' type="date" class="form-control  @error('rtdp_payment_date') is-invalid @enderror">
                @error('rtdp_payment_date')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">O.R. Number :</label>
            <div class="col-sm-8">
                <input wire:model.debounce.500ms='rtdp_or_no' type="text" class="form-control  @error('rtdp_or_no') is-invalid @enderror">
                @error('rtdp_or_no')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
        <table class="table" id="products_table">
            <thead>
                <tr class="text-center bg-secondary">
                    <th colspan="4" class="p-0">
                        <h4 class="m-0">PAYMENT PERIOD COVERED</h4>
                    </th>
                </tr>
                <tr class="text-danger">
                    <th colspan="4" class="p-0">
                        <h5 class="m-2">Note! (Payment Covered: {{$rtdp_payment_covered}})</h5>
                    </th>
                </tr>
                <tr>
                    <th>Year</th>
                    <th>Quarter</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 50%">
                        <input wire:model.debounce.500ms='rtdp_payment_covered_fr' type="number" placeholder="From year"
                            class="form-control  @error('rtdp_payment_covered_fr') is-invalid @enderror">
                        @error('rtdp_payment_covered_fr')<span class="text-danger">{{ $message }}</span>@enderror
                    </td>
                    <td style="width: 50%">
                        <select wire:model.defer='rtdp_payment_quarter_fr' class="form-control @error('rtdp_payment_quarter_fr') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="0">N/A</option>
                            <option value="0.25">Q1</option>
                            <option value="0.50">Q2</option>
                            <option value="0.75">Q3</option>
                            <option value="1">Q4</option>
                        </select>
                        @error('rtdp_payment_quarter')<span class="text-danger">{{ $message }}</span>@enderror
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%">
                        <input wire:model.debounce.500ms='rtdp_payment_covered_to' type="number" placeholder="To year"
                            class="form-control  @error('rtdp_payment_covered_to') is-invalid @enderror">
                        @error('rtdp_payment_covered_to')<span class="text-danger">{{ $message }}</span>@enderror
                    </td>
                    <td style="width: 50%">
                        <select wire:model.defer='rtdp_payment_quarter_to' class="form-control @error('rtdp_payment_quarter_to') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="0">N/A</option>
                            <option value="0.25">Q1</option>
                            <option value="0.50">Q2</option>
                            <option value="0.75">Q3</option>
                            <option value="1">Q4</option>
                        </select>
                        @error('rtdp_payment_quarter')<span class="text-danger">{{ $message }}</span>@enderror
                    </td>

                </tr>
            </tbody>
        </table>
        <hr>
        <div class="form-group">
            <label>Directory :</label>
            <textarea wire:model.debounce.500ms='rtdp_directory' class="form-control  @error('rtdp_directory') is-invalid @enderror" rows="3" placeholder="Payment remarks"></textarea>
            @error('rtdp_directory')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Remarks :</label>
            <textarea wire:model.debounce.500ms='rtdp_remarks' class="form-control  @error('rtdp_remarks') is-invalid @enderror" rows="3" placeholder="Payment remarks"></textarea>
            @error('rtdp_remarks')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Payment Start :</label>
            <input wire:model.debounce.500ms='rtdp_payment_start' class="form-control  @error('rtdp_payment_start') is-invalid @enderror" placeholder="Year payment started" />
            @error('rtdp_payment_start')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        @else
        <i class="fas fa-info-circle"></i><label> Payment Record not Found...</label>
        @endif
        <div class="m-0 text-center">
            <button wire:click.prevent="saveRecord()" type="button" class="px-4 mt-0 mb-2 btn btn-primary">Save Record</button>
        </div>
    </div>
</div>

