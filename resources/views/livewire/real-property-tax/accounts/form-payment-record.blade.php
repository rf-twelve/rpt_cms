<div>
    <h5 class="pl-2"><i class="fas fa-info-circle"></i><i> Payment Information</i></h5>
    <hr>


    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Date :</label>
        <div class="col-sm-7">
            <input wire:model.debounce.500ms='pay_date' type="date"
            class="form-control @error('pay_date') is-invalid @enderror">
            @error('pay_date')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">O.R. / Serial No. :</label>
        <div class="col-sm-7">
            <input wire:model.debounce.500ms='pay_serial_no' type="text"
            class="form-control @error('pay_serial_no') is-invalid @enderror">
            @error('pay_serial_no')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Teller:</label>
        <div class="col-sm-7">
            <select wire:model.debounce.500ms='pay_teller'
                class="form-control @error('pay_teller') is-invalid @enderror">
                <option value="">--Select--</option>
                @foreach (App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->firstname }}</option>
                @endforeach
            </select>
            @error('pay_teller')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Payee:</label>
        <div class="col-sm-7">
            <input wire:model.debounce.500ms='pay_payee' type="text"
            class="form-control @error('pay_payee') is-invalid @enderror">
            @error('pay_payee')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Fund:</label>
        <div class="col-sm-7">
            <select wire:model.debounce.500ms='pay_fund'
                class="form-control @error('pay_fund') is-invalid @enderror">
                <option value="">--Select--</option>
                <option value="general">General Fund</option>
            </select>
            @error('pay_fund')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Payment Type:</label>
        <div class="col-sm-7">
            <select wire:model.debounce.500ms='pay_type'
                class="form-control @error('pay_type') is-invalid @enderror">
                <option value="">--Select--</option>
                <option value="cash">Cash</option>
                <option value="checks">Checks</option>
            </select>
            @error('pay_type')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>

    <h5 class="pl-2"><i class="fas fa-info-circle"></i><i> Payment Period</i></h5>
    <hr>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">From :</label>
        <div class="col-sm-7">
            <div class="row">
                <div class="col-6">
                    <input wire:model.debounce.500ms='pay_year_from' type="text"
                        class="form-control @error('pay_year_from') is-invalid @enderror">
                </div>
                <div class="col-6">
                    <select wire:model.debounce.500ms='pay_quarter_from'
                        class="form-control @error('pay_quarter_from') is-invalid @enderror">
                        <option value="">--Select--</option>
                        <option value="0.25">Q1</option>
                        <option value="0.50">Q2</option>
                        <option value="0.75">Q3</option>
                        <option value="1">Q4</option>
                    </select>
                </div>
            </div>
            @error('pay_year_from')<span class="text-danger">{{ $message }}</span>@enderror
            @error('pay_quarter_from')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">To :</label>
        <div class="col-sm-7">
            <div class="row">
                <div class="col-6">
                    <input wire:model.debounce.500ms='pay_year_to' type="text"
                        class="form-control @error('pay_year_to') is-invalid @enderror">
                </div>
                <div class="col-6">
                    <select wire:model.debounce.500ms='pay_quarter_to'
                        class="form-control @error('pay_quarter_to') is-invalid @enderror">
                        <option value="">--Select--</option>
                        <option value="0.25">Q1</option>
                        <option value="0.50">Q2</option>
                        <option value="0.75">Q3</option>
                        <option value="1">Q4</option>
                    </select>
                </div>
            </div>
            @error('pay_year_to')<span class="text-danger">{{ $message }}</span>@enderror
            @error('pay_quarter_to')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
<hr>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Basic :</label>
        <div class="col-sm-7">
            <input wire:model.debounce.500ms='pay_basic' type="text"
            class="form-control @error('pay_basic') is-invalid @enderror">
            @error('pay_basic')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Sef :</label>
        <div class="col-sm-7">
            <input wire:model.debounce.500ms='pay_sef' type="text"
            class="form-control @error('pay_sef') is-invalid @enderror">
            @error('pay_sef')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Penalty :</label>
        <div class="col-sm-7">
            <input wire:model.debounce.500ms='pay_penalty' type="text"
            class="form-control @error('pay_penalty') is-invalid @enderror">
            @error('pay_penalty')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Cash :</label>
        <div class="col-sm-7">
            <input wire:model.debounce.500ms='pay_cash' type="text"
            class="form-control @error('pay_cash') is-invalid @enderror">
            @error('pay_cash')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Amount Due :</label>
        <div class="text-right col-sm-7">
            <h5>P {{ $pay_amount_due_display ?? '0.00' }}</h5>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Cash :</label>
        <div class="text-right col-sm-7">
            <u><h5>- P {{ $pay_cash_display ?? '0.00' }}</h5></u>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Change :</label>
        <div class="text-right col-sm-7">
            <h3>P {{ $pay_change_display ?? '0.00' }}</h3>
        </div>
    </div>
    <hr>



    <div class="form-group">
        <label>Directory :</label>
        <textarea wire:model.defer='pay_directory' class="form-control @error('pay_directory') is-invalid @enderror"
            rows="3" placeholder="Payment directory..."></textarea>
        @error('pay_directory')<span class="text-danger">{{ $message }}</span>@enderror
    </div>
    <div class="form-group">
        <label>Remarks :</label>
        <textarea wire:model.defer='pay_remarks' class="form-control @error('pay_remarks') is-invalid @enderror"
        rows="3" placeholder="Payment remarks..."></textarea>
        @error('pay_remarks')<span class="text-danger">{{ $message }}</span>@enderror
    </div>

    <div class="float-right">
        <button data-dismiss="modal" type="button" class="m-2 btn btn-danger" style="width:100px">
            <i class="fas fa-times"></i> Close</button>
        <button wire:click.prevent="savePaymentRecord()" type="button" class="m-2 btn btn-primary" style="width:100px">
            <i class="fas fa-check"></i> Save</button>
    </div>
</div>
