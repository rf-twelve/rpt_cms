@extends('layouts.master')

@section('styles')

@endsection

@section('content')
@if ($id)
@livewire($component, ['selectedID' => $id])
@else
@livewire($component)
@endif
@endsection

@section('scripts')


{{-- 6. Settings --}}

<script type="text/javascript">
    // Modal Assessor
        window.addEventListener('accountRegistryOpen', even => {
            $("#modal-account-registry").modal('show');
        })
        window.addEventListener('accountRegistryClose', even => {
            $("#modal-account-registry").modal('hide');
        })
    // Modal Assessor - Account Verification
        window.addEventListener('accountVerifyOpen', even => {
            $("#modal-account-verify").modal('show');
        })
        window.addEventListener('accountVerifyClose', even => {
            $("#modal-account-verify").modal('hide');
        })
    // Modal Assessor - Account View
        window.addEventListener('accountAccountOpen', even => {
            $("#modal-account-view").modal('show');
        })
        window.addEventListener('accountAccountClose', even => {
            $("#modal-account-view").modal('hide');
        })
    // Modal Assessed Value
        window.addEventListener('assessedValueOpen', even => {
            $("#modal-assessed-value").modal('show');
        })
        window.addEventListener('assessedValueClose', even => {
            $("#modal-assessed-value").modal('hide');
        })
    // Modal Record Payment
        window.addEventListener('paymentRecordOpen', even => {
            $("#modal-payment-record").modal('show');
        })
        window.addEventListener('paymentRecordClose', even => {
            $("#modal-payment-record").modal('hide');
        })

    // Modal RPT Registry
        window.addEventListener('rptRegistryOpen', even => {
            $("#modal-rptRegistry").modal('show');
        })
        window.addEventListener('rptRegistryClose', even => {
            $("#modal-rptRegistry").modal('hide');
        })
        window.addEventListener('assessmentRollRegistryOpen', even => {
            $("#modal-assessmentRollRegistry").modal('show');
        })
        window.addEventListener('assessmentRollRegistryClose', even => {
            $("#modal-assessmentRollRegistry").modal('hide');
        })

    // Modal Assessed Value
        window.addEventListener('assessedValueOpen', even => {
            $("#modal-assessed-value").modal('show');
        })
        window.addEventListener('assessedValueClose', even => {
            $("#modal-assessed-value").modal('hide');
        })
    // Modal Payment Record
        // window.addEventListener('paymentOpen', even => {
        //     $("#modal-payment-record").modal('show');
        // })
        // window.addEventListener('paymentClose', even => {
        //     $("#modal-payment-record").modal('hide');
        // })

    // Modal Settings
        window.addEventListener('setBasicOpen', even => {
            $("#modal-settings-basic").modal('show');
        })
        window.addEventListener('setBasicClose', even => {
            $("#modal-settings-basic").modal('hide');
        })
        window.addEventListener('setPenaltyOpen', even => {
            $("#modal-settings-penalty").modal('show');
        })
        window.addEventListener('setPenaltyClose', even => {
            $("#modal-settings-penalty").modal('hide');
        })

    // Modal RPT COLLECTION
        // Payment Record.....
        window.addEventListener('paymentOpen', even => {
            $("#modal-payment").modal('show');
        })
        window.addEventListener('paymentClose', even => {
            $("#modal-payment").modal('hide');
        })


    //! MODAL SETTINGS
        // User List..........
        window.addEventListener('usersListOpen', even => {
            $("#modal-users-list").modal('show');
        })
        window.addEventListener('usersListClose', even => {
            $("#modal-users-list").modal('hide');
        })
        // Roles..........
        window.addEventListener('usersRolesOpen', even => {
            $("#modal-users-roles").modal('show');
        })
        window.addEventListener('usersRolesClose', even => {
            $("#modal-users-roles").modal('hide');
        })
        // Permission.......
        window.addEventListener('usersPermissionsOpen', even => {
            $("#modal-users-permissions").modal('show');
        })
        window.addEventListener('usersPermissionsClose', even => {
            $("#modal-users-permissions").modal('hide');
        })
</script>
@endsection
