@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.student.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="">
                        <div class="">
                            <form id="studentUpdateForm" action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                
                                <!-- Form Steps Indicator -->
                                <div class="d-flex justify-content-center gap-2">
                                    <span class="step">Basic Information</span>
                                    <span class="step">Parent/Guardian Information</span>
                                    <span class="step">Student Enrollment & Academic Information</span>
                                    <span class="step">Student's Previous Academic Information</span>
                                </div>

                                <!-- Basic Information Tab -->
                                <div class="tab">
                                    <div class="col-md-12 col-lg-12 mt-4">
                                        <div class="hr-line-dashed"></div>
                                        <h5>Student's Basic Information:</h5>
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="col-md-12 col-lg-12 d-flex flex-wrap justify-content-between gap-1">
                                            <!-- First Name English -->
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="first_name_en">First Name (English): <span class="text-danger">*</span></label>
                                                <input type="text" name="first_name_en" value="{{ old('first_name_en', $student->first_name_en) }}" 
                                                    class="form-control" id="first_name_en" placeholder="Enter First Name">
                                                @error('first_name_en')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <!-- First Name Nepali -->
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="first_name_np">First Name (Nepali): <span class="text-danger">*</span></label>
                                                <input type="text" name="first_name_np" value="{{ old('first_name_np', $student->first_name_np) }}" 
                                                    class="form-control" id="first_name_np" placeholder="Enter First Name">
                                                @error('first_name_np')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="middle_name_en">Middle Name (English):</label>
                                                <input type="text" name="middle_name_en"
                                                    value="{{ old('middle_name_en', $student->middle_name_en) }}"
                                                    class="form-control" id="middle_name_en" placeholder="Enter Middle Name">
                                                @error('middle_name_en')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="middle_name_np">Middle Name (Nepali):</label>
                                                <input type="text" name="middle_name_np"
                                                    value="{{ old('middle_name_np', $student->middle_name_np) }}"
                                                    class="form-control" id="middle_name_np" placeholder="Enter Middle Name">
                                                @error('middle_name_np')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="last_name_en">Last Name (English): <span class="text-danger">*</span></label>
                                                <input type="text" name="last_name_en"
                                                    value="{{ old('last_name_en', $student->last_name_en) }}"
                                                    class="form-control" id="last_name_en" placeholder="Enter Last Name">
                                                @error('last_name_en')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="last_name_np">Last Name (Nepali): <span class="text-danger">*</span></label>
                                                <input type="text" name="last_name_np"
                                                    value="{{ old('last_name_np', $student->last_name_np) }}"
                                                    class="form-control" id="last_name_np" placeholder="Enter Last Name">
                                                @error('last_name_np')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mobile_number">Mobile No. : <span class="text-danger">*</span></label>
                                                <input type="text" name="mobile_number" value="{{ old('mobile_number', $student->mobile_number) }}" 
                                                    class="form-control" id="mobile_number" placeholder="Enter Mobile Number">
                                                @error('mobile_number')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="dob">Date of Birth: <span class="text-danger">*</span></label>
                                                <input type="text" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth) }}" 
                                                    class="form-control" id="dob-datepicker" placeholder="Enter DOB">
                                                @error('date_of_birth')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="gender">Gender: <span class="text-danger">*</span></label><br>
                                                <label for="gender_male" class="l-radio">
                                                    <input type="radio" name="gender" value="Male" id="gender_male" 
                                                        {{ old('gender', $student->gender) == 'Male' ? 'checked' : '' }}>
                                                    <span>Male</span>
                                                </label>
                                                <label for="gender_female" class="l-radio">
                                                    <input type="radio" name="gender" value="Female" id="gender_female" 
                                                        {{ old('gender', $student->gender) == 'Female' ? 'checked' : '' }}>
                                                    <span>Female</span>
                                                </label>
                                                @error('gender')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>


                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="caste ">Caste :</label>
                                                <input type="text" name="caste"
                                                    value="{{ old('caste', $student->caste) }}"
                                                    class="form-control" id="caste" placeholder="Enter Caste">
                                                @error('caste')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="ethnicity">Ethnicity: <span class="text-danger">*</span></label>
                                                <select name="ethnicity" class="form-control" id="ethnicity" required>
                                                    <option value="" disabled>Select Ethnicity</option>
                                                    @foreach(['Dalit', 'Janajati', 'Madhesi', 'Muslim', 'Tharu', 'Brahmin', 'Chhetri'] as $ethnicity)
                                                        <option value="{{ $ethnicity }}" 
                                                            {{ (old('ethnicity', $student->ethnicity ?? '') == $ethnicity) ? 'selected' : '' }}>
                                                            {{ $ethnicity }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('ethnicity')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="edj ">EDJ :</label>
                                                <input type="text" name="edj"
                                                    value="{{ old('edj', $student->edj) }}"
                                                    class="form-control" id="edj" placeholder="Enter EDJ">
                                                @error('edj')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label>Disability Status: <span class="text-danger">*</span></label>
                                                <div>
                                                    <label class="mr-3">
                                                        <input type="radio" name="disability_status" value="yes" 
                                                            {{ old('disability_status', $student->disability_status ?? '') == 'yes' ? 'checked' : '' }}> Yes
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="disability_status" value="no" 
                                                            {{ old('disability_status', $student->disability_status ?? '') == 'no' ? 'checked' : '' }}> No
                                                    </label>
                                                </div>
                                                @error('disability_status')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="citizenship_id">Citizenship ID:</label>
                                                <input type="text" name="citizenship_id" value="{{ old('citizenship_id', $student->citizenship_id ?? '') }}" 
                                                    class="form-control" id="citizenship_id" placeholder="Enter Citizenship ID">
                                                @error('citizenship_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="national_id">National ID:</label>
                                                <input type="text" name="national_id" value="{{ old('national_id', $student->national_id ?? '') }}" 
                                                    class="form-control" id="national_id" placeholder="Enter National ID">
                                                @error('national_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            
                                            <div class="col-md-12 col-lg-12 mt-4">
                                                <div class="hr-line-dashed"></div>
                                                <h5>Student's Picture:</h5>
                                                <div class="col-lg-4">
                                                    @if($student->student_photo)
                                                        <img src="{{ asset('uploads/students/' . $student->student_photo) }}" 
                                                            id="image" style="width: 20%;">
                                                    @endif
                                                    <div class="form-group">
                                                        <input type="file" id="imageFile" class="form-control" 
                                                            placeholder="Image" name="student_photo">
                                                    </div>
                                                </div>
                                            </div>
                

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="citizenship_front">Citizenship Front:</label>
                                                <input type="file" name="citizenship_front" class="form-control" id="citizenship_front" accept="image/*">
                                                
                                                @if (!empty($student->citizenship_front))
                                                    <div class="mt-2">
                                                        <img src="{{ asset('uploads/citizenship_docs/' . $student->citizenship_front) }}" 
                                                            alt="Citizenship Front Image" class="img-thumbnail" width="150">
                                                    </div>
                                                @endif
                                            
                                                @error('citizenship_front')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="citizenship_back">Citizenship Back:</label>
                                                <input type="file" name="citizenship_back" class="form-control" id="citizenship_back" accept="image/*">
                                                
                                                @if (!empty($student->citizenship_back))
                                                    <div class="mt-2">
                                                        <img src="{{ asset('uploads/citizenship_docs/' . $student->citizenship_back) }}" 
                                                            alt="Citizenship Back Image" class="img-thumbnail" width="150">
                                                    </div>
                                                @endif
                                            
                                                @error('citizenship_back')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
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
                                                                {{ old('permanent_province', $student->permanent_province) == $state->id ? 'selected' : '' }}>
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
                                                        <option value="" disabled>Choose District</option>
                                                        @foreach ($districts as $district)
                                                            <option value="{{ $district->id }}"
                                                                {{ old('permanent_district', $student->permanent_district) == $district->id ? 'selected' : '' }}>
                                                                {{ $district->name }}
                                                            </option>
                                                        @endforeach
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
                                                        <option value="" disabled>Choose Municipality</option>
                                                        @foreach ($municipalities as $municipality)
                                                            <option value="{{ $municipality->id }}"
                                                                {{ old('permanent_local_level', $student->permanent_local_level) == $municipality->id ? 'selected' : '' }}>
                                                                {{ $municipality->name }}
                                                            </option>
                                                        @endforeach
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
                                                        <option value="" disabled>Choose Ward</option>
                                                        @foreach ($wards as $ward)
                                                            <option value="{{ $ward->id }}"
                                                                {{ old('permanent_ward_no', $student->permanent_ward_no) == $ward->id ? 'selected' : '' }}>
                                                                {{ $ward->name }}
                                                            </option>
                                                        @endforeach
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
                                            <input type="text" name="permanent_tole" value="{{ old('permanent_tole', $student->permanent_tole) }}" class="form-control" id="tole" placeholder="Enter Tole">
                                            @error('tole')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="house_number">House Number:</label>
                                            <input type="text" name="permanent_house_no" value="{{ old('permanent_house_no', $student->permanent_house_no) }}" class="form-control" id="house_number" placeholder="Enter House Number">
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
                                            <input type="text" name="temporary_tole" value="{{ old('temporary_tole', $student->temporary_tole_tole) }}" class="form-control" id="temp_tole" placeholder="Enter Tole">
                                            @error('temp_tole')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="temp_house_number">House Number:</label>
                                            <input type="text" name="temporary_house_no" value="{{ old('temporary_house_no', $student->temporary_house_no) }}" class="form-control" id="temp_house_number" placeholder="Enter House Number">
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
                                                    value="{{ old('father_name', $student->father_name) }}" 
                                                    class="form-control" id="father_name" 
                                                    placeholder="Enter Father's Name">
                                                @error('father_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="father_contact_no">Father's Phone:</label>
                                                <input type="text" name="father_contact_no"
                                                    value="{{ old('father_contact_no', $student->father_contact_no) }}" class="form-control"
                                                    id="father_contact_no" placeholder="Enter Father's Phone">
                                                @error('father_contact_no')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="father_occupation">Father's Occupation:</label>
                                                <input type="text" name="father_occupation"
                                                    value="{{ old('father_occupation', $student->father_occupation) }}" class="form-control"
                                                    id="father_occupation" placeholder="Enter Father's Occupation">
                                                @error('father_occupation')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mother_name">Mother's Name:</label>
                                                <input type="text" name="mother_name"
                                                    value="{{ old('mother_name', $student->mother_name) }}" class="form-control"
                                                    id="mother_name" placeholder="Enter Mother's Name">
                                                @error('mother_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mother_contact_no">Mother's Phone:</label>
                                                <input type="text" name="mother_contact_no"
                                                    value="{{ old('mother_contact_no', $student->mother_contact_no) }}" class="form-control"
                                                    id="mother_contact_no" placeholder="Enter Mother's Phone">
                                                @error('mother_contact_no')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mother_occupation">Mother's Occupation:</label>
                                                <input type="text" name="mother_occupation"
                                                    value="{{ old('mother_occupation', $student->mother_occupation) }}" class="form-control"
                                                    id="mother_occupation" placeholder="Enter Mother's Occupation">
                                                @error('mother_occupation')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
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
                                            <div class="form-group col-lg-3 col-md-3 mt-2">
                                                <label for="class_id">Level of Study: <span class="text-danger">*</span></label>
                                                <select name="class_id" class="form-control" id="class_id">
                                                    <option value="" selected disabled>Select Level of Study</option>
                                                    @foreach($classes as $class)
                                                        <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                                            {{ $class->class }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('class_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                
                                            <!-- Faculty -->
                                            <div class="form-group col-lg-3 col-md-3 mt-2">
                                                <label for="section_id">Faculty: <span class="text-danger">*</span></label>
                                                <select name="section_id" class="form-control" id="section_id">
                                                    <option value="" selected disabled>Select Faculty</option>
                                                    @foreach($sections as $section)
                                                        <option value="{{ $section->id }}" {{ old('section_id', $student->section_id) == $section->id ? 'selected' : '' }}>
                                                            {{ $section->section_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('section_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                
                                            <!-- Program -->
                                            <div class="form-group col-lg-3 col-md-3 mt-2">
                                                <label for="program_id">Program: <span class="text-danger">*</span></label>
                                                <select name="program_id" class="form-control" id="program_id">
                                                    <option value="" selected disabled>Select Program</option>
                                                    @foreach($programs as $program)
                                                        <option value="{{ $program->id }}" {{ old('program_id', $student->program_id) == $program->id ? 'selected' : '' }}>
                                                            {{ $program->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('program_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                
                                            <!-- Admission Year -->
                                            <div class="form-group col-lg-3 col-md-3 mt-2">
                                                <label for="admission_year">Admission Year: <span class="text-danger">*</span></label>
                                                <input type="text" name="admission_year" value="{{ old('admission_year', $student->admission_year) }}" class="form-control" id="admission_year" placeholder="Enter Admission Year">
                                                @error('admission_year')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                
                                            <!-- Date of Admission -->
                                            <div class="form-group col-lg-3 col-md-3 mt-2">
                                                <label for="date_of_admission">Date of Admission: <span class="text-danger">*</span></label>
                                                <input type="text" 
                                                       name="date_of_admission" value="{{ old('date_of_admission', $student->date_of_admission) }}" class="form-control" id="admission-datepicker" placeholder="Enter Date of Admission">
                                                @error('date_of_admission')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <!-- Academic Program Duration -->
                                            <div class="form-group col-lg-3 col-md-3 mt-2">
                                                <label for="academic_program_duration">Academic Program Duration: <span class="text-danger">*</span></label>
                                                <input type="text" name="academic_program_duration" value="{{ old('academic_program_duration', $student->academic_program_duration) }}" class="form-control" id="academic_program_duration" placeholder="Enter Duration">
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
                                                    value="{{ old('previous_level_of_study', $student->previous_level_of_study ?? '') }}"
                                                    class="form-control" id="previous_level_of_study" placeholder="Enter Previous Level of Study">
                                                @error('previous_level_of_study')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                
                                            <!-- Board/University/College -->
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="previous_board_university_college">Board/University/College: <span class="text-danger">*</span></label>
                                                <input type="text" name="previous_board_university_college"
                                                    value="{{ old('previous_board_university_college', $student->previous_board_university_college ?? '') }}"
                                                    class="form-control" id="previous_board_university_college" placeholder="Enter Board/University/College">
                                                @error('previous_board_university_college')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                
                                            <!-- Registration Number -->
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="previous_registration_no">Registration Number: <span class="text-danger">*</span></label>
                                                <input type="text" name="previous_registration_no"
                                                    value="{{ old('previous_registration_no', $student->previous_registration_no ?? '') }}"
                                                    class="form-control" id="previous_registration_no" placeholder="Enter Registration Number">
                                                @error('previous_registration_no')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                
                                            <!-- Name of Institution -->
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="previous_institution_name">Name of Institution: <span class="text-danger">*</span></label>
                                                <input type="text" name="previous_institution_name"
                                                    value="{{ old('previous_institution_name', $student->previous_institution_name ?? '') }}"
                                                    class="form-control" id="previous_institution_name" placeholder="Enter Name of Institution">
                                                @error('previous_institution_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                
                                            <!-- Attachment of Previous Studies Records -->
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="previous_study_records_attachment">Attachment of Previous Studies Records:</label>
                                                <input type="file" name="previous_study_records_attachment" class="form-control" id="previous_study_records_attachment">
                                                @error('previous_study_records_attachment')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                
                                                @if(!empty($student->previous_study_records_attachment))
                                                    <p class="mt-2">
                                                        <a href="{{ asset('uploads/previous_records/' . $student->previous_study_records_attachment) }}" target="_blank">View Uploaded Document</a>
                                                    </p>
                                                @endif
                                            </div>
                                
                                        </div>
                                    </div>
                                </div>
                                
                                

                                
                                    </div>
                                </div>

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
                document.getElementById("studentUpdateForm").submit();
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
    </script>

    <script>
         $(document).ready(function() {
            $('#studentUpdateForm').on('submit', function(e) {
    e.preventDefault();
    
    var formData = new FormData(this);
    var studentId = formData.get('student_id');
    
    $.ajax({
        url: "{{ route('admin.students.update', ':id') }}".replace(':id', studentId),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-HTTP-Method-Override': 'PUT'
        },
        success: function(response) {
            if (response.success) {
                // Show success message
                alert('Student updated successfully');
                
                // Store current filter values in localStorage
                localStorage.setItem('lastClassId', $('select[name="class_id"]').val());
                localStorage.setItem('lastSectionId', $('select[name="section_id"]').val());
                localStorage.setItem('lastProgramId', $('select[name="program_id"]').val());
                
                // Redirect with search parameters
                window.location.href = "{{ route('admin.students.index') }}?" + 
                    'class_id=' + localStorage.getItem('lastClassId') + 
                    '&section_id=' + localStorage.getItem('lastSectionId') + 
                    (localStorage.getItem('lastProgramId') ? '&program_id=' + localStorage.getItem('lastProgramId') : '') + 
                    '&search=true';
            }
        },
        error: function(xhr) {
            console.error('Error updating student:', xhr);
            alert('Error updating student');
        }
    });
});

         });
    </script>
@endsection
