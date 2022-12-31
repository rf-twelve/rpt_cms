<div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <table class="table">
        <thead>
            <tr class="bg-secondary text-center">
                <th colspan="4" class="p-0">
                    <h4 class="m-0">ASSESSED VALUE</h4>
                </th>
            </tr>
            <tr>
                <th>From(Year)</th>
                <th>To(Year)</th>
                <th>Assessed Value</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assessedValues as $index => $assessedValue)
            <tr>
                <td style="width: 30%">
                    <input type="number" name="assessedValues[{{$index}}][id]" wire:model.defer="assessedValues.{{$index}}.id" hidden/>
                    <input type="number" name="assessedValues[{{$index}}][av_year_from]" class="form-control"
                        wire:model.defer="assessedValues.{{$index}}.av_year_from" placeholder="Enter Year" />
                </td>
                <td style="width: 30%">
                    <input type="number" name="assessedValues[{{$index}}][av_year_to]" class="form-control"
                        wire:model.defer="assessedValues.{{$index}}.av_year_to" placeholder="Enter Year" />
                </td>
                <td style="width: 30%">
                    <input type="number" name="assessedValues[{{$index}}][av_value]" class="form-control"
                        wire:model.defer="assessedValues.{{$index}}.av_value" />
                </td>
                <td>
                    <button wire:click.prevent="removeAssessedValue({{$index}})" class="btn btn-danger btn-sm"
                        type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4">
                    <button wire:click.prevent="addAssessedValue()" class="btn btn-sm btn-warning">
                        <i class="fas fa-plus"></i> Add
                    </button>
                    <button wire:click.prevent="saveAssessedValue()" class="btn btn-sm btn-primary float-right ml-2"  type="button">
                        <i class="fas fa-check"></i> Save
                    </button>
                    <button class="btn btn-sm btn-danger float-right" data-dismiss="modal" type="button">
                        <i class="fas fa-times"></i> Close
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
