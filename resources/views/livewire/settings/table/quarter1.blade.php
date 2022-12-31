<div class="card">
    <div class="card-header">
        <h2 class="card-title">Quarter 1 (January - March)</h2>
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
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr class="bg-secondary">
                    <th>
                        <a wire:click.prevent="newRecord()" href="#" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i>
                        </a>
                    </th>
                    <th>BRACKET CODE</th>
                    <th>FROM(Year)</th>
                    <th>TO(Year)</th>
                    <th>LABEL</th>
                    <th>JANUARY</th>
                    <th>FEBRUARY</th>
                    <th>MARCH</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($quarter1_tables as $index => $item)
                <tr>
                    <td>
                        @if ($editedQ1index !== $index)
                        <a wire:click.prevent="editQ1Value({{$index}})" href="#" class="btn btn-sm btn-warning"><i
                                class="fas fa-edit"></i></a>
                        @else
                        <a wire:click.prevent="saveQ1Value({{$item['id']}},'{{$index}}')" href="#"
                            class="btn btn-primary"><i class="fas fa-check"></i></a>
                        @endif
                    </td>
                    <td>
                        @if ($editedQ1index !== $index)
                        {{$item['bracket_code']}}
                        @else
                        <input wire:model.defer="quarter1_values.{{$index}}.bracket_code" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedQ1index !== $index)
                        {{$item['year_from']}}
                        @else
                        <input wire:model.defer="quarter1_values.{{$index}}.year_from" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedQ1index !== $index)
                        {{$item['year_to']}}
                        @else
                        <input wire:model.defer="quarter1_values.{{$index}}.year_to" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedQ1index !== $index)
                        {{$item['label']}}
                        @else
                        <input wire:model.defer="quarter1_values.{{$index}}.label" style="width:100px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedQ1index !== $index)
                        {{$item['january']}}
                        @else
                        <input wire:model.defer="quarter1_values.{{$index}}.january" style="width:50px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedQ1index !== $index)
                        {{$item['february']}}
                        @else
                        <input wire:model.defer="quarter1_values.{{$index}}.february" style="width:50px" type="text"
                            class="form-control">
                        @endif
                    </td>
                    <td>
                        @if ($editedQ1index !== $index)
                        {{$item['march']}}
                        @else
                        <input wire:model.defer="quarter1_values.{{$index}}.march" style="width:50px" type="text"
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
