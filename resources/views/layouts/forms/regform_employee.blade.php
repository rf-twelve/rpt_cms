<form wire:ignore.self>
    <div class="card-header bg-primary mb-1">
        Registration Form
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <table class="table table-bordered table-sm">
                <tbody>

                    <tr>
                        <td class="bg-primary">Category:</td>
                        <td>
                            <select wire:model.defer="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($list_category as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @error('category_id') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Employee ID --}}
                    <tr>
                        <td class="bg-primary">Employee ID:</td>
                        <td>
                            <input wire:model.defer="employee_id" type="text" class="form-control"
                                placeholder="Enter ID Number">
                        </td>
                    </tr>
                    @error('employee_id') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Last Name --}}
                    <tr>
                        <td class="bg-primary">Last Name:</td>
                        <td>
                            <input wire:model.defer="last_name" type="text" class="form-control"
                                placeholder="Enter Last name">
                        </td>
                    </tr>
                    @error('last_name') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- First Name --}}
                    <tr>
                        <td class="bg-primary">First Name:</td>
                        <td>
                            <input wire:model.defer="first_name" type="text" class="form-control"
                                placeholder="Enter First name">
                        </td>
                    </tr>
                    @error('first_name') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Middle Name --}}
                    <tr>
                        <td class="bg-primary">Middle Name:</td>
                        <td>
                            <input wire:model.defer="middle_name" type="text" class="form-control"
                                placeholder="Enter Middle name">
                        </td>
                    </tr>
                    @error('middle_name') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Suffix Name --}}
                    <tr>
                        <td class="bg-primary">Suffix:</td>
                        <td>
                            <select wire:model.defer="suffix" class="form-control">
                                <option value="">Select Suffix</option>
                                <option value="N/A">N/A</option>
                                <option value="I">II</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                                <option value="JR">JR</option>
                                <option value="SR">SR</option>
                            </select>
                        </td>
                    </tr>
                    @error('suffix') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Birthdate --}}
                    <tr>
                        <td class="bg-primary">Birthdate:</td>
                        <td>
                            <input wire:model.defer="birthdate" type="date" class="form-control" value="2021-01-01">
                        </td>
                    </tr>
                    @error('birthdate') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Contact Number--}}
                    <tr>
                        <td class="bg-primary">Contact #:</td>
                        <td>
                            <input wire:model.defer="contact_no" type="text" class="form-control"
                                placeholder="Enter Contact #">
                        </td>
                    </tr>
                    @error('contact_no') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Sex --}}
                    <tr>
                        <td class="bg-primary">Sex:</td>
                        <td>
                            <select wire:model.defer="sex" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                            </select>
                        </td>
                    </tr>
                    @error('sex') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                </tbody>
            </table>
        </div>
        {{-- End of first container --}}
        <div class="col-lg-6 col-sm-12">
            <table class="table table-bordered table-sm">
                <tbody>


                    {{-- Civil Status --}}
                    <tr>
                        <td class="bg-primary">Civil Status:</td>
                        <td>
                            <select wire:model.defer="civil_status" class="form-control">
                                <option value="">Select Civil Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widow/Widower">Widow/Widower</option>
                                <option value="Separated/Annulled">Separated/Annulled</option>
                                <option value="Living_with_Partner">Living with Partner</option>
                            </select>
                        </td>
                    </tr>
                    @error('civil_status') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Designation --}}
                    <tr>
                        <td class="bg-primary">Designation:</td>
                        <td>
                            <input wire:model.defer="designation" type="text" class="form-control"
                                placeholder="Enter Designation">
                        </td>
                    </tr>
                    @error('designation') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Region --}}
                    <tr>
                        <td class="bg-primary">Region:</td>
                        <td>
                            <select wire:model.defer="region_id" class="form-control">
                                <option value="">Select Region</option>
                                @foreach ($list_region as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    @error('region_id') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Province --}}
                    <tr>
                        <td class="bg-primary">Province:</td>
                        <td>
                            <select wire:model.defer="province_id" class="form-control">
                                <option value="">Select Province</option>
                                @foreach ($list_province as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @error('province_id') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Municipality --}}
                    <tr>
                        <td class="bg-primary">Municipality:</td>
                        <td>
                            <select wire:model.defer="municity_id" class="form-control">
                                <option value="">Select Municipality</option>
                                @foreach ($list_municity as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @error('municity_id') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Barangay --}}
                    <tr>
                        <td class="bg-primary">Barangay:</td>
                        <td>
                            <select wire:model.defer="barangay_id" class="form-control">
                                <option value="">Select Barangay</option>
                                @foreach ($list_barangay as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @error('barangay_id') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- House Number --}}
                    <tr>
                        <td class="bg-primary">House Number:</td>
                        <td>
                            <input wire:model.defer="house_number" type="text" class="form-control"
                                placeholder="Enter House No.">
                        </td>
                    </tr>
                    @error('house_number') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Street Name --}}
                    <tr>
                        <td class="bg-primary">Street Name:</td>
                        <td>
                            <input wire:model.defer="street_name" type="text" class="form-control"
                                placeholder="Enter Street name">
                        </td>
                    </tr>
                    @error('street_name') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Street Name --}}
                    <tr>
                        <td class="bg-primary">Photo:
                        </td>
                        <td>

                            <div class="input-group">
                                <div class="custom-file">
                                    <input wire:model.defer="e_photo" type="file" class="custom-file-input"
                                        id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">{{$photo_label}}</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        @if (isset($e_photo))
                                        {{-- <img src="{{asset('img/notif/user-upload.png')}}" style="max-width:23px;">
                                        --}}
                                        <img src="{{$e_photo->temporaryUrl()}}" style="max-width:23px;max-height:23px;">
                                        @else
                                        <img src="{{asset('img/notif/user-no-upload.png')}}" style="max-width:23px;">
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @error('e_photo') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                </tbody>
            </table>
        </div>
        {{-- <img src="{{asset('storage/img/employees/IMG1638515639.jpeg')}}" style="max-width:23px;"> --}}
        {{-- End of Second container --}}
    </div>
    <!-- /End of Row -->
    <div class="card-footer">
        @if ($updateOn == true)
        <button wire:click.prevent="updateRecord({{ $personID }})" type="button" class="btn btn-primary">Update
            Records</button>
        @else
        <button wire:click.prevent="saveRecord()" type="button" class="btn btn-primary">Save Records</button>
        @endif
        <button x-on:click="openForm = !openForm" type="button" class="btn btn-danger float-right">Close</button>
    </div>
</form>
