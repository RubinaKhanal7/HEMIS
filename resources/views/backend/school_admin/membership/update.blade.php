@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.membership.partials.action')
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.members.update', $member->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Membership Number and Membership Head -->
                    <div class="row">
                        <!-- Membership Number (Pre-filled) -->
                        <div class="form-group col-md-6">
                            <label for="membershipnumber">Membership Number</label>
                            <input type="text" name="membershipnumber" class="form-control" value="{{ $member->membershipnumber }}" readonly>
                        </div>

                        <!-- Membership Head -->
                        <div class="form-group col-md-6">
                            <label for="memberhead_id">Membership Head</label>
                            <select name="memberhead_id" class="form-control" required>
                                <option value="">Select Membership Head</option>
                                @foreach ($membershipHeads as $membershipHead)
                                    <option value="{{ $membershipHead->id }}" {{ $membershipHead->id == old('memberhead_id', $member->memberhead_id) ? 'selected' : '' }}>
                                        {{ $membershipHead->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('memberhead_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Full Name and Membership Date -->
                    <div class="row">
                        <!-- Full Name -->
                        <div class="form-group col-md-6">
                            <label for="fullname">Full Name</label>
                            <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $member->fullname) }}" required>
                            @error('fullname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Membership Date -->
                        <div class="form-group col-md-6">
                            <label for="membershipdate">Membership Date</label>
                            <input type="date" name="membershipdate" class="form-control" value="{{ old('membershipdate', $member->membershipdate) }}" required>
                            @error('membershipdate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Mobile Number and Email -->
                    <div class="row">
                        <!-- Mobile Number -->
                        <div class="form-group col-md-6">
                            <label for="mobile_number">Mobile Number</label>
                            <input type="text" name="mobile_number" class="form-control" value="{{ old('mobile_number', $member->mobile_number) }}" required>
                            @error('mobile_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $member->email) }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                  
                    <!-- Province/State and District -->
                    <div class="row">
                        <!-- Province/State -->
                        <div class="form-group col-md-6">
                            <label for="state_id">Choose State</label>
                            <select id="state_id" name="state_id" class="form-control state_id" required>
                                <option value="">Choose State</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" {{ old('state_id', $adminStateId) == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- District -->
                        <div class="form-group col-md-6">
                            <label for="district_id">Choose District</label>
                            <select id="district_id" name="district_id" class="form-control district_id" required>
                                <option value="">Choose District</option>
                            </select>
                            @error('district_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Municipality and Ward -->
                    <div class="row">
                        <!-- Municipality -->
                        <div class="form-group col-md-6">
                            <label for="municipality_id">Choose Municipality</label>
                            <select id="municipality_id" name="municipality_id" class="form-control municipality_id" required>
                                <option value="">Choose Municipality</option>
                            </select>
                            @error('municipality_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Ward -->
                        <div class="form-group col-md-6">
                            <label for="ward_id">Choose Ward</label>
                            <select id="ward_id" name="ward_id" class="form-control ward_id" required>
                                <option value="">Choose Ward</option>
                            </select>
                            @error('ward_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tole -->
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="tole">Tole</label>
                            <input type="text" name="tole" class="form-control" value="{{ old('tole', $member->tole) }}" required>
                            @error('tole')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Hidden input fields to store existing location data -->
                    <input type="hidden" name="province" id="province" value="{{ $member->province }}">
                    <input type="hidden" name="district" id="district" value="{{ $member->district }}">
                    <input type="hidden" name="locallevel" id="locallevel" value="{{ $member->locallevel }}">
                    <input type="hidden" name="ward" id="ward" value="{{ $member->ward }}">

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var savedStateId = {{ $member->state_id ?? 'null' }};
        var savedDistrictId = {{ $member->district_id ?? 'null' }};
        var savedMunicipalityId = {{ $member->municipality_id ?? 'null' }};
        var savedWardId = '{{ $member->ward ?? '' }}';
    
    // Initial load of districts based on saved state
    if (savedStateId) {
        loadDistricts(savedStateId, savedDistrictId);
    }

        // Function to load districts
        function loadDistricts(state_id, district_id = null) {
            $.ajax({
                url: '/admin/get-districts/' + state_id,
                type: 'GET',
                success: function(response) {
                    var options = '<option value="">Choose District</option>';
                    response.forEach(function(district) {
                        options += `<option value="${district.id}" ${district_id == district.id ? 'selected' : ''}>${district.name}</option>`;
                    });
                    $('#district_id').html(options);

                    // Update hidden district field for form submission
                    if (district_id) {
                        var districtName = response.find(d => d.id == district_id)?.name;
                        if (districtName) {
                            $('#district').val(districtName);
                        }
                        loadMunicipalities(district_id, preselectedMunicipalityId);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error loading districts:", error);
                    console.log("Response:", xhr.responseText);
                    $('#district_id').html('<option value="">No districts found</option>');
                }
            });
        }

        // Function to load municipalities
        function loadMunicipalities(district_id, municipality_id = null) {
            $.ajax({
                url: '/admin/get-municipalities/' + district_id,
                type: 'GET',
                success: function(response) {
                    var options = '<option value="">Choose Municipality</option>';
                    response.forEach(function(municipality) {
                        options += `<option value="${municipality.id}" ${municipality_id == municipality.id ? 'selected' : ''}>${municipality.name}</option>`;
                    });
                    $('#municipality_id').html(options);

                    // Update hidden municipality field for form submission
                    if (municipality_id) {
                        var municipalityName = response.find(m => m.id == municipality_id)?.name;
                        if (municipalityName) {
                            $('#locallevel').val(municipalityName);
                        }
                        loadWards(municipality_id);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error loading municipalities:", error);
                    console.log("Response:", xhr.responseText);
                    $('#municipality_id').html('<option value="">No municipalities found</option>');
                }
            });
        }

        // Function to load wards
        function loadWards(municipality_id) {
            $.ajax({
                url: '/admin/get-wards/' + municipality_id,
                type: 'GET',
                success: function(response) {
                    var options = '<option value="">Choose Ward</option>';
                    if (Array.isArray(response)) {
                        response.forEach(function(ward) {
                            var selected = ward == '{{ $member->ward }}' ? 'selected' : '';
                            options += `<option value="${ward}" ${selected}>${ward}</option>`;
                        });
                    }
                    $('#ward_id').html(options);
                },
                error: function(xhr, status, error) {
                    console.log("Error loading wards:", error);
                    console.log("Response:", xhr.responseText);
                    $('#ward_id').html('<option value="">No wards found</option>');
                }
            });
        }

        // Event listeners for dropdown changes
        $('#state_id').change(function() {
            var state_id = $(this).val();
            if (state_id) {
                // Update hidden province field for form submission
                var provinceName = $(this).find("option:selected").text();
                $('#province').val(provinceName);
                
                loadDistricts(state_id);
            } else {
                $('#district_id').html('<option value="">Choose District</option>');
                $('#municipality_id').html('<option value="">Choose Municipality</option>');
                $('#ward_id').html('<option value="">Choose Ward</option>');
            }
        });

        $('#district_id').change(function() {
            var district_id = $(this).val();
            if (district_id) {
                // Update hidden district field for form submission
                var districtName = $(this).find("option:selected").text();
                $('#district').val(districtName);
                
                loadMunicipalities(district_id);
            } else {
                $('#municipality_id').html('<option value="">Choose Municipality</option>');
                $('#ward_id').html('<option value="">Choose Ward</option>');
            }
        });

        $('#municipality_id').change(function() {
            var municipality_id = $(this).val();
            if (municipality_id) {
                // Update hidden municipality field for form submission
                var municipalityName = $(this).find("option:selected").text();
                $('#locallevel').val(municipalityName);
                
                loadWards(municipality_id);
            } else {
                $('#ward_id').html('<option value="">Choose Ward</option>');
            }
        });

        $('#ward_id').change(function() {
            // Update hidden ward field for form submission
            var wardValue = $(this).val();
            $('#ward').val(wardValue);
        });
    });
</script>
@endsection