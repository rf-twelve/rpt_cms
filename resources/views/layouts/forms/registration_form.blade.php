<form wire:ignore.self>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <table class="table table-bordered table-sm">
                <tbody>
                    <tr>
                        <td class="bg-primary">Category:</td>
                        <td>
                            <select wire:model.defer="category" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($list_category as $item)
                                <option value="{{$item->cat_name}}">{{$item->cat_name}} : {{$item->cat_description}}
                                </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @error('category') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Category ID Number --}}
                    <tr>
                        <td class="bg-primary">UNIQUE ID #:</td>
                        <td>
                            <input wire:model.defer="cat_id_no" type="text" class="form-control"
                                placeholder="Enter ID Number">
                        </td>
                    </tr>
                    @error('cat_id_no') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- PWD ID Number --}}
                    <tr>
                        <td class="bg-primary">PWD ID:</td>
                        <td>
                            <input wire:model.defer="pwd_id" type="text" class="form-control"
                                placeholder="Enter PWD ID">
                        </td>
                    </tr>
                    @error('pwd_id') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror

                    {{-- Philhealt ID Number --}}
                    <tr>
                        <td class="bg-primary">Philhealth ID:</td>
                        <td>
                            <input wire:model.defer="phealth_id" type="text" class="form-control"
                                placeholder=" Enter PhilHealth ID">
                        </td>
                    </tr>
                    @error('phealth_id') <tr>
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
                            <input wire:model.defer="mid_name" type="text" class="form-control"
                                placeholder="Enter Middle name">
                        </td>
                    </tr>
                    @error('mid_name') <tr>
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
                    {{-- Street Name --}}
                    <tr>
                        <td class="bg-primary">Street Name:</td>
                        <td>
                            <input wire:model.defer="res_bhs" type="text" class="form-control"
                                placeholder="Enter Street name">
                        </td>
                    </tr>
                    @error('res_bhs') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Region --}}
                    <tr>
                        <td class="bg-primary">Region:</td>
                        <td>
                            <select wire:model.defer="res_region" class="form-control">
                                <option value="">Select Region</option>
                                @foreach ($list_region as $item)
                                <option value="{{$item->reg_name}}">{{$item->reg_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @error('res_region') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Province --}}
                    <tr>
                        <td class="bg-primary">Province:</td>
                        <td>
                            <select wire:model.defer="res_province" class="form-control">
                                <option value="">Select Province</option>
                                @foreach ($list_province as $item)
                                <option value="{{$item->prov_code.$item->prov_name}}">{{$item->prov_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @error('res_province') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Municipality --}}
                    <tr>
                        <td class="bg-primary">Municipality:</td>
                        <td>
                            <select wire:model.defer="res_municipality" class="form-control">
                                <option value="">Select Municipality</option>
                                @foreach ($list_municity as $item)
                                <option value="{{$item->muni_code.$item->muni_name}}">{{$item->muni_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @error('res_municipality') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Barangay --}}
                    <tr>
                        <td class="bg-primary">Barangay:</td>
                        <td>
                            <select wire:model.defer="res_barangay" class="form-control">
                                <option value="">Select Barangay</option>
                                @foreach ($list_barangay as $item)
                                <option value="{{$item->brgy_name}}">{{$item->brgy_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @error('res_barangay') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                </tbody>
            </table>
        </div>
        {{-- End of first container --}}
        <div class="col-lg-6 col-sm-12">
            <table class="table table-bordered table-sm">
                <tbody>
                    {{-- Sex --}}
                    <tr>
                        <td class="bg-primary">Sex:</td>
                        <td>
                            <select wire:model.defer="sex" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="01_Female">Female</option>
                                <option value="02_Male">Male</option>
                            </select>
                        </td>
                    </tr>
                    @error('sex') <tr>
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
                    {{-- Age --}}
                    <tr>
                        <td class="bg-primary">Age:</td>
                        <td>
                            <input wire:model.defer="age" type="number" class="form-control">
                        </td>
                    </tr>
                    @error('age') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Civil Status --}}
                    <tr>
                        <td class="bg-primary">Civil Status:</td>
                        <td>
                            <select wire:model.defer="civil_status" class="form-control">
                                <option value="">Select Civil Status</option>
                                <option value="01_Single">Single</option>
                                <option value="02_Married">Married</option>
                                <option value="03_Widow/Widower">Widow/Widower</option>
                                <option value="04_Separated/Annulled">Separated/Annulled</option>
                                <option value="05_Living_with_Partner">Living with Partner</option>
                            </select>
                        </td>
                    </tr>
                    @error('civil_status') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Employment Status --}}
                    <tr>
                        <td class="bg-primary">Employment Status:</td>
                        <td>
                            <select wire:model.defer="employ_status" class="form-control">
                                <option value="">Select Employment Status</option>
                                <option value="01_Government_Employed">Government Employed</option>
                                <option value="02_Private_Employed">Private Employed</option>
                                <option value="03_Self_employed">Self Employed</option>
                                <option value="04_Private_practitioner">Private Practitioner</option>
                                <option value="05_Others">Others</option>
                            </select>
                        </td>
                    </tr>
                    @error('employ_status') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Directly interact with covid patient --}}
                    <tr>
                        <td class="bg-primary">Interaction w/ COVID patient:</td>
                        <td>
                            <select wire:model.defer="interact_w_covid" class="form-control">
                                <option value="01_Yes">Yes</option>
                                <option value="02_No">No</option>
                            </select>
                        </td>
                    </tr>
                    @error('interact_w_covid') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Profession --}}
                    <tr>
                        <td class="bg-primary">Profession:</td>
                        <td>
                            <input wire:model.defer="profession" type="text" class="form-control"
                                placeholder="Enter Profession">
                        </td>
                    </tr>
                    @error('profession') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Employer Name --}}
                    <tr>
                        <td class="bg-primary">Employer Name:</td>
                        <td>
                            <input wire:model.defer="emp_name" type="text" class="form-control"
                                placeholder="Enter Employer Name">
                        </td>
                    </tr>
                    @error('emp_name') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Employer Province --}}
                    <tr>
                        <td class="bg-primary">Employer Province:</td>
                        <td>
                            <input wire:model.defer="emp_province" type="text" class="form-control"
                                placeholder="Enter Employer Province">
                        </td>
                    </tr>
                    @error('emp_province') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Employer Address --}}
                    <tr>
                        <td class="bg-primary">Employer Address:</td>
                        <td>
                            <input wire:model.defer="emp_address" type="text" class="form-control"
                                placeholder="Enter Employer Address">
                        </td>
                    </tr>
                    @error('emp_address') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Employer Contact --}}
                    <tr>
                        <td class="bg-primary">Employer Contact #:</td>
                        <td>
                            <input wire:model.defer="emp_contact_no" type="text" class="form-control"
                                placeholder="Enter Employer Contact #">
                        </td>
                    </tr>
                    @error('emp_contact_no') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Consent --}}
                    <tr>
                        <td class="bg-primary">Consent:</td>
                        <td>
                            <select wire:model.defer="consent" class="form-control">
                                <option value="01_Yes">Yes</option>
                                <option value="02_No">No</option>
                            </select>
                        </td>
                    </tr>
                    @error('consent') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                    {{-- Reason for Refusal --}}
                    <tr>
                        <td class="bg-primary">Reason for Refusal:</td>
                        <td>
                            <select wire:model.defer="reason" class="form-control">
                                <option value="">Select Reason</option>
                                <option value="N/A">N/A</option>
                                <option value="I do not think this vaccine is safe">I do not think this vaccine is safe
                                </option>
                                <option value="I do not think this vaccine is effective">I do not think this vaccine is
                                    effective</option>
                                <option value="I do not trust a vaccine that has come from another country">I do not
                                    trust a vaccine that has come from another country</option>
                                <option value="I have religious beliefs that do not allow me to be vaccinated">I have
                                    religious beliefs that do not allow me to be vaccinated</option>
                                <option value="Others">Others</option>
                            </select>
                        </td>
                    </tr>
                    @error('reason') <tr>
                        <td><span class="error text-danger">{{ 'Above field is Required!' }}</span></td>
                    </tr> @enderror
                </tbody>
            </table>
        </div>
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
