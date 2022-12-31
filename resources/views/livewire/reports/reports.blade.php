<div>
    <div class="row">
        {{-- RPT DELINQUENCY --}}
        <div class="col-md-3 col-sm-6 col-12">
            <div class="shadow info-box">
                <span class="info-box-icon bg-warning"><i class="far fa-file-alt"></i></span>
                <div class="info-box-content">
                <span class="info-box-text"><strong>RPT Delinquency</strong></span>

                <div class="mb-3 input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"  style="width: 100px">From</span>
                    </div>
                    <input wire:model='delinquent_year_from' class="form-control" type="date"/>
                </div>
                <div class="mb-3 input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"  style="width: 100px">To</span>
                    </div>
                    <input wire:model='delinquent_year_to' class="form-control" type="date"/>
                </div>

                <div class="input-group input-group-sm">
                    <button wire:click="open_rpt_deliquency()" class="btn btn-info btn-flat" type="button">
                        Generate <i class="far fa-arrow-alt-circle-right"></i></button>
                </div>
                </div>
            </div>
        </div>

        {{-- ASSESSMENT ROLL --}}
        <div class="col-md-3 col-sm-6 col-12">
            <div class="shadow info-box">
                <span class="info-box-icon bg-warning"><i class="far fa-file-alt"></i></span>
                <div class="info-box-content">
                <span class="info-box-text"><strong>Assessment Roll Summary</strong></span>
                <div class="input-group input-group-sm">
                    {{-- <input wire:model='rpt_delinquent_year' class="form-control" type="date"/> --}}
                    <span class="input-group-append">
                    <button wire:click="open_assessment_roll()" class="btn btn-info btn-flat" type="button">
                        Generate <i class="far fa-arrow-alt-circle-right"></i></button>
                    </span>
                </div>
                </div>
            </div>
        </div>

        {{-- COLLECTIVE PER BARANGAY --}}
        <div class="col-md-3 col-sm-6 col-12">
            <div class="shadow info-box">
                <span class="info-box-icon bg-warning"><i class="far fa-file-alt"></i></span>
                <div class="info-box-content">
                <span class="info-box-text"><strong>Barangay Collectibles</strong></span>
                <div class="input-group input-group-sm">
                    <input wire:model='brgy_collectible_year' class="form-control" type="date"/>
                    <span class="input-group-append">
                    <button wire:click="open_rpt_collective()" class="btn btn-info btn-flat" type="button">
                        Generate <i class="far fa-arrow-alt-circle-right"></i></button>
                    </span>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
