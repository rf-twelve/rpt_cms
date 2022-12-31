<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">ASSESSMENT ROLL REGISTRY</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" wire:click="closeRecord()"><i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        {{-- RPT ACCOUNT CONTENT --}}
        <div class="form-group">
            <label>TD/ARP No. :</label>
            <input wire:model.defer='account_id' type="text" hidden>
            <input wire:model.defer='rpt_td_arp' type="text" class="form-control @error('rpt_td_arp') is-invalid @enderror" placeholder="Enter TD/ARP No.">
            @error('rpt_td_arp')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>PIN :</label>
            <input wire:model.defer='rpt_pin' type="text" class="form-control @error('rpt_pin') is-invalid @enderror" placeholder="Enter PIN">
            @error('rpt_pin')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

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

        <div class="form-group">
            <label>Lot/Blk No.:</label>
            <input wire:model.defer='lp_lot_blk_no' type="text" class="form-control @error('lp_lot_blk_no') is-invalid @enderror" placeholder="Enter Lot/Blk Number">
            @error('lp_lot_blk_no')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Barangay Code:</label>
            <select wire:model.defer='lp_brgy' class="form-control @error('lp_brgy') is-invalid @enderror">
                <option value="">-- Select Barangay --</option>
                @foreach ($list_barangay as $item)
                <option value="{{$item['index']}}">{{$item['name']}}</option>
                @endforeach
            </select>
            @error('lp_brgy')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Municipality/City Code:</label>
            <select wire:model.defer='lp_municity' class="form-control @error('lp_municity') is-invalid @enderror">
                <option value="">-- Select Municipality --</option>
                @foreach ($list_municity as $item)
                <option value="{{$item['index']}}">{{$item['name']}}</option>
                @endforeach
            </select>
            @error('lp_municity')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Province Code:</label>
            <select wire:model.defer='lp_province' class="form-control @error('lp_province') is-invalid @enderror">
                <option value="">-- Select Province --</option>
                @foreach ($list_province as $item)
                <option value="{{$item['index']}}">{{$item['name']}}</option>
                @endforeach
            </select>
            @error('lp_province')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>KIND : <span class="text-danger">({{$rpt_kind}})</span></label>
            <select wire:model.defer='rpt_kind' class="form-control @error('rpt_pin') is-invalid @enderror">
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
            <select wire:model.defer='rpt_class' class="form-control @error('rpt_pin') is-invalid @enderror">
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

        {{-- ASSESSED VALUE CONTENT --}}
        <div class="form-group">
            <label>ASSESSED VALUE :</label>
            <input wire:model.defer='av_value' type="number" class="form-control @error('av_value') is-invalid @enderror" placeholder="Enter New Assessed Value">
            @error('av_value')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>AV YEAR :</label>
            <input wire:model.defer='av_year' type="number" class="form-control @error('av_year') is-invalid @enderror" placeholder="Enter Assessed Value Year">
            @error('av_year')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>PREVIOUS TD/ARP No. :</label>
            <input wire:model.defer='td_arp_no_prev' type="text" class="form-control @error('td_arp_no_prev') is-invalid @enderror" placeholder="Enter Previous TD/ARP">
            @error('td_arp_no_prev')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>PREVIOUS ASSESSED VALUE :</label>
            <input wire:model.defer='av_value_prev' type="number" class="form-control @error('av_value_prev') is-invalid @enderror" placeholder="Enter Old Assessed Value">
            @error('av_value_prev')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Remarks :</label>
            <textarea wire:model.debounce.500ms='rtdp_remarks' class="form-control  @error('rtdp_remarks') is-invalid @enderror" rows="3" placeholder="Remarks"></textarea>
            @error('rtdp_remarks')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="text-center m-0">
            <button wire:click.prevent="saveRecord()" type="button" class="btn btn-primary mt-0 px-4 mb-2">Save Record</button>
        </div>
    </div>
</div>

