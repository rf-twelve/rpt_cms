<nav class="navbar navbar-expand navbar-primary navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

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
</nav>

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
        {{-- <div class="col-lg-2 col-sm-12">
            <label>Filter By:</label>
            <select wire:model="byCategory" class="form-control">
                <option>None</option>
                @foreach ($cat_list as $item)
                <option value="{{$item->id}}">"{{$item->name}}"</option>
        @endforeach

        </select>
    </div> --}}
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
