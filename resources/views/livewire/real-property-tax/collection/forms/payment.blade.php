<div class="card-body table-responsive">
    <div class="row">
        <div class="col-6 form-group">
            <label>FUND :</label>
            <select wire:model.defer='pay_fund' class="form-control @error('pay_fund') is-invalid @enderror">
                <option value="">Select Type of Fund</option>
                <option value="general">General Fund</option>
            </select>
            @error('pay_fund')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-6 form-group">
            <label>MODE OF PAYMENT :</label>
            <select wire:model.defer='pay_type' class="form-control @error('pay_type') is-invalid @enderror">
                <option value="">Select Type of Payment</option>
                <option value="cash">Cash</option>
                <option value="checks">Checks</option>
            </select>
            @error('pay_type')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-6 form-group">
            <label>TELLER NAME :</label>
            <label class="form-control">{{$pay_teller}}</label>
        </div>
        <div class="col-6 form-group">
            <label>Treasurer :</label>
            <input wire:model="pay_treasurer" type="text" class="form-control" />
        </div>
        <div class="col-6 form-group">
            <label>Deputy :</label>
            <input wire:model="pay_deputy" type="text" class="form-control" />
        </div>

        <div class="col-6 form-group">
            <label>DATE OF PAYMENT :</label>
            <input wire:model.defer="pay_date" type="date" class="form-control @error('pay_date') is-invalid @enderror">
            @error('pay_date')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-6 form-group">
            <label>O.R./ Serial No. :</label>
            <label class="form-control">{{ $pay_serial_no }}</label>
            @error('pay_serial_no')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-6 form-group">
            <label>AMOUNT DUE :</label>
            <label class="form-control">
                @if (strpos($pay_amount_due, ',') !== false)
                {{'P '.$pay_amount_due}}
                @else
                {{'P '.number_format($pay_amount_due, 2, '.', ',')}}
                @endif
            </label>
        </div>
        <div class="col-12 form-group">
            <label>AMOUNT IN WORDS :</label>
            <textarea wire:model.defer="pay_amount_words" class="form-control" rows="2"
                placeholder="Enter amount in words..."></textarea>
        </div>
        <div class="col-12 form-group">
            <label>NAME OF PAYEE :</label>
            <input wire:model.defer="pay_payee" type="text" class="form-control @error('pay_payee') is-invalid @enderror">
            @error('pay_payee')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-12 form-group">
            <label>DIRECTORY :</label>
            <textarea wire:model.defer="pay_directory" class="form-control" rows="2"
                placeholder="Enter directory..."></textarea>
        </div>
        <div class="col-12 form-group">
            <label>REMARKS :</label>
            <textarea wire:model.defer="pay_remarks" class="form-control" rows="2"
                placeholder="Enter remarks..."></textarea>
        </div>
        <div class="col-6 form-group">
            <label>CASH :</label>
            <input wire:model.debounce.500ms="pay_cash" type="number" class="form-control @error('pay_cash') is-invalid @enderror" placeholder="0.00">
            @error('pay_cash')<span class="text-danger">{{ $message }}</span>@enderror

        </div>
        <div class="col-6 form-group">
            <label>CHANGE :</label>
            <label class="form-control">
                @if ($pay_cash)
                    @if (strpos($pay_change, ',') !== false)
                    {{'P '.$pay_change}}
                    @else
                    {{'P '.number_format($pay_change, 2, '.', ',')}}
                    @endif
                @else
                    P 0.00
                @endif
            </label>
        </div>
    </div>

    <div class="pt-2 text-right">
        <button wire:click.prevent="close_payment()" class="btn btn-danger">
            <i class="fas fa-times"></i> Close
        </button>
        <button wire:click.prevent="save_payment()" class="btn btn-secondary">
            <i class="fas fa-check"></i> Save
        </button>
        <a href="#" target="_blank" wire:click.prevent="print_payment()" class="btn btn-primary">
            <i class="fas fa-print"></i> Save & Print
        </a>
    </div>
</div>
