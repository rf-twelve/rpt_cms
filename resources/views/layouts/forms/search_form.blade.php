<div class="card bg-primary">
    <div class="row p-2">
        <div class="col-lg-4 col-sm-12">
            <label>Search:</label>
            <input wire:model.debounce.500="search" type="search" class="form-control" placeholder="Search...">
        </div>
        <div class="col-lg-2 col-sm-12">
            <label>Per Page:</label>
            <select wire:model="perpage" class="form-control">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="1000">1000</option>
                <option value="80000">All</option>
            </select>
        </div>
        <div class="col-lg-2 col-sm-12">
            <label>Filter By:</label>
            <select wire:model="filterBy" class="form-control">
                <option value="">None</option>
                @foreach ($list_category as $item)
                <option value="{{$item->name}}">{{$item->name}}</option>
                @endforeach

            </select>
        </div>
        <div class="col-lg-2 col-sm-12">
            <label>Sort By:</label>
            <select wire:model="sortBy" class="form-control">
                <option>None</option>
                <option value="last_name">Last Name</option>
                <option value="first_name">First Name</option>
                <option value="mid_name">Middle Name</option>
            </select>
        </div>
        <div class="col-lg-2 col-sm-12">
            <label>Sort Type:</label>
            <select wire:model="sortType" class="form-control">
                <option value="asc">Asc</option>
                <option value="desc">Desc</option>
            </select>
        </div>
    </div>
</div>
