<div x-data="{ taxtable_fields: @entangle('taxtable_fields'), }">
    <div class="row">
        <div class="col-12 text-center">
            <button type="button" wire:click.defer="newRecord()" class="btn btn-app">
                <i class="fas fa-user-plus"></i> Add User
            </button>
            <button type="button" wire:click.defer="openRoles()" class="btn btn-app">
                <i class="fas fa-user-tie"></i> Roles
            </button>
            <button type="button" wire:click.defer="openPermissions()" class="btn btn-app">
                <i class="fas fa-user-cog"></i> Permissions
            </button>
            <a class="btn btn-app">
                <span class="badge bg-warning text-md">{{$usertables->count();}}</span>
                <i class="fas fa-users"></i> Users
            </a>

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User's Table</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input wire:model.debounce.500="search" type="text" class="form-control float-right"
                        placeholder="Search Keyword...">
                    <div class="input-group-append">
                        <span class="btn btn-default"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0 table-responsive">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr class="bg-secondary">
                        <th class="no-print text-center m-0" style="padding-left: 6px;padding-right: 6px;">
                            <a wire:click.prevent="newRecord()" href="#" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i>
                            </a>
                        </th>
                        <th>PHOTO</th>
                        <th>FIRST NAME</th>
                        <th>LAST NAME</th>
                        <th>USERNAME</th>
                        <th>ROLES</th>
                        <th style="width:100px; word-wrap: break-word;">PERMISIONS</th>
                        <th>IS ACTIVE?</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usertables as $item)
                    <tr>
                        <td class="no-print text-center m-0" style="padding-left: 6px;padding-right: 6px;">
                            <button class="btn btn-sm btn-primary" data-toggle="dropdown">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div style=" border: transparent; width: 10px;" class="dropdown-menu p-0">
                                <a wire:click="editRecord({{$item->id}})" href="#" class="dropdown-item text-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="#" onclick="confirm('Delete this record?') || event.stopImmediatePropagation()"
                                    wire:click="deleteSingleRecord({{$item->id}})" class="dropdown-item text-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </td>
                        <td>
                            <img alt="Avatar" style="width: 35px" class="img-circle elevation-2"
                                src="{{url('img/user.png')}}">
                        </td>
                        <td>{{$item->firstname}}</td>
                        <td>{{$item->lastname}}</td>
                        <td>{{$item->username}}</td>
                        <td>
                            {{count($item->roles) ? $item->roles[0]->name : null}}
                        </td>
                        <td>
                           {{-- {{ dump($item->permissions);}} --}}
                            @forelse ($item->permissions as $permission)
                            <span style="background-color:{{'#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);}}" class="badge text-sm text-light">{{$permission->name}}</span>
                            @empty
                            @endforelse
                        </td>
                        <td>
                            @if ($item->active == 1)
                            <span class="badge bg-primary text-sm">Yes</span>
                            @else
                            <span class="badge bg-secondary text-sm">No</span>
                            @endif
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
        {{$usertables->links()}}
        <!-- /.card-body -->
    </div>
</div>
