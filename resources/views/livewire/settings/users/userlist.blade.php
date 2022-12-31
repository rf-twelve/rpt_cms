<div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">USER REGISTRY</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" wire:click="closeRecord()"><i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            {{-- RPT ACCOUNT CONTENT --}}
            <div class="form-group">
                <label>Firstname :</label>
                <input wire:model.defer='id' type="text" hidden>
                <input wire:model.defer='firstname' type="text" class="form-control @error('firstname') is-invalid @enderror" placeholder="Enter firstname">
                @error('firstname')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Lastname :</label>
                <input wire:model.defer='lastname' type="text" class="form-control @error('lastname') is-invalid @enderror" placeholder="Enter lastname">
                @error('lastname')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Username :</label>
                <input wire:model.defer='username' type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Enter username">
                @error('username')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Password :</label>
                <input wire:model.defer='password' type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password">
                @error('password')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Roles :</label>
                <select wire:model.defer='roles'class="form-control @error('roles') is-invalid @enderror">
                    <option value="">Select roles</option>
                    @foreach ($rolesArray as $item)
                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                    @endforeach
                </select>
                @error('roles')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Permission :</label>
                <select wire:model.defer='permissions'class="form-control @error('permissions') is-invalid @enderror" multiple>
                    <option value="">Select permissions</option>
                    @foreach ($permissionsArray as $item)
                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                    @endforeach
                </select>
                @error('permissions')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <button wire:click.prevent="saveRecord()" class="btn btn-sm btn-primary float-right ml-2"  type="button">
                <i class="fas fa-check"></i> Save
            </button>
            <button wire:click.prevent="closeRecord()" class="btn btn-sm btn-danger float-right"  type="button">
                <i class="fas fa-times"></i> Close
            </button>

        </div>
    </div>
</div>
