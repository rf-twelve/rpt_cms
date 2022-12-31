<div class="card">
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
                        <a wire:click.prevent="newRecord()" href="#" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i>
                        </a>
                    </th>
                    <th rowspan="2">FROM(Year)</th>
                    <th rowspan="2">TO(Year)</th>
                    <th rowspan="2">YEAR TOTAL</th>
                    <th rowspan="2">BASE</th>
                    <th rowspan="2">VALUE</th>
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
                        {{$item['from']}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.from" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedFormulaIndex !== $index)
                        {{$item['to']}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.to" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedFormulaIndex !== $index)
                        {{$item['count']}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.count" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedFormulaIndex !== $index)
                        {{$item['base']}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.base" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedFormulaIndex !== $index)
                        {{$item['value']}}
                        @else
                        <input wire:model.defer="formula_values.{{$index}}.value" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>

                    @if(($item['from'] >= $newAvYear && $item['from'] >= $newAvYear))
                        <td class="bg-primary">{{$item['base'] . '%'}}</td>
                        <td class="bg-primary">{{$item['base'] . '%'}}</td>
                        <td class="bg-primary">{{$item['base'] . '%'}}</td>
                        <td class="bg-primary">{{$item['base'] . '%'}}</td>
                        <td class="bg-primary">{{$item['base'] . '%'}}</td>
                        <td class="bg-primary">{{$item['base'] . '%'}}</td>
                        <td class="bg-primary">{{$item['base'] . '%'}}</td>
                        <td class="bg-primary">{{$item['base'] . '%'}}</td>
                        <td class="bg-primary">{{$item['base'] . '%'}}</td>
                        <td class="bg-primary">{{$item['base'] . '%'}}</td>
                        <td class="bg-primary">{{$item['base'] . '%'}}</td>
                        <td class="bg-primary">{{$item['base'] . '%'}}</td>

                    @elseif(($item['from'] >= ($oldAvYear-2) && $item['from'] <= $oldAvYear))
                        <td class="bg-primary">{{$item['base']+(1*2)-2 .'%'}}</td>
                        <td class="bg-primary">{{$item['base']+(2*2)-2 .'%'}}</td>
                        <td class="bg-primary">{{$item['base']+(3*2)-2 .'%'}}</td>
                        <td class="bg-primary">{{$item['base']+(4*2)-2 .'%'}}</td>
                        <td class="bg-primary">{{$item['base']+(5*2)-2 .'%'}}</td>
                        <td class="bg-primary">{{$item['base']+(6*2)-2 .'%'}}</td>
                        <td class="bg-primary">{{$item['base']+(7*2)-2 .'%'}}</td>
                        <td class="bg-primary">{{($item['base']+(8*2)-2) > 72 ? '72%' : $item['base']+(8*2)-2 .'%' }}</td>
                        <td class="bg-primary">{{($item['base']+(9*2)-2) > 72 ? '72%' : $item['base']+(9*2)-2 .'%' }}</td>
                        <td class="bg-primary">{{($item['base']+(10*2)-2) > 72 ? '72%' : $item['base']+(10*2)-2 .'%' }}</td>
                        <td class="bg-primary">{{($item['base']+(11*2)-2) > 72 ? '72%' : $item['base']+(11*2)-2 .'%' }}</td>
                        <td class="bg-primary">{{($item['base']+(12*2)-2) > 72 ? '72%' : $item['base']+(12*2)-2 .'%' }}</td>

                    @elseif(($item['from'] < $oldAvYear-2 && $item['from'] < $oldAvYear-2))
                        <td class="bg-primary">{{$item['base'] .'%'}}</td>
                        <td class="bg-primary">{{$item['base'] .'%'}}</td>
                        <td class="bg-primary">{{$item['base'] .'%'}}</td>
                        <td class="bg-primary">{{$item['base'] .'%'}}</td>
                        <td class="bg-primary">{{$item['base'] .'%'}}</td>
                        <td class="bg-primary">{{$item['base'] .'%'}}</td>
                        <td class="bg-primary">{{$item['base'] .'%'}}</td>
                        <td class="bg-primary">{{$item['base'] .'%'}}</td>
                        <td class="bg-primary">{{$item['base'] .'%'}}</td>
                        <td class="bg-primary">{{$item['base'] .'%'}}</td>
                        <td class="bg-primary">{{$item['base'] .'%'}}</td>
                        <td class="bg-primary">{{$item['base'] .'%'}}</td>
                    @endif


                    @empty
                    @endforelse
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
