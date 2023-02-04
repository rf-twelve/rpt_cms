<div x-data="{ taxtable_fields: @entangle('taxtable_fields'), }">
    <div class="row">
        <div class="col-sm-12 col-lg-6">
            @livewire('settings.form.funds')
        </div>

        <div class="col-sm-12 col-lg-6">
            {{-- @livewire('settings.address.province') --}}
        </div>

        <div class="col-sm-12 col-lg-6">
            {{-- @livewire('settings.address.municity') --}}
        </div>

        <div class="col-sm-12 col-lg-6">
            {{-- @livewire('settings.address.barangay') --}}
        </div>
    </div>
</div>
