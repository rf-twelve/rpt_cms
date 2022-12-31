<div x-data="{ input_fields: @entangle('input_fields'), }">
    <div class="card">
        <div class="card-header bg-primary">
            <h2 class="card-title card-sm">PROVINCE</h2>
        </div>
        @if ($errors->any())
        <div class="text-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="card-body p-0 table-responsive" style="height: 250px;">
            <table class="table table-hover text-nowrap table-sm table-striped">
                <thead>
                    <tr class="bg-secondary">
                        <th class="py-1 px-2">
                            <a wire:click.defer="newRecord()" href="#" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i>
                            </a>
                        </th>
                        <th class="py-1 px-2">INDEX</th>
                        <th class="py-1 px-2">NAME</th>
                    </tr>
                </thead>
                <tbody>
                    <tr x-show.transition.duration.200ms="input_fields">
                        <?php $count = count($data_tables)?>
                        <td>
                            <a wire:click.prevent="saveRecord()" href="#" class="btn btn-sm btn-primary"><i
                                    class="fas fa-check"></i></a>
                        </td>
                        <td>
                            <input wire:model.defer="new_index"
                            style="width:200px; text-transform:uppercase" type="text" class="form-control">
                        </td>
                        <td>
                            <input wire:model.defer="new_name"
                            style="width:200px; text-transform:uppercase" type="text" class="form-control">
                        </td>
                    </tr>
                    @forelse ($data_tables as $index => $item)
                    <tr>
                        <td class="text-center m-0" style="padding-left: 6px;padding-right: 6px; width: 10px;">
                            @if ($data_index !== $index)
                            <a wire:click.prevent="editRecord({{$index}})" href="#" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i></a>
                            @else
                            <a wire:click.prevent="updateRecord({{$item['id']}},'{{$index}}')" href="#"
                                class="btn btn-sm btn-primary"><i class="fas fa-check"></i></a>
                            @endif
                        </td>
                        <td>
                            @if ($data_index !== $index)
                            {{$item['index']}}
                            @else
                            <input wire:model.defer="data_values.{{$index}}.index"
                            style="width:200px; text-transform:uppercase" type="text"
                                class="form-control">
                            @endif
                        </td>
                        <td>
                            @if ($data_index !== $index)
                            {{$item['name']}}
                            <div class="float-right">
                                <a wire:click.prevent="editRecord({{$index}})"
                                    onclick="confirm('Delete this record?') || event.stopImmediatePropagation()"
                                    wire:click="deleteSingleRecord({{$item['id']}})" href="#">
                                    <i class="fas fa-times text-danger"></i></a>
                            </div>
                            @else
                            <input wire:model.defer="data_values.{{$index}}.name"
                            style="width:200px; text-transform:uppercase" type="text"
                                class="form-control">
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center">
                        <td colspan="3" class="text-primary"><i class="fas fa-info-circle"></i> No Records</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>
