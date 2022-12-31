<div>
    <div class="row">
        <div class="col-12">
            @livewire('settings.users.accounts')
        </div>
    </div>
    <!-- The Modal -->
    <div wire:ignore.self class="modal" id="modal-users-list">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body p-0">
                    <livewire:settings.users.userlist />
                </div>

            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal" id="modal-users-roles">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body p-0">
                    <livewire:settings.users.roles />
                </div>

            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal" id="modal-users-permissions">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body p-0">
                    <livewire:settings.users.permissions />
                </div>

            </div>
        </div>
    </div>
</div>
