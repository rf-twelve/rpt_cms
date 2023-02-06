<div class="row">
    <div class="col-lg-12">
        <div class="mb-2 input-group" style="width:600px">
            <button wire:click.prevent="addValue()" type="button" class="mx-2 btn btn-primary"><i class="fas fa-plus"></i> Add</button>
            {{-- <select class="custom-select">
                <option>option 1</option>
                <option>option 2</option>
                <option>option 3</option>
                <option>option 4</option>
                <option>option 5</option>
            </select>
            <input type="text" class="ml-2 form-control">
            <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div> --}}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h2 class="card-title">Booklets Inventory</h2>
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
                <table class="table table-hover text-nowrap table-bordered table-sm">
                    <thead>
                        {{-- <tr >
                            <th rowspan="2" style="width:50px">
                                <a wire:click.prevent="newRecord()" href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </th>
                            <th class="text-center bg-warning" colspan="4">BOOKLET</th>
                        </tr> --}}
                        <tr class="text-center">
                            <th rowspan="3" class="pl-2 m-0" style="width:10px"></th>
                            <th rowspan="3">Form</th>
                            <th colspan="3" class="bg-info">Beginning Balance</th>
                            <th colspan="3" class="bg-purple">Issued</th>
                            <th colspan="3" class="bg-indigo">Ending Balance</th>
                            {{-- <th rowspan="3">Amount</th> --}}
                            <th rowspan="3">Teller Name</th>
                        </tr>
                        <tr class="">
                            <th rowspan="2" style="width:6%" class="bg-info">Qty.</th>
                            <th colspan="2" class="bg-info">Inclusive Serial No.</th>
                            <th rowspan="2" style="width:6%" class="bg-purple">Qty.</th>
                            <th colspan="2" class="bg-purple">Inclusive Serial No.</th>
                            <th rowspan="2" style="width:6%" class="bg-indigo">Qty.</th>
                            <th colspan="2" class="bg-indigo">Inclusive Serial No.</th>
                        </tr>
                        <tr class="text-center">
                            <th class="bg-info" style="width:8%">From</th>
                            <th class="bg-info" style="width:8%">To</th>
                            <th class="bg-purple" style="width:8%">From</th>
                            <th class="bg-purple" style="width:8%">To</th>
                            <th class="bg-indigo" style="width:8%">From</th>
                            <th class="bg-indigo" style="width:8%">To</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($showAddValue)
                            <tr>
                                <td class="pl-1">
                                    <a wire:click.prevent="saveNew()" href="#"
                                        class="btn btn-sm btn-primary"><i class="fas fa-check"></i></a>
                                </td>
                                <td>
                                    <select wire:model.defer='addNewData.form' class="form-control" style="width:200px">
                                        <option value="">Please select</option>
                                        @foreach (\App\Models\ListForm::get() as $form)
                                            <option value="{{ $form->name }}">{{ $form->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input wire:model.defer="addNewData.begin_qty" style="width:100%" type="number" class="form-control">
                                </td>
                                <td>
                                    <input wire:model.defer="addNewData.begin_serial_fr" style="width:100%" type="number" class="form-control">
                                </td>
                                <td>
                                    <input wire:model.defer="addNewData.begin_serial_to" style="width:100%" type="number" class="form-control">
                                </td>
                                <td>
                                    <input wire:model.defer="addNewData.issued_qty" style="width:100%" type="number" class="form-control">
                                </td>
                                <td>
                                    <input wire:model.defer="addNewData.issued_serial_fr" style="width:100%" type="number" class="form-control">
                                </td>
                                <td>
                                    <input wire:model.defer="addNewData.issued_serial_to" style="width:100%" type="number" class="form-control">
                                </td>
                                <td>
                                    <input wire:model.defer="addNewData.end_qty" style="width:100%" type="number" class="form-control">
                                </td>
                                <td>
                                    <input wire:model.defer="addNewData.end_serial_fr" style="width:100%" type="number" class="form-control">
                                </td>
                                <td>
                                    <input wire:model.defer="addNewData.end_serial_to" style="width:100%" type="number" class="form-control">
                                </td>
                                <td>
                                    <select wire:model.defer="addNewData.user_id" class="custom-select">
                                        <option value="">Please Select</option>
                                        @foreach (App\Models\User::get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->firstname.' '.$item->lastname }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endif
                        @forelse ($booklets as $index => $item)
                        <tr>
                            <td class="pl-1">
                                @if ($editedIndex !== $index)
                                <a wire:click.prevent="editValue({{$index}})" href="#" class="btn btn-sm btn-warning"><i
                                        class="fas fa-edit"></i></a>
                                @else
                                <a wire:click.prevent="saveValue({{$item['id']}},'{{$index}}')" href="#"
                                    class="btn btn-sm btn-primary"><i class="fas fa-check"></i></a>
                                @endif
                            </td>
                            <td>
                                @if ($editedIndex !== $index)
                                {{$item['form']}}
                                @else
                                <input wire:model.defer="bookletsData.{{$index}}.form" style="width:100px" type="text"
                                    class="form-control">
                                @endif
                            </td>
                            <td>
                                @if ($editedIndex !== $index)
                                {{$item['begin_qty']}}
                                @else
                                <input wire:model.defer="bookletsData.{{$index}}.begin_qty" style="width:100px" type="text"
                                    class="form-control">
                                @endif
                            </td>
                            <td>
                                @if ($editedIndex !== $index)
                                {{$item['begin_serial_fr']}}
                                @else
                                <input wire:model.defer="bookletsData.{{$index}}.begin_serial_fr" style="width:100px" type="text"
                                    class="form-control">
                                @endif
                            </td>
                            <td>
                                @if ($editedIndex !== $index)
                                {{$item['begin_serial_to']}}
                                @else
                                <input wire:model.defer="bookletsData.{{$index}}.begin_serial_to" style="width:100px" type="text"
                                    class="form-control">
                                @endif
                            </td>
                            <td>
                                @if ($editedIndex !== $index)
                                {{$item['issued_qty']}}
                                @else
                                <input wire:model.defer="bookletsData.{{$index}}.issued_qty" style="width:100px" type="text"
                                    class="form-control">
                                @endif
                            </td>
                            <td>
                                @if ($editedIndex !== $index)
                                {{$item['issued_serial_fr']}}
                                @else
                                <input wire:model.defer="bookletsData.{{$index}}.issued_serial_fr" style="width:100px" type="text"
                                    class="form-control">
                                @endif
                            </td>
                            <td>
                                @if ($editedIndex !== $index)
                                {{$item['issued_serial_to']}}
                                @else
                                <input wire:model.defer="bookletsData.{{$index}}.issued_serial_to" style="width:100px" type="text"
                                    class="form-control">
                                @endif
                            </td>
                            <td>
                                @if ($editedIndex !== $index)
                                {{$item['end_qty']}}
                                @else
                                <input wire:model.defer="bookletsData.{{$index}}.end_qty" style="width:100px" type="text"
                                    class="form-control">
                                @endif
                            </td>
                            <td>
                                @if ($editedIndex !== $index)
                                {{$item['end_serial_fr']}}
                                @else
                                <input wire:model.defer="bookletsData.{{$index}}.end_serial_fr" style="width:100px" type="text"
                                    class="form-control">
                                @endif
                            </td>
                            <td>
                                @if ($editedIndex !== $index)
                                {{$item['end_serial_to']}}
                                @else
                                <input wire:model.defer="bookletsData.{{$index}}.end_serial_to" style="width:100px" type="text"
                                    class="form-control">
                                @endif
                            </td>
                            {{-- <td>
                                @if ($editedIndex !== $index)
                                {{$item['amount']}}
                                @else
                                <input wire:model.defer="bookletsData.{{$index}}.amount" style="width:100px" type="text"
                                    class="form-control">
                                @endif
                            </td> --}}
                            <td>
                                @if ($editedIndex !== $index)
                                {{ $item['users']['firstname'].' '.$item['users']['lastname']}}
                                {{-- {{ App\Models\User::findUserByID($item['user_id'])}} --}}
                                @else
                                <select wire:model.defer="bookletsData.{{$index}}.user_id" class="custom-select">
                                    <option value="">Please Select</option>
                                    @foreach (App\Models\User::get() as $item)
                                    <option value="{{ $item->id }}">{{ $item->firstname.' '.$item->lastname }}</option>
                                    @endforeach
                                </select>
                                @endif
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
