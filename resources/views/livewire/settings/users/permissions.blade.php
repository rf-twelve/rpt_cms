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
                    <h4 class="m-0">User Permission</h4>
                </th>
            </tr>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissionArray as $index => $permissionValue)

            <tr>
                <td style="width: 50%">
                    <input type="number" name="permissionArray[{{$index}}][id]" wire:model.defer="permissionArray.{{$index}}.id" hidden/>
                    <input type="text" name="permissionArray[{{$index}}][name]" class="form-control"
                        wire:model.defer="permissionArray.{{$index}}.name" placeholder="Name" />
                </td>
                <td style="width: 50%">
                    <input type="text" name="permissionArray[{{$index}}][slug]" class="form-control"
                        wire:model.defer="permissionArray.{{$index}}.slug" placeholder="Slug" />
                </td>
                <td>
                    <button wire:click.prevent="removePermission({{$index}})" class="btn btn-danger btn-sm"
                        type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4">
                    <button wire:click.prevent="addPermission()" class="btn btn-sm btn-warning">
                        <i class="fas fa-plus"></i> Add
                    </button>
                    <button wire:click.prevent="savePermission()" class="btn btn-sm btn-primary float-right ml-2"  type="button">
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
