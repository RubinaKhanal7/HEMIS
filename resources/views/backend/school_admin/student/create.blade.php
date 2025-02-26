@extends('backend.layouts.master')


<!-- Main content -->
@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>
                    {{ $page_title }}
                </h2>
            </div>
            @include('backend.school_admin.student.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="">
                        <div class="">
                            <form id="regForm" action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- This indicates the steps of the form: -->
                                <div class="d-flex justify-content-center gap-2">
                                    <span class="step">Basic Information</span>
                                    <span class="step">Parent/Guardian Information</span>
                                    <span class="step">Student Enrollment & Academic Information</span>
                                    <span class="step">Student's Previous Academic Information</span>
                                </div>
                                <div class="tab">
                                    <div class="col-md-12 col-lg-12 mt-4">
                                        <div class="hr-line-dashed"></div>
                                        <h5>Student's Basic Information:</h5>
                                        <div class="hr-line-dashed"></div>
                                       
                                        <div class="col-md-12 col-lg-12 d-flex flex-wrap justify-content-between gap-1">
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="first_name_en">First Name (English): <span class="text-danger">*</span></label>
                                                <input type="text" name="first_name_en" value="{{ old('first_name_en') }}" class="form-control" id="first_name_en" placeholder="Enter First Name">
                                                @error('first_name_en')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="first_name_np">First Name (Nepali): <span class="text-danger">*</span></label>
                                                <input type="text" name="first_name_np" value="{{ old('first_name_np') }}" class="form-control" id="first_name_np" placeholder="Enter First Name">
                                                @error('first_name_np')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="middle_name_en">Middle Name (English):</label>
                                                <input type="text" name="middle_name_en" value="{{ old('middle_name_en') }}" class="form-control" id="middle_name_en" placeholder="Enter Middle Name">
                                                @error('middle_name_en')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="middle_name_np">Middle Name (Nepali):</label>
                                                <input type="text" name="middle_name_np" value="{{ old('middle_name_np') }}" class="form-control" id="middle_name_np" placeholder="Enter Middle Name">
                                                @error('middle_name_np')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="last_name_en">Last Name (English): <span class="text-danger">*</span></label>
                                                <input type="text" name="last_name_en" value="{{ old('last_name_en') }}" class="form-control" id="last_name_en" placeholder="Enter Last Name">
                                                @error('last_name_en')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="last_name_np">Last Name (Nepali): <span class="text-danger">*</span></label>
                                                <input type="text" name="last_name_np" value="{{ old('last_name_np') }}" class="form-control" id="last_name_np" placeholder="Enter Last Name">
                                                @error('last_name_np')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                       
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mobile_number">Mobile No. : <span class="text-danger">*</span></label>
                                                <input type="text" name="mobile_number" value="{{ old('mobile_number') }}" class="form-control" id="mobile_number" placeholder="Enter Mobile Number">
                                                @error('mobile_number')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="dob">Date of Birth: <span class="text-danger">*</span></label>
                                                <input type="text" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control" id="dob-datepicker" placeholder="Enter DOB">
                                                @error('date_of_birth')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                       
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="gender">Gender: <span class="text-danger">*</span></label><br>
                                                <label for="gender_male" class="l-radio">
                                                    <input type="radio" name="gender" value="Male" id="gender_male" {{ old('gender') == 'Male' ? 'checked' : '' }}>
                                                    <span>Male</span>
                                                </label>
                                                <label for="gender_female" class="l-radio">
                                                    <input type="radio" name="gender" value="Female" id="gender_female" {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                                    <span>Female</span>
                                                </label>
                                                @error('gender')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                       
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="caste">Caste:</label>
                                                <input type="text" name="caste" value="{{ old('caste') }}" class="form-control" id="caste" placeholder="Enter Caste">
                                                @error('caste')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                       
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="ethnicity">Ethnicity: <span class="text-danger">*</span></label>
                                                <select name="ethnicity" class="form-control" id="ethnicity">
                                                    <option value="" disabled selected>Select Ethnicity</option>
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
                                            
                                       
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="edj">EDJ:</label>
                                                <input type="text" name="edj" value="{{ old('edj') }}" class="form-control" id="edj" placeholder="Enter EDJ">
                                                @error('edj')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                       
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label>Disability Status:</label>
                                                <div>
                                                    <label class="mr-3">
                                                        <input type="radio" name="disability_status" value="yes" {{ old('disability_status') == 'yes' ? 'checked' : '' }}> Yes
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="disability_status" value="no" {{ old('disability_status') == 'no' ? 'checked' : '' }}> No
                                                    </label>
                                                </div>
                                                @error('disability_status')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                       
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="citizenship">Citizenship Id:</label>
                                                <input type="text" name="citizenship_id" value="{{ old('citizenship_id') }}" class="form-control" id="citizenship" placeholder="Enter Citizenship">
                                                @error('citizenship_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                       
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="national_id">National ID:</label>
                                                <input type="text" name="national_id" value="{{ old('national_id') }}" class="form-control" id="national_id" placeholder="Enter National ID">
                                                @error('national_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                       
                                            <div class="col-md-12 col-lg-12 mt-4">
                                                <div class="hr-line-dashed"></div>
                                                <h5>Student's Picture:</h5>
                                                <div class="col-lg-4">
                                                    <img src="" id="image" style="width: 20%;">
                                                    <div class="form-group">
                                                        <input type="file" id="imageFile" class="form-control" placeholder="Image" name="student_photo" data-ratio="16" data-ratiowidth="16">
                                                    </div>
                                                    <div id="previewWrapper" class="hidden">
                                                        <br>
                                                        <img id="croppedImagePreview" height="150"><br>
                                                        <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                                        <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm" type="button" id="removeCroppedImage" style="margin-top: 7px;">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                       
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="citizenship_front">Citizenship Front:</label>
                                                <input type="file" name="citizenship_front" class="form-control" id="citizenship_front" accept="image/*" onchange="previewImage(this, 'citizenship_front_preview')">
                                                <div class="mt-2">
                                                    <img id="citizenship_front_preview" src="" alt="Citizenship Front Preview" class="img-thumbnail" width="150" style="display: none;">
                                                </div>
                                                @error('citizenship_front')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="citizenship_back">Citizenship Back:</label>
                                                <input type="file" name="citizenship_back" class="form-control" id="citizenship_back" accept="image/*" onchange="previewImage(this, 'citizenship_back_preview')">
                                                <div class="mt-2">
                                                    <img id="citizenship_back_preview" src="" alt="Citizenship Back Preview" class="img-thumbnail" width="150" style="display: none;">
                                                </div>
                                                @error('citizenship_back')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <script>
                                            function previewImage(input, previewId) {
                                                const preview = document.getElementById(previewId);
                                                if (input.files && input.files[0]) {
                                                    const reader = new FileReader();
                                                    
                                                    reader.onload = function(e) {
                                                        preview.src = e.target.result;
                                                        preview.style.display = 'block';
                                                    }
                                                    
                                                    reader.readAsDataURL(input.files[0]);
                                                } else {
                                                    preview.src = '';
                                                    preview.style.display = 'none';
                                                }
                                            }
                                            </script>
                                        </div>                                        
                                    </div>
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
                                    </div>
                                   
                                   
                                    <div class="tab">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="hr-line-dashed"></div>
                                            <h5>Student's Parent Information:</h5>
                                            <div class="hr-line-dashed"></div>
                                   
                                            <div class="col-lg-12 col-md-12 d-flex gap-3 flex-wrap justify-content-between">
                                   
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="father_name">Father's Name:</label>
                                                    <input type="text" name="father_name"
                                                        value="{{ old('father_name') }}" class="form-control"
                                                        id="father_name" placeholder="Enter Father's Name">
                                                    @error('father_name')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="father_contact_no">Father's Phone:</label>
                                                    <input type="text" name="father_contact_no"
                                                        value="{{ old('father_contact_no') }}" class="form-control"
                                                        id="father_contact_no" placeholder="Enter Father's Phone">
                                                    @error('father_contact_no')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                   
                                   
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="father_occupation">Father's Occupation:</label>
                                                    <input type="text" name="father_occupation"
                                                        value="{{ old('father_occupation') }}" class="form-control"
                                                        id="father_occupation" placeholder="Enter Father's Occupation">
                                                    @error('father_occupation')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                   
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="mother_name">Mother's Name:</label>
                                                    <input type="text" name="mother_name"
                                                        value="{{ old('mother_name') }}" class="form-control"
                                                        id="mother_name" placeholder="Enter Mother's Name">
                                                    @error('mother_name')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="mother_contact_no">Mother's Phone:</label>
                                                    <input type="text" name="mother_contact_no"
                                                        value="{{ old('mother_contact_no') }}" class="form-control"
                                                        id="mother_contact_no" placeholder="Enter Mother's Phone">
                                                    @error('mother_contact_no')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                               
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="mother_occupation">Mother's Occupation:</label>
                                                    <input type="text" name="mother_occupation"
                                                        value="{{ old('mother_occupation') }}" class="form-control"
                                                        id="mother_occupation" placeholder="Enter Mother's Occupation">
                                                    @error('mother_occupation')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="tab">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="hr-line-dashed"></div>
                                            <h5>Student Enrollment & Academic Information:</h5>
                                            <div class="hr-line-dashed"></div>
                                    
                                            <div class="col-lg-12 col-md-12 d-flex gap-3 flex-wrap justify-content-between">
                                                <!-- Level of Study -->
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="level_of_study">Level of Study: <span class="text-danger">*</span></label>
                                                    <select name="class_id" required class="form-control">
                                                        <option value="">Select Level of Study</option>
                                                        @foreach ($classes as $class)
                                                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                                {{ $class->class }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                    
                                                <!-- Faculty -->
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="faculty">Faculty: <span class="text-danger">*</span></label>
                                                    <select name="section_id" required class="form-control">
                                                        <option value="">Select Faculty</option>
                                                        <!-- Add options dynamically here based on level of study -->
                                                    </select>
                                                </div>
                                    
                                                <!-- Program -->
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="program">Program: <span class="text-danger">*</span></label>
                                                    <select name="program_id" class="form-control">
                                                        <option value="">Select Program</option>
                                                        <!-- Add options dynamically here based on faculty -->
                                                    </select>
                                                </div>
                                            </div>
                                    
                                            <div class="col-lg-12 col-md-12 d-flex gap-3 flex-wrap justify-content-between">
                                                <!-- Admission Year -->
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="admission_year">Admission Year: <span class="text-danger">*</span></label>
                                                    <input type="text" name="admission_year" value="{{ old('admission_year') }}" class="form-control" id="admission_year" placeholder="Enter Admission Year">
                                                    @error('admission_year')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                    
                                                <!-- Date of Admission -->
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="date_of_admission">Date of Admission: <span class="text-danger">*</span></label>
                                                    <input type="text" name="date_of_admission" value="{{ old('date_of_admission') }}" class="form-control" id="admission-datepicker" placeholder="Enter Date of Admission">
                                                    @error('date_of_admission')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                    
                                                <!-- Academic Program Duration -->
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="academic_program_duration">Academic Program Duration: <span class="text-danger">*</span></label>
                                                    <input type="text" name="academic_program_duration" value="{{ old('academic_program_duration') }}" class="form-control" id="academic_program_duration" placeholder="Enter Duration">
                                                    @error('academic_program_duration')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="tab">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="hr-line-dashed"></div>
                                            <h5>Student's Previous Academic Information:</h5>
                                            <div class="hr-line-dashed"></div>
                                   
                                            <div class="col-lg-12 col-md-12 d-flex gap-3 flex-wrap justify-content-between">
                                   
                                                <!-- Name of Level of Study -->
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="previous_level_of_study">Name of Level of Study: <span class="text-danger">*</span></label>
                                                    <input type="text" name="previous_level_of_study"
                                                        value="{{ old('previous_level_of_study', $student->previousAcademic->previous_level_of_study ?? '') }}"
                                                        class="form-control" id="previous_level_of_study" placeholder="Enter Previous Level of Study">
                                                    @error('previous_level_of_study')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                   
                                                <!-- Board/University/College -->
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="previous_board_university_college">Board/University/College: <span class="text-danger">*</span></label>
                                                    <input type="text" name="previous_board_university_college"
                                                        value="{{ old('previous_board_university_college', $student->previousAcademic->previous_board_university_college ?? '') }}"
                                                        class="form-control" id="previous_board_university_college" placeholder="Enter Board/University/College">
                                                    @error('previous_board_university_college')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                   
                                                <!-- Registration Number -->
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="previous_registration_no">Registration Number: <span class="text-danger">*</span></label>
                                                    <input type="text" name="previous_registration_no"
                                                        value="{{ old('previous_registration_no', $student->previousAcademic->previous_registration_no ?? '') }}"
                                                        class="form-control" id="previous_registration_no" placeholder="Enter Registration Number">
                                                    @error('previous_registration_no')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                   
                                                <!-- Name of Institution -->
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="previous_institution_name">Name of Institution: <span class="text-danger">*</span></label>
                                                    <input type="text" name="previous_institution_name"
                                                        value="{{ old('previous_institution_name', $student->previousAcademic->previous_institution_name ?? '') }}"
                                                        class="form-control" id="previous_institution_name" placeholder="Enter Name of Institution">
                                                    @error('previous_institution_name')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                   <!-- Attachment of Previous Studies Records -->
<div class="form-group col-lg-3 col-sm-3 mt-2">
    <label for="previous_study_records_attachment">Attachment of Previous Studies Records:</label>
    <div class="input-group">
        <input type="file" name="previous_study_records_attachment[]" class="form-control attachment-input">
        <button type="button" class="btn btn-primary" id="add-more-attachments">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    @error('previous_study_records_attachment')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
    @error('previous_study_records_attachment.*')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror

    <!-- Container for additional attachment fields -->
    <div id="attachments-container" class="mt-2"></div>

    <!-- Preview Container -->
    <div id="document_preview_container" class="mt-2" style="display: none;">
        <div id="file_previews"></div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if jQuery is available
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded. Please include jQuery before this script.');
        return;
    }

    // Add more attachments
    document.getElementById('add-more-attachments').addEventListener('click', function() {
        let container = document.getElementById('attachments-container');
        let div = document.createElement('div');
        div.className = 'input-group mt-2 attachment-field';
        div.innerHTML = `
            <input type="file" name="previous_study_records_attachment[]" class="form-control attachment-input">
            <button type="button" class="btn btn-danger remove-attachment">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-primary add-attachment">
                <i class="fas fa-plus"></i>
            </button>
        `;
        container.appendChild(div);

        // Add event listener to the new file input
        div.querySelector('.attachment-input').addEventListener('change', handleFileSelection);
    });

    // Initial file input event
    document.querySelector('.attachment-input').addEventListener('change', handleFileSelection);

    // Function to handle file selection
    function handleFileSelection(event) {
        if (event.target.files && event.target.files[0]) {
            let fileName = event.target.files[0].name;
            let previewContainer = document.getElementById('document_preview_container');
            let filePreviews = document.getElementById('file_previews');
            
            // Create a preview element
            let previewElement = document.createElement('p');
            previewElement.className = 'mb-1';
            previewElement.innerHTML = `<i class="fas fa-file"></i> ${fileName}`;
            
            filePreviews.appendChild(previewElement);
            previewContainer.style.display = 'block';
        }
    }

    // Using event delegation for dynamically added elements
    document.getElementById('attachments-container').addEventListener('click', function(event) {
        // Handle remove button clicks
        if (event.target.classList.contains('remove-attachment') || 
            (event.target.parentElement && event.target.parentElement.classList.contains('remove-attachment'))) {
            const button = event.target.classList.contains('remove-attachment') ? 
                            event.target : event.target.parentElement;
            const fieldToRemove = button.closest('.attachment-field');
            if (fieldToRemove) {
                fieldToRemove.remove();
            }
        }
        
        // Handle add button clicks
        if (event.target.classList.contains('add-attachment') || 
            (event.target.parentElement && event.target.parentElement.classList.contains('add-attachment'))) {
            const button = event.target.classList.contains('add-attachment') ? 
                            event.target : event.target.parentElement;
            const currentField = button.closest('.attachment-field');
            
            if (currentField) {
                let newDiv = document.createElement('div');
                newDiv.className = 'input-group mt-2 attachment-field';
                newDiv.innerHTML = `
                    <input type="file" name="previous_study_records_attachment[]" class="form-control attachment-input">
                    <button type="button" class="btn btn-danger remove-attachment">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-primary add-attachment">
                        <i class="fas fa-plus"></i>
                    </button>
                `;
                
                // Add new field after the current one
                currentField.after(newDiv);
                
                // Add event listener to the new file input
                newDiv.querySelector('.attachment-input').addEventListener('change', handleFileSelection);
            }
        }
    });
});
</script>
                                   
                                            </div>
                                        </div>
                                    </div>
                                   
                               
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                 {{-- DISPLAY FOR THE EXTRA STEPS
                                <div class="tab">Login Info:
                                    <p><input placeholder="Username..." oninput="this.className = ''"></p>
                                    <p><input placeholder="Password..." oninput="this.className = ''"></p>
                                </div> --}}


                                <div class=" d-flex justify-content-end mt-4">
                                    <div style="">
                                        <button class="btn btn-secondary" type="button" id="prevBtn"
                                            onclick="nextPrev(-1)">Previous</button>
                                        <button class="btn btn-primary" id="submitBtn" type="submit"
                                            style="display: none;">Submit</button>


                                        <button class="btn btn-primary" type="button" id="nextBtn"
                                            onclick="nextPrev(1)">Next</button>
                                    </div>
                                </div>


                                {{-- <!--This indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                    <span class="step">Basic Information</span>
                                    <span class="step">Parent Information</span>
                                    <span class="step">Social Information</span>
                                    <span class="step"></span>
                                </div> --}}


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


    // Function to generate the admission number based on municipality ID and school ID
    function generateAdmissionNumber(municipalityId, schoolId) {
        const randomNumber = generateRandomNumber();
        return `${municipalityId}${schoolId}${randomNumber}`;
    }


    // Set the generated admission number to the input field
    function updateAdmissionNumber() {
        const admissionNoInput = document.getElementById('admission_no');
        const municipalityId = document.getElementById('municipalitiy_id').value;
        const schoolId = "{{ $adminSchoolId }}"; // Retrieve school ID from the Blade template
        if (admissionNoInput) {
            admissionNoInput.value = generateAdmissionNumber(municipalityId, schoolId);
        }
    }


    // Event listener for DOM content loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Update admission number on page load if not set
        const admissionNoInput = document.getElementById('admission_no');
        if (admissionNoInput && !admissionNoInput.value) {
            updateAdmissionNumber();
        }


        // Update admission number when municipality selection changes
        const municipalitySelect = document.getElementById('municipalitiy_id');
        if (municipalitySelect) {
            municipalitySelect.addEventListener('change', updateAdmissionNumber);
        }
    });




</script>


   


    <script>
        $(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
 $('select[name="class_id"]').change(function() {
        var classId = $(this).val();
        
        // Reset dependent dropdowns
        $('select[name="section_id"]').empty().append('<option value="">Select Faculty</option>');
        $('select[name="program_id"]').empty().append('<option value="">Select Program</option>');
        
        if (classId) {
            // Fetch sections (faculties)
            $.ajax({
                url: '/admin/get-section-by-class/' + classId,
                type: 'GET',
                success: function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="section_id"]').append(
                            '<option value="' + key + '">' + value + '</option>'
                        );
                    });
                },
                error: function(xhr) {
                    console.error('Error fetching sections:', xhr);
                }
            });

            // Fetch programs
            $.ajax({
                url: '/admin/get-programs-by-class/' + classId,
                type: 'GET',
                success: function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="program_id"]').append(
                            '<option value="' + key + '">' + value + '</option>'
                        );
                    });
                },
                error: function(xhr) {
                    console.error('Error fetching programs:', xhr);
                }
            });
        }
    });
      
    });
    </script>




@endsection