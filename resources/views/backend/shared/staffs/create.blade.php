@extends('backend.layouts.master')


<!-- Main content -->
@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.shared.staffs.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="">
                        <div class="">
                            <form id="regForm" method="POST" action="{{ route('admin.staffs.store') }}" enctype="multipart/form-data">
                                @csrf
                                <!-- This indicates the steps of the form: -->
                                <div class="d-flex justify-content-center gap-2">
                                    <span class="step">Personal Information</span>
                                    <span class="step">Address & Academic Information</span>
                                    <span class="step">Job & Financial Information</span>
                                </div>
                            
                                <!-- Tab 1: Personal Information -->
                                <div class="tab">
                                    <div class="hr-line-dashed"></div>
                                    <h5>Personal Information</h5>
                                    <div class="hr-line-dashed"></div>
                            
                                    <div class="row">
                                        <!-- Name in English -->
                                        <div class="col-md-4 mb-3">
                                            <label for="first_name_english">First Name (English)<span class="must">*</span></label>
                                            <input type="text" name="first_name_english" value="{{ old('first_name_english') }}" class="form-control" required>
                                            @error('first_name_english')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="middle_name_english">Middle Name (English)</label>
                                            <input type="text" name="middle_name_english" value="{{ old('middle_name_english') }}" class="form-control">
                                            @error('middle_name_english')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="last_name_english">Last Name (English)<span class="must">*</span></label>
                                            <input type="text" name="last_name_english" value="{{ old('last_name_english') }}" class="form-control" required>
                                            @error('last_name_english')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                            
                                        <!-- Name in Nepali -->
                                        <div class="col-md-4 mb-3">
                                            <label for="first_name_nepali">First Name (Nepali)<span class="must">*</span></label>
                                            <input type="text" name="first_name_nepali" value="{{ old('first_name_nepali') }}" class="form-control" required>
                                            @error('first_name_nepali')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="middle_name_nepali">Middle Name (Nepali)</label>
                                            <input type="text" name="middle_name_nepali" value="{{ old('middle_name_nepali') }}" class="form-control">
                                            @error('middle_name_nepali')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="last_name_nepali">Last Name (Nepali)<span class="must">*</span></label>
                                            <input type="text" name="last_name_nepali" value="{{ old('last_name_nepali') }}" class="form-control" required>
                                            @error('last_name_nepali')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                            
                                        <!-- Contact and Personal Details -->
                                        <div class="col-md-4 mb-3">
                                            <label for="mobile_number">Mobile Number<span class="must">*</span></label>
                                            <input type="text" name="mobile_number" value="{{ old('mobile_number') }}" class="form-control" required>
                                            @error('mobile_number')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                
                                        <div class="col-md-4 mb-3">
                                            <label for="date_of_birth">Date of Birth<span class="must">*</span></label>
                                            <input id="nepali-datepicker" name="date_of_birth" type="text" class="form-control" value="{{ old('date_of_birth') }}" required />
                                            @error('date_of_birth')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                            
                                        <!-- Gender, Caste, Ethnicity -->
                                        <div class="col-md-4 mb-3">
                                            <label for="gender">Gender<span class="must">*</span></label><br>
                                            <label for="gender_male" class="l-radio">
                                                <input type="radio" name="gender" value="male" id="gender_male" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                                <span>Male</span>
                                            </label>
                                            <label for="gender_female" class="l-radio">
                                                <input type="radio" name="gender" value="female" id="gender_female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                                <span>Female</span>
                                            </label>
                                            <label for="gender_other" class="l-radio">
                                                <input type="radio" name="gender" value="other" id="gender_other" {{ old('gender') == 'other' ? 'checked' : '' }}>
                                                <span>Other</span>
                                            </label>
                                            @error('gender')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="caste">Caste</label>
                                            <input type="text" name="caste" value="{{ old('caste') }}" class="form-control">
                                            @error('caste')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="ethnicity">Ethnicity<span class="must">*</span></label>
                                            <select name="ethnicity" class="form-control" required>
                                                <option value="">Select Ethnicity</option>
                                                <option value="Dalit" {{ old('ethnicity') == 'Dalit' ? 'selected' : '' }}>Dalit</option>
                                                <option value="Janajati" {{ old('ethnicity') == 'Janajati' ? 'selected' : '' }}>Janajati</option>
                                                <option value="Madhesi" {{ old('ethnicity') == 'Madhesi' ? 'selected' : '' }}>Madhesi</option>
                                                <option value="Muslim" {{ old('ethnicity') == 'Muslim' ? 'selected' : '' }}>Muslim</option>
                                                <option value="Tharu" {{ old('ethnicity') == 'Tharu' ? 'selected' : '' }}>Tharu</option>
                                                <option value="Brahmin" {{ old('ethnicity') == 'Brahmin' ? 'selected' : '' }}>Brahmin</option>
                                                <option value="Chhetri" {{ old('ethnicity') == 'Chhetri' ? 'selected' : '' }}>Chhetri</option>
                                            </select>
                                            @error('ethnicity')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                            
                                        <!-- EDJ and Disability -->
                                        <div class="col-md-4 mb-3">
                                            <label for="edj">EDJ (Economically Disadvantaged Jati)</label><br>
                                            <label for="edj_yes" class="l-radio">
                                                <input type="radio" name="edj" value="1" id="edj_yes" {{ old('edj') == '1' ? 'checked' : '' }}>
                                                <span>Yes</span>
                                            </label>
                                            <label for="edj_no" class="l-radio">
                                                <input type="radio" name="edj" value="0" id="edj_no" {{ old('edj') == '0' ? 'checked' : '' }}>
                                                <span>No</span>
                                            </label>
                                            @error('edj')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="disability_status">Disability Status</label><br>
                                            <label for="disability_status_yes" class="l-radio">
                                                <input type="radio" name="disability_status" value="1" id="disability_status_yes" {{ old('disability_status') == '1' ? 'checked' : '' }}>
                                                <span>Yes</span>
                                            </label>
                                            <label for="disability_status_no" class="l-radio">
                                                <input type="radio" name="disability_status" value="0" id="disability_status_no" {{ old('disability_status') == '0' ? 'checked' : '' }}>
                                                <span>No</span>
                                            </label>
                                            @error('disability_status')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                            
                                        <!-- ID Documents -->
                                        <div class="col-md-4 mb-3">
                                            <label for="citizenship_id">Citizenship ID<span class="must">*</span></label>
                                            <input type="text" name="citizenship_id" value="{{ old('citizenship_id') }}" class="form-control" required>
                                            @error('citizenship_id')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="national_id">National ID</label>
                                            <input type="text" name="national_id" value="{{ old('national_id') }}" class="form-control">
                                            @error('national_id')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                            
                                        <!-- Spouse Information -->
                                        <div class="col-md-4 mb-3 spouse-info" style="display: none;">
                                            <label for="spouse_name">Spouse Name</label>
                                            <input type="text" name="spouse_name" value="{{ old('spouse_name') }}" class="form-control">
                                            @error('spouse_name')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3 spouse-info" style="display: none;">
                                            <label for="spouse_occupation">Spouse Occupation</label>
                                            <input type="text" name="spouse_occupation" value="{{ old('spouse_occupation') }}" class="form-control">
                                            @error('spouse_occupation')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <div class="hr-line-dashed mt-4"></div>
                                    <h5>Identity Documents</h5>
                                    <div class="hr-line-dashed"></div>
                                   
                                    <div class="row">
                                        <!-- Photo Upload -->
                                        <div class="col-md-4 mb-3">
                                            <label for="photo">Photo</label>
                                            <input type="file" name="photo" class="form-control" id="imageFile">
                                            <div id="previewWrapper" class="mt-2 hidden">
                                                <img id="croppedImagePreview" height="150"><br>
                                                <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                                <button class="btn btn-danger btn-sm mt-2" type="button" id="removeCroppedImage">Remove</button>
                                            </div>
                                            @error('photo')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                       
                                        <!-- Citizenship Documents -->
                                        <div class="col-md-4 mb-3">
                                            <label for="citizenship_front">Citizenship Front</label>
                                            <input type="file" name="citizenship_front" class="form-control" id="citizenship_front" accept="image/*" onchange="previewImage(this, 'frontPreview')">
                                            @error('citizenship_front')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                            <img id="frontPreview" src="#" alt="Preview" class="mt-2 d-none" width="150">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="citizenship_back">Citizenship Back</label>
                                            <input type="file" name="citizenship_back" class="form-control" id="citizenship_back" accept="image/*" onchange="previewImage(this, 'backPreview')">
                                            @error('citizenship_back')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                            <img id="backPreview" src="#" alt="Preview" class="mt-2 d-none" width="150">
                                        </div>

                                            <script>
                                            function previewImage(input, previewId) {
                                                const file = input.files[0];
                                                const preview = document.getElementById(previewId);

                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = function (e) {
                                                        preview.src = e.target.result;
                                                        preview.classList.remove("d-none"); // Show the image preview
                                                    };
                                                    reader.readAsDataURL(file);
                                                } else {
                                                    preview.src = "#";
                                                    preview.classList.add("d-none"); // Hide if no file selected
                                                }
                                            }
                                            </script>

                                    </div>
                                </div>
                            
                                <!-- Tab 2: Address & Academic Information -->
                                <div class="tab">
                                    <!-- Permanent Address -->
                                    <div class="hr-line-dashed mt-4"></div>
                                    <h5 class="">Student's Permanent Address:</h5>
                                   
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-md-12 col-lg-12 d-flex justify-content-around">
                                   
                                        <div class="col-md-6 col-lg-6 col-sm-6 pt-4 pb-4 d-flex gap-3">
                                            <div class="">
                                                <label for="state_id">Choose State <span class="text-danger">*</span></label>
                                                <div class="select">
                                                    <select id="state_id" name="permanent_province" class="state_id" required>
                                                        <option disabled value="">Choose State</option>
                                                        @foreach ($states as $state)
                                                            <option value="{{ $state->id }}"
                                                                {{ $adminStateId == $state->id ? 'selected' : '' }}>
                                                                {{ $state->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('state_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="">
                                                <label for="district_id">Choose District <span class="text-danger">*</span></label>
                                                <div class="select">
                                                    <select id="district_id" name="permanent_district" class="district_id" required>
                                                        <option value="{{ $adminDistrictId }}" selected>
                                                            {{ Auth::user()->district->name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                @error('district_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                   
                                        <div class="col-md-6 col-lg-6 pt-4 pb-4 d-flex gap-3">
                                            <div>
                                                <label for="municipality_id">Choose Municipality <span class="text-danger">*</span></label>
                                                <div class="select">
                                                    <select id="municipality_id" name="permanent_local_level" class="municipality_id" required>
                                                        <option value="{{ $adminMunicipalityId }}" selected>
                                                            {{ Auth::user()->municipality->name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                @error('municipality_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                   
                                            <div class="">
                                                <label for="ward_id">Choose Ward <span class="text-danger">*</span></label>
                                                <div class="select">
                                                    <select id="ward_id" name="permanent_ward_no" class="ward_id" required>
                                                        <option value="{{ old('ward_id') }}">Choose Ward</option>
                                                    </select>
                                                </div>
                                                @error('ward_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-12 col-lg-12 d-flex gap-2 justify-content-between">
                                        <div class="col-lg-4 col-sm-4">
                                            <label for="tole">Tole:</label>
                                            <input type="text" name="tole" value="{{ old('tole') }}" class="form-control" id="tole" placeholder="Enter Tole">
                                            @error('tole')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="house_number">House Number:</label>
                                            <input type="text" name="house_number" value="{{ old('house_number') }}" class="form-control" id="house_number" placeholder="Enter House Number">
                                            @error('house_number')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                   
                                    <div class="hr-line-dashed mt-4"></div>
                                    <h5 class="">Student's Temporary Address:</h5>
                                   
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-md-12 col-lg-12 d-flex justify-content-around">
                                        <div class="col-md-6 col-lg-6 col-sm-6 pt-4 pb-4 d-flex gap-3">
                                            <div class="">
                                                <label for="temp_state_id">Choose State</label>
                                                <div class="select">
                                                    <select id="temp_state_id" name="temp_state_id" class="temp_state_id" required>
                                                        <option disabled value="">Choose State</option>
                                                        @foreach ($states as $state)
                                                            <option value="{{ $state->id }}"
                                                                {{ $adminStateId == $state->id ? 'selected' : '' }}>
                                                                {{ $state->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('temp_state_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="">
                                                <label for="temp_district_id">Choose District</label>
                                                <div class="select">
                                                    <select id="temp_district_id" name="temp_district_id" class="temp_district_id" required>
                                                        <option value="{{ $adminDistrictId }}" selected>
                                                            {{ Auth::user()->district->name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                @error('temp_district_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                        </div>
                                   
                                        <div class="col-md-6 col-lg-6 pt-4 pb-4 d-flex gap-3">
                                            <div>
                                                <label for="temp_municipality_id">Choose Municipality</label>
                                                <div class="select">
                                                    <select id="temp_municipality_id" name="temp_municipality_id" class="temp_municipality_id" required>
                                                        <option value="{{ $adminMunicipalityId }}" selected>
                                                            {{ Auth::user()->municipality->name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                @error('temp_municipality_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                   
                                            <div class="">
                                                <label for="temp_ward_id">Choose Ward</label>
                                                <div class="select">
                                                    <select id="temp_ward_id" name="temp_ward_id" class="temp_ward_id" required>
                                                        <option value="{{ old('temp_ward_id') }}">Choose Ward</option>
                                                    </select>
                                                </div>
                                                @error('temp_ward_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-12 col-lg-12 d-flex gap-2 justify-content-between">
                                        <div class="col-lg-4 col-sm-4">
                                            <label for="temp_tole">Tole:</label>
                                            <input type="text" name="temp_tole" value="{{ old('temp_tole') }}" class="form-control" id="temp_tole" placeholder="Enter Tole">
                                            @error('temp_tole')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="temp_house_number">House Number:</label>
                                            <input type="text" name="temp_house_number" value="{{ old('temp_house_number') }}" class="form-control" id="temp_house_number" placeholder="Enter House Number">
                                            @error('temp_house_number')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    
                            
                                    <!-- Academic Information -->
                                    <div class="hr-line-dashed"></div>
                                    <h5>Academic Information</h5>
                                    <div class="hr-line-dashed"></div>
                                   
                                    <div class="academic-information">
                                        @if(old('level_of_study'))
                                            @foreach(old('level_of_study') as $key => $level)
                                                <div class="row academic-row mb-3">
                                                    <div class="col-md-3">
                                                        <label>Level<span class="must">*</span></label>
                                                        <select name="level_of_study[]" class="form-control" required>
                                                            <option value="">Select Level</option>
                                                            <option value="SLC/SEE" {{ $level == 'SLC/SEE' ? 'selected' : '' }}>SLC/SEE</option>
                                                            <option value="+2/PCL" {{ $level == '+2/PCL' ? 'selected' : '' }}>+2</option>
                                                            <option value="Bachelor" {{ $level == 'Bachelor' ? 'selected' : '' }}>Bachelor</option>
                                                            <option value="Master" {{ $level == 'Master' ? 'selected' : '' }}>Master</option>
                                                            <option value="PhD" {{ $level == 'PhD' ? 'selected' : '' }}>PhD</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Institution<span class="must">*</span></label>
                                                        <input type="text" name="institution_name[]" class="form-control" value="{{ old('institution_name.'.$key) }}" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Board/University<span class="must">*</span></label>
                                                        <input type="text" name="board_university_college[]" class="form-control" value="{{ old('board_university_college.'.$key) }}" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Registration No.</label>
                                                        <input type="text" name="registration[]" class="form-control" value="{{ old('registration.'.$key) }}">
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label>Documents</label>
                                                        <input type="file" name="academic_documents[]" class="form-control">
                                                    </div>
                                                    @if($key > 0)
                                                        <div class="col-md-12 mt-3 text-right">
                                                            <button type="button" class="btn btn-danger remove-row-btn">
                                                                <i class="fas fa-minus"></i> Remove
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="row academic-row mb-3">
                                                <div class="col-md-3">
                                                    <label>Level<span class="must">*</span></label>
                                                    <select name="level_of_study[]" class="form-control" required>
                                                        <option value="">Select Level</option>
                                                        <option value="SLC/SEE">SLC/SEE</option>
                                                        <option value="+2/PCL">+2</option>
                                                        <option value="Bachelor">Bachelor</option>
                                                        <option value="Master">Master</option>
                                                        <option value="PhD">PhD</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Institution<span class="must">*</span></label>
                                                    <input type="text" name="institution_name[]" class="form-control" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Board/University<span class="must">*</span></label>
                                                    <input type="text" name="board_university_college[]" class="form-control" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Registration No.</label>
                                                    <input type="text" name="registration[]" class="form-control">
                                                </div>
                                                <div class="col-md-3 mt-3">
                                                    <label>Documents</label>
                                                    <input type="file" name="academic_documents[]" class="form-control">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary add-academic-row">
                                                <i class="fas fa-plus"></i> Add More Academic Information
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        
                                <!-- Tab 3: Job & Financial Information -->
                                <div class="tab">
                                    <!-- Job Information -->
                                    <div class="hr-line-dashed"></div>
                                    <h5>Job Information</h5>
                                    <div class="hr-line-dashed"></div>
                                   
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="role">Position/Role<span class="must">*</span></label>
                                            <input type="text" name="role" class="form-control" value="{{ old('role') }}" required>
                                            @error('role')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-3 mb-3">
                                            <label for="level">Level<span class="must">*</span></label>
                                            <input type="text" name="level" class="form-control" value="{{ old('level') }}" required>
                                            @error('level')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>                                        
                                       
                                        <div class="col-md-3 mb-3">
                                            <label for="job_type">Job Type<span class="must">*</span></label>
                                            <select name="job_type" class="form-control" required>
                                                <option value="">Select Job Type</option>
                                                <option value="Temporary" {{ old('job_type') == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                                                <option value="Permanent" {{ old('job_type') == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                                <option value="Contract" {{ old('job_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                                <option value="Daily Basis" {{ old('job_type') == 'Daily Basis' ? 'selected' : '' }}>Daily Basis</option>
                                            </select>
                                            @error('job_type')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                       
                                        <div class="col-md-3 mb-3">
                                            <label for="category">Technical Category<span class="must">*</span></label>
                                            <select name="category" class="form-control" required>
                                                <option value="">Select Category</option>
                                                <option value="Technical" {{ old('category') == 'Technical' ? 'selected' : '' }}>Technical</option>
                                                <option value="Non-Technical" {{ old('category') == 'Non-Technical' ? 'selected' : '' }}>Non-Technical</option>
                                            </select>
                                            @error('category')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                       
                                        <div class="col-md-3 mb-3">
                                            <label for="appointment_date">Appointment Date<span class="must">*</span></label>
                                            <input id="appointment-nepali-datepicker" name="appointment_date" type="text" class="form-control" value="{{ old('appointment_date') }}" required/>
                                            @error('appointment_date')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                            
                                        <!-- Resume Upload -->
                                        <div class="col-md-3 mb-3">
                                            <label for="resume">Resume/CV</label>
                                            <input type="file" name="resume" class="form-control">
                                            @error('resume')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                            
                                        <!-- Other Documents -->
                                        <div class="col-md-12 mb-3">
                                            <label for="other_documents">Other Related Documents</label>
                                            <input type="file" name="other_documents[]" class="form-control" multiple>
                                            <small class="text-muted">You can select multiple files</small>
                                            @error('other_documents')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class=" d-flex justify-content-end mt-4">
                                    <div style="">
                                        <button class="btn btn-secondary" type="button" id="prevBtn"
                                            onclick="nextPrev(-1)">Previous</button>
                                        <button class="btn btn-primary" type="button" id="nextBtn"
                                            onclick="nextPrev(1)">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.includes.modal')
@endsection
@section('scripts')
    @include('backend.includes.nepalidate')
    @include('backend.includes.cropperjs')


    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab


        function showTab(n) {
            // This function will display the specified tab of the form ...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            // ... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            // ... and run a function that displays the correct step indicator:
            fixStepIndicator(n)
        }


        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form... :
            if (currentTab >= x.length) {
                //...the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }


        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            // for (i = 0; i < y.length; i++) {
            //     // If a field is empty...
            //     if (y[i].value == "") {
            //         // add an "invalid" class to the field:
            //         y[i].className += " invalid";
            //         // and set the current valid status to false:
            //         valid = false;
            //     }
            // }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }


        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class to the current step:
            x[n].className += " active";
        }
    </script>




   
    <script>
        $(document).ready(function() {
    var preselectedStateId = '{{ $adminStateId }}';
    var preselectedDistrictId = '{{ $adminDistrictId }}';
    var preselectedMunicipalityId = '{{ $adminMunicipalityId }}';


    // Function to load districts for both permanent and temporary addresses
    function loadDistricts(state_id, district_id = null, isTemporary = false) {
        var append_to = isTemporary ? 'temp_district_id' : 'district_id';
        $.ajax({
            url: '/admin/get-district-by-state/' + state_id,
            type: 'GET',
            success: function(response) {
                console.log(response); // Debug response
                var options = '<option disabled value>Choose District</option>';
                response.forEach(function(district) {
                    options += `<option value="${district.id}" ${district_id == district.id ? 'selected' : ''}>${district.name}</option>`;
                });
                $('#' + append_to).html(options);


                // Load municipalities for the preselected or first loaded district
                if (district_id) {
                    loadMunicipalities(district_id, preselectedMunicipalityId, isTemporary);
                } else if (response.length > 0) {
                    loadMunicipalities(response[0].id, null, isTemporary);
                }
            }
        });
    }


    // Function to load municipalities for both addresses
    function loadMunicipalities(district_id, municipality_id = null, isTemporary = false) {
        var append_to = isTemporary ? 'temp_municipality_id' : 'municipality_id';  // Fixed typo here
        $.ajax({
            url: '/admin/get-municipality-by-district/' + district_id,
            type: 'GET',
            success: function(response) {
                console.log(response); // Debug response
                var options = '<option disabled selected value>Choose Municipality</option>';
                response.forEach(function(municipality) {
                    options += `<option value="${municipality.id}" ${municipality_id == municipality.id ? 'selected' : ''}>${municipality.name}</option>`;
                });
                $('#' + append_to).html(options);


                // Load wards for the preselected or first loaded municipality
                if (municipality_id) {
                    loadWards(municipality_id, isTemporary);
                } else if (response.length > 0) {
                    loadWards(response[0].id, isTemporary);
                }
            }
        });
    }


    // Function to load wards for both addresses
    function loadWards(municipality_id, isTemporary = false) {
        var append_to = isTemporary ? 'temp_ward_id' : 'ward_id';
        $.ajax({
            url: '/admin/get-ward-by-municipality/' + municipality_id,
            type: 'GET',
            success: function(response) {
                var options = '<option disabled selected value>Choose Ward</option>';
                response.forEach(function(ward) {
                    options += `<option value="${ward.id}">${ward.name}</option>`;
                });
                $('#' + append_to).html(options);
            }
        });
    }


    // Event listeners for permanent address
    $('.state_id').change(function() {
        loadDistricts($(this).val(), null, false);
    });


    $('.district_id').change(function() {
        loadMunicipalities($(this).val(), null, false);
    });


    $('.municipality_id').change(function() {
        loadWards($(this).val(), false);
    });


    // Event listeners for temporary address
    $('.temp_state_id').change(function() {
        loadDistricts($(this).val(), null, true);
    });


    $('.temp_district_id').change(function() {
        loadMunicipalities($(this).val(), null, true);
    });


    $('.temp_municipality_id').change(function() {
        loadWards($(this).val(), true);
    });


    // Initial load for permanent address
    if (preselectedStateId) {
        loadDistricts(preselectedStateId, preselectedDistrictId, false);
    }


    // Initial load for temporary address
    if (preselectedStateId) {
        loadDistricts(preselectedStateId, preselectedDistrictId, true);
    }
});



     // Function to generate a random 3-digit number
  function generateRandomNumber() {
        const length = 3;
        const chars = '123456789';
        let randomNumber = '';
        for (let i = 0; i < length; i++) {
            const randomIndex = Math.floor(Math.random() * chars.length);
            randomNumber += chars[randomIndex];
        }
        return randomNumber;
    }


    // Function to generate the employee id based on municipality ID and school ID
    function generateEmployeeId(municipalityId, schoolId) {
        const randomNumber = generateRandomNumber();
        return `${municipalityId}${schoolId}${randomNumber}`;
    }


    // Set the generated employee id to the input field
    function updateEmployeeId() {
        const employeeIdInput = document.getElementById('employee_id');
        const municipalityId = document.getElementById('municipalitiy_id').value;
        const schoolId = "{{ $schoolId }}"; // Retrieve school ID from the Blade template
        if (employeeIdInput) {
            employeeIdInput.value = generateEmployeeId(municipalityId, schoolId);
        }
    }


    // Event listener for DOM content loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Update employee id on page load if not set
        const employeeIdInput = document.getElementById('employee_id');
        if (employeeIdInput && !employeeIdInput.value) {
            updateEmployeeId();
        }


        // Update employee id when municipality selection changes
        const municipalitySelect = document.getElementById('municipalitiy_id');
        if (municipalitySelect) {
            municipalitySelect.addEventListener('change', updateEmployeeId);
        }
    });




</script>


<script>
   
    // Add more academic rows
    var academicCount = 1;
    $('#add-academic').click(function() {
        var newRow = `
            <div class="row academic-row mb-3">
                <div class="col-md-3">
                    <label>Level</label>
                    <select name="academic_information[${academicCount}][level]" class="form-control">
                        <option value="">Select Level</option>
                        <option value="SLC/SEE">SLC/SEE</option>
                        <option value="+2/PCL">+2/PCL</option>
                        <option value="Bachelor">Bachelor</option>
                        <option value="Master">Master</option>
                        <option value="MPhil">MPhil</option>
                        <option value="PhD">PhD</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Institution</label>
                    <input type="text" name="academic_information[${academicCount}][institution]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label>Board/University</label>
                    <input type="text" name="academic_information[${academicCount}][board]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label>Major Subject</label>
                    <input type="text" name="academic_information[${academicCount}][major]" class="form-control">
                </div>
                <div class="col-md-1">
                    <label>Year</label>
                    <input type="text" name="academic_information[${academicCount}][year]" class="form-control">
                </div>
                <div class="col-md-1">
                    <label>Division</label>
                    <input type="text" name="academic_information[${academicCount}][division]" class="form-control">
                </div>
            </div>
        `;
        $('.academic-information').append(newRow);
        academicCount++;
    });
   
    // Add more previous employment rows
    var employmentCount = 1;
    $('#add-employment').click(function() {
        var newRow = `
            <div class="row employment-row mb-3">
                <div class="col-md-3">
                    <label>Organization</label>
                    <input type="text" name="previous_employment[${employmentCount}][organization]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Position</label>
                    <input type="text" name="previous_employment[${employmentCount}][position]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label>From Date</label>
                    <input type="text" name="previous_employment[${employmentCount}][from_date]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label>To Date</label>
                    <input type="text" name="previous_employment[${employmentCount}][to_date]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label>Reason for Leaving</label>
                    <input type="text" name="previous_employment[${employmentCount}][reason]" class="form-control">
                </div>
            </div>
        `;
        $('.previous-employment').append(newRow);
        employmentCount++;
    });
   
    // Check initial state of marital status
    if($('input[name="marital_status"]:checked').val() == '1') {
        $('.spouse-info').show();
    } else {
        $('.spouse-info').hide();
    }

    $(document).ready(function() {
    // Add button click handler
    $(document).on('click', '.add-academic-row', function() {
        // Clone the first academic row
        const newRow = $('.academic-row:first').clone();
        
        // Clear input values in the cloned row
        newRow.find('input').val('');
        newRow.find('select').prop('selectedIndex', 0);
        newRow.find('input[type="file"]').val('');
        
        // Add a remove button to the cloned row
        if (newRow.find('.remove-row-btn').length === 0) {
            newRow.append('<div class="col-md-12 mt-3 text-right">' +
                         '<button type="button" class="btn btn-danger remove-row-btn">' +
                         '<i class="fas fa-minus"></i> Remove</button></div>');
        }
        
        // Append the cloned row to the academic-information div
        $('.academic-information').append(newRow);
    });
    
    // Remove button click handler
    $(document).on('click', '.remove-row-btn', function() {
        // Remove the parent row
        $(this).closest('.academic-row').remove();
    });
});


</script>


    </script>


@endsection