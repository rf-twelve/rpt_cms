<div class="card" x-data="{ addNew: false }">
    <div class="card-header">
        <h2 class="card-title">Formula Table (January - December)</h2>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="p-0 card-body table-responsive">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr class="bg-secondary">
                    <th rowspan="2">
                        <a x-on:click="addNew =! addNew" href="#" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i>
                        </a>
                    </th>
                    <th rowspan="2">FROM(Year)</th>
                    <th rowspan="2">TO(Year)</th>
                    <th rowspan="2">LABEL</th>
                    <th rowspan="2">YEAR NO</th>
                    <th rowspan="2">AV PERCENTAGE</th>
                    <th colspan="12" class="text-center">MONTH</th>
                </tr>
                <tr class="bg-warning">
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>May</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Aug</th>
                    <th>Sep</th>
                    <th>Oct</th>
                    <th>Nov</th>
                    <th>Dec</th>
                </tr>
            </thead>
            <tbody>
                {{-- Show/Hide row to add new Data  --}}
                <tr x-show="addNew">
                    <td>
                        <a wire:click.prevent="saveNew()" href="#" class="btn btn-primary"><i class="fas fa-check"></i></a>
                    </td>
                    <td>
                        <input wire:model.defer="newValues.year_from" placeholder="Year From" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.year_to" placeholder="Year To" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.label" placeholder="Total Year" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.year_no" placeholder="Total Year" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.av_percent" placeholder="Total Year" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.january" placeholder="Enter Value" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.february" placeholder="Enter Value" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.march" placeholder="Enter Value" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.april" placeholder="Enter Value" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.may" placeholder="Enter Value" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.june" placeholder="Enter Value" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.july" placeholder="Enter Value" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.august" placeholder="Enter Value" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.september" placeholder="Enter Value" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.october" placeholder="Enter Value" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.november" placeholder="Enter Value" style="width:100px" type="text" class="form-control">
                    </td>
                    <td>
                        <input wire:model.defer="newValues.december" placeholder="Enter Value" style="width:100px" type="text" class="form-control">
                    </td>
                </tr>

                @forelse ($formula_tables as $index => $item)
                <tr>
                    <td>
                        @if ($editedFormulaIndex !== $index)
                        <a wire:click.prevent="editFormula({{$index}})" href="#" class="btn btn-sm btn-warning"><i
                                class="fas fa-edit"></i></a>
                        @else
                        <a wire:click.prevent="saveFormulaValue({{$item['id']}},'{{$index}}')" href="#"
                            class="btn btn-primary"><i class="fas fa-check"></i></a>
                        @endif
                    </td>
                    <td>
                        @if ($editedFormulaIndex !== $index)
                        {{$item['year_from']}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.year_from" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedFormulaIndex !== $index)
                        {{$item['year_to']}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.year_to" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedFormulaIndex !== $index)
                        {{$item['label']}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.label" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedFormulaIndex !== $index)
                        {{$item['year_no']}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.year_no" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedFormulaIndex !== $index)
                        {{$item['av_percent']}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.av_percent" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>

                    <td class="bg-primary">
                        @if ($editedFormulaIndex !== $index)
                        {{$item['january']*100 . '%'}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.january" style="width:100px" type="text"
                            class="form-control">
                        @endif
                        </td>
                    <td class="bg-primary">
                        @if ($editedFormulaIndex !== $index)
                        {{$item['february']*100 . '%'}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.february" style="width:100px" type="text"
                            class="form-control">
                        @endif
                        </td>
                    <td class="bg-primary">
                        @if ($editedFormulaIndex !== $index)
                        {{$item['march']*100 . '%'}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.march" style="width:100px" type="text"
                            class="form-control">
                        @endif
                        </td>
                    <td class="bg-primary">
                        @if ($editedFormulaIndex !== $index)
                        {{$item['april']*100 . '%'}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.april" style="width:100px" type="text"
                            class="form-control">
                        @endif
                        </td>
                    <td class="bg-primary">
                        @if ($editedFormulaIndex !== $index)
                        {{$item['may']*100 . '%'}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.may" style="width:100px" type="text"
                            class="form-control">
                        @endif
                        </td>
                    <td class="bg-primary">
                        @if ($editedFormulaIndex !== $index)
                        {{$item['june']*100 . '%'}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.june" style="width:100px" type="text"
                            class="form-control">
                        @endif
                        </td>
                    <td class="bg-primary">
                        @if ($editedFormulaIndex !== $index)
                        {{$item['july']*100 . '%'}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.july" style="width:100px" type="text"
                            class="form-control">
                        @endif
                        </td>
                    <td class="bg-primary">
                        @if ($editedFormulaIndex !== $index)
                        {{$item['august']*100 . '%'}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.august" style="width:100px" type="text"
                            class="form-control">
                        @endif
                        </td>
                    <td class="bg-primary">
                        @if ($editedFormulaIndex !== $index)
                        {{$item['september']*100 . '%'}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.september" style="width:100px" type="text"
                            class="form-control">
                        @endif
                        </td>
                    <td class="bg-primary">
                        @if ($editedFormulaIndex !== $index)
                        {{$item['october']*100 . '%'}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.october" style="width:100px" type="text"
                            class="form-control">
                        @endif
                        </td>
                    <td class="bg-primary">
                        @if ($editedFormulaIndex !== $index)
                        {{$item['november']*100 . '%'}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.november" style="width:100px" type="text"
                            class="form-control">
                        @endif
                        </td>
                    <td class="bg-primary">
                        @if ($editedFormulaIndex !== $index)
                        {{$item['december']*100 . '%'}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.december" style="width:100px" type="text"
                            class="form-control">
                        @endif
                        </td>

                    @empty
                    @endforelse
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
