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
                            <form id="regForm" action="{{ route('admin.students.update', $student->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <!--This indicates the steps of the form: -->
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
                                                <label for="f_name">First Name (English):</label>
                                                <input type="text" name="f_name"
                                                    value="{{ old('f_name', $student->user->f_name) }}"
                                                    class="form-control" id="f_name" placeholder="Enter First Name">
                                                @error('f_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="f_name">First Name (Nepali):</label>
                                                <input type="text" name="f_name"
                                                    value="{{ old('f_name', $student->user->f_name) }}"
                                                    class="form-control" id="f_name" placeholder="Enter First Name">
                                                @error('f_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="m_name">Middle Name (English):</label>
                                                <input type="text" name="m_name"
                                                    value="{{ old('m_name', $student->user->m_name) }}"
                                                    class="form-control" id="m_name" placeholder="Enter Middle Name">
                                                @error('m_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="m_name">Middle Name (Nepali):</label>
                                                <input type="text" name="m_name"
                                                    value="{{ old('m_name', $student->user->m_name) }}"
                                                    class="form-control" id="m_name" placeholder="Enter Middle Name">
                                                @error('m_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="l_name">Last Name (English):</label>
                                                <input type="text" name="l_name"
                                                    value="{{ old('l_name', $student->user->l_name) }}"
                                                    class="form-control" id="l_name" placeholder="Enter Last Name">
                                                @error('l_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="l_name">Last Name (Nepali):</label>
                                                <input type="text" name="l_name"
                                                    value="{{ old('l_name', $student->user->l_name) }}"
                                                    class="form-control" id="l_name" placeholder="Enter Last Name">
                                                @error('l_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="email">Email:</label>
                                                <input type="text" name="email"
                                                    value="{{ old('email', $student->user->email) }}"
                                                    class="form-control" id="email" placeholder="Enter Email">
                                                @error('email')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mobile_number">Mobile No. :</label>
                                                <input type="text" name="mobile_number"
                                                    value="{{ old('mobile_number', $student->user->mobile_number) }}"
                                                    class="form-control" id="mobile_number"
                                                    placeholder="Enter Mobile Number">
                                                @error('mobile_number')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="dob">Date of Birth:</label>
                                                <input type="text" name="dob"
                                                    value="{{ old('dob', $student->user->dob) }}" class="form-control"
                                                    id="dob-datepicker" placeholder="Enter DOB">
                                                @error('dob')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="phone">Gender:</label><br>

                                                <label for="gender_male" class="l-radio">
                                                    <input type="radio" name="gender" value="Male" id="gender_male"
                                                        {{ old('gender', $student->user->gender) == 'Male' ? 'checked' : '' }}>
                                                    <span>Male</span>
                                                </label>

                                                <label for="gender_female" class="l-radio">
                                                    <input type="radio" name="gender" value="Female"
                                                        id="gender_female"
                                                        {{ old('gender', $student->user->gender) == 'Female' ? 'checked' : '' }}>
                                                    <span>Female</span>
                                                </label>
                                                
                                                @error('gender')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="caste ">Caste :</label>
                                                <input type="text" name="caste"
                                                    value="{{ old('caste', $student->user->caste) }}"
                                                    class="form-control" id="caste" placeholder="Enter Caste">
                                                @error('caste')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="edj ">EDJ :</label>
                                                <input type="text" name="edj"
                                                    value="{{ old('edj', $student->user->edj) }}"
                                                    class="form-control" id="edj" placeholder="Enter EDJ">
                                                @error('edj')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label>Disability Status:</label>
                                                <div>
                                                    <label class="mr-3">
                                                        <input type="radio" name="disability_status" value="yes" {{ old('disability_status', $student->user->disability_status) == 'yes' ? 'checked' : '' }}> Yes
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="disability_status" value="no" {{ old('disability_status', $student->user->disability_status) == 'no' ? 'checked' : '' }}> No
                                                    </label>
                                                </div>
                                                @error('disability_status')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="citizenship">Citizenship Id:</label>
                                                <input type="text" name="citizenship" value="{{ old('citizenship', $student->user->citizenship) }}" class="form-control" id="citizenship" placeholder="Enter Citizenship">
                                                @error('citizenship')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="national_id">National ID:</label>
                                                <input type="text" name="national_id" value="{{ old('national_id', $student->user->national_id) }}" class="form-control" id="national_id" placeholder="Enter National ID">
                                                @error('national_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-12 col-lg-12 mt-4">
                                                <div class="hr-line-dashed"></div>
                                                <h5>Student's Picture:</h5>
                                                <div class="col-lg-4">
                                                    @if ($student->user->image)
                                                        <img src="{{ asset($student->user->image) }}" id="image"
                                                            style="width: 20%;">
                                                    @else
                                                        <img src="" id="image" style="width: 20%;">
                                                    @endif
                                                    <div class="form-group">
                                                        <input type="file" id="imageFile" class="form-control"
                                                            placeholder="Image" name="image" data-ratio="16"
                                                            data-ratiowidth="16">
                                                    </div>
                                                    <div id="previewWrapper" class="hidden">
                                                        <br>
                                                        <img id="croppedImagePreview" height="150"><br>
                                                        <input type="hidden" name="inputCroppedPic" id="inputCroppedPic"
                                                            tabindex="-1">
                                                        <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm"
                                                            type="button" id="removeCroppedImage"
                                                            style="margin-top: 7px;">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="citizenship_front">Citizenship Front:</label>
                                            
                                                @php
                                                    $citizenshipImages = json_decode($student->user->citizenship_pic, true);
                                                    $citizenshipFront = $citizenshipImages['front'] ?? null;
                                                    $citizenshipBack = $citizenshipImages['back'] ?? null;
                                                @endphp
                                            
                                                @if (!empty($citizenshipFront))
                                                    <div class="mb-2">
                                                        <img src="{{ asset('uploads/citizenship/' . $citizenshipFront) }}" alt="Citizenship Front" class="img-thumbnail" width="100">
                                                    </div>
                                                @endif
                                            
                                                <input type="file" name="citizenship_pic[front]" class="form-control" id="citizenship_front" accept="image/*">
                                            
                                                @error('citizenship_pic.front')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="citizenship_back">Citizenship Back:</label>
                                            
                                                @if (!empty($citizenshipBack))
                                                    <div class="mb-2">
                                                        <img src="{{ asset('uploads/citizenship/' . $citizenshipBack) }}" alt="Citizenship Back" class="img-thumbnail" width="100">
                                                    </div>
                                                @endif
                                            
                                                <input type="file" name="citizenship_pic[back]" class="form-control" id="citizenship_back" accept="image/*">
                                            
                                                @error('citizenship_pic.back')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            
                                            

                                        </div>

                                    </div>

                                    
                                    <div class="hr-line-dashed mt-4"></div>
                                    <h5 class="">Student's Permanent Address:</h5>

                                    <div class="hr-line-dashed"></div>
                                    <div class="col-md-12 col-lg-12 d-flex justify-content-around">

                                        <div class="col-md-6 col-lg-6 col-sm-6 pt-4 pb-4 d-flex  gap-3">
                                            <div class="">
                                                <label for="state_id">Choose Province</label>
                                                <div class="select">
                                                    <select name="state_id" id="state_id" data-iteration="0"
                                                        class="state_id">
                                                        @foreach ($states as $state)
                                                            <option value="{{ $state->id }}"
                                                                {{ old('state_id', $student->user->state_id) == $state->id ? 'selected' : '' }}>
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
                                                <label for="district_id">Choose District</label>

                                                <div class="select">

                                                    <select id="district_id" name="district_id" data-iteration="0"
                                                        class="district_id" required>
                                                        <option disabled selected value>Choose District</option>
                                                        @foreach ($districts as $district)
                                                            <option value="{{ $district->id }}"
                                                                {{ old('district_id', $student->user->district_id) == $district->id ? 'selected' : '' }}>
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
                                        <div class="col-md-6 col-lg-6 pt-4 pb-4 d-flex  gap-3">
                                            <div class="">
                                                <label for="municipalitiy_id">Choose Municipality</label>

                                                <div class="select">

                                                    <select id="municipalitiy_id" name="municipality_id" data-iteration="0"
                                                        class="municipality_id" required>
                                                        <option value="">Choose Municipality</option>
                                                        @foreach ($municipalities as $municipality)
                                                            <option value="{{ $municipality->id }}"
                                                                {{ old('municipality_id', $student->user->municipality_id) == $municipality->id ? 'selected' : '' }}>
                                                                {{ $municipality->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('municipalitiy_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="">
                                                <label for="ward_id">Choose Ward</label>
                                                <div class="select">

                                                    <select id="ward_id" name="ward_id" data-iteration="0"
                                                        class="ward_id" required>
                                                        <option value="">Choose Ward</option>
                                                        @foreach ($wards as $ward)
                                                            <option value="{{ $ward->id }}"
                                                                {{ old('ward_id', $student->user->ward_id) == $ward->id ? 'selected' : '' }}>
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

                                        <div class=" col-lg-4 col-sm-4">
                                            <label for="tole">Tole:</label>
                                            <input type="text" name="tole"
                                                value="{{ old('tole', $student->user->tole) }}"
                                                class="form-control" id="tole"
                                                placeholder="Enter Tole">
                                            @error('tole')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="house_number">House Number:</label>
                                            <input type="text" name="house_number"
                                                value="{{ old('house_number', $student->user->house_number) }}"
                                                class="form-control" id="house_number"
                                                placeholder="Enter House Number">
                                            @error('house_number')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>


                                    </div>
                                    <div class="hr-line-dashed mt-4"></div>
                                    <h5 class="">Student's Temporary Address:</h5>

                                    <div class="hr-line-dashed"></div>
                                    <div class="col-md-12 col-lg-12 d-flex justify-content-around">

                                        <div class="col-md-6 col-lg-6 col-sm-6 pt-4 pb-4 d-flex  gap-3">
                                            <div class="">
                                                <label for="state_id">Choose Province</label>
                                                <div class="select">
                                                    <select name="state_id" id="state_id" data-iteration="0"
                                                        class="state_id">
                                                        @foreach ($states as $state)
                                                            <option value="{{ $state->id }}"
                                                                {{ old('state_id', $student->user->state_id) == $state->id ? 'selected' : '' }}>
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
                                                <label for="district_id">Choose District</label>

                                                <div class="select">

                                                    <select id="district_id" name="district_id" data-iteration="0"
                                                        class="district_id" required>
                                                        <option disabled selected value>Choose District</option>
                                                        @foreach ($districts as $district)
                                                            <option value="{{ $district->id }}"
                                                                {{ old('district_id', $student->user->district_id) == $district->id ? 'selected' : '' }}>
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
                                        <div class="col-md-6 col-lg-6 pt-4 pb-4 d-flex  gap-3">
                                            <div class="">
                                                <label for="municipalitiy_id">Choose Municipality</label>

                                                <div class="select">

                                                    <select id="municipalitiy_id" name="municipality_id" data-iteration="0"
                                                        class="municipality_id" required>
                                                        <option value="">Choose Municipality</option>
                                                        @foreach ($municipalities as $municipality)
                                                            <option value="{{ $municipality->id }}"
                                                                {{ old('municipality_id', $student->user->municipality_id) == $municipality->id ? 'selected' : '' }}>
                                                                {{ $municipality->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('municipalitiy_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="">
                                                <label for="ward_id">Choose Ward</label>
                                                <div class="select">

                                                    <select id="ward_id" name="ward_id" data-iteration="0"
                                                        class="ward_id" required>
                                                        <option value="">Choose Ward</option>
                                                        @foreach ($wards as $ward)
                                                            <option value="{{ $ward->id }}"
                                                                {{ old('ward_id', $student->user->ward_id) == $ward->id ? 'selected' : '' }}>
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

                                        <div class=" col-lg-4 col-sm-4">
                                            <label for="tole">Tole:</label>
                                            <input type="text" name="tole"
                                                value="{{ old('tole', $student->user->tole) }}"
                                                class="form-control" id="tole"
                                                placeholder="Enter Tole">
                                            @error('tole')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="house_number">House Number:</label>
                                            <input type="text" name="house_number"
                                                value="{{ old('house_number', $student->user->house_number) }}"
                                                class="form-control" id="house_number"
                                                placeholder="Enter House Number">
                                            @error('house_number')
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
                                                    value="{{ old('father_name', $student->user->father_name) }}"
                                                    class="form-control" id="father_name"
                                                    placeholder="Enter Father's Name">
                                                @error('father_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="father_phone">Father's Phone:</label>
                                                <input type="text" name="father_phone"
                                                    value="{{ old('father_phone', $student->user->father_phone) }}"
                                                    class="form-control" id="father_phone"
                                                    placeholder="Enter Father's Phone">
                                                @error('father_phone')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="">Email:</label>
                                                <input type="text" name="father_email"
                                                    value="{{ old('father_email', $student->user->father_email) }}"
                                                    class="form-control" id="father_email"
                                                    placeholder="Enter Email">
                                                @error('father_email')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="">Father's Occupation:</label>
                                                <input type="text" name="father_occupation"
                                                    value="{{ old('father_occupation', $student->user->father_occupation) }}"
                                                    class="form-control" id="father_occupation"
                                                    placeholder="Enter Father's Occupation">
                                                @error('father_occupation')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mother_name">Mother's Name:</label>
                                                <input type="text" name="mother_name"
                                                    value="{{ old('mother_name', $student->user->mother_name) }}"
                                                    class="form-control" id="mother_name"
                                                    placeholder="Enter Mother's Name">
                                                @error('mother_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mother_phone">Mother's Phone:</label>
                                                <input type="text" name="mother_phone"
                                                    value="{{ old('mother_phone', $student->user->mother_phone) }}"
                                                    class="form-control" id="mother_phone"
                                                    placeholder="Enter Mother's Phone">
                                                @error('mother_phone')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="">Email:</label>
                                                <input type="text" name="mother_email"
                                                    value="{{ old('mother_email', $student->user->mother_email) }}"
                                                    class="form-control" id="mother_email"
                                                    placeholder="Enter Email">
                                                @error('mother_email')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mother_occupation">Mother's Occupation:</label>
                                                <input type="text" name="mother_occupation"
                                                    value="{{ old('mother_occupation', $student->user->mother_occupation) }}"
                                                    class="form-control" id="mother_occupation"
                                                    placeholder="Enter Mother's Occupation">
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
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="level_of_study">Level of Study:</label>
                                                <input type="text" name="level_of_study"
                                                    value="{{ old('level_of_study', $student->academic->level_of_study ?? '') }}"
                                                    class="form-control" id="level_of_study" placeholder="Enter Level of Study">
                                                @error('level_of_study')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="faculty">Faculty:</label>
                                                <input type="text" name="faculty"
                                                    value="{{ old('faculty', $student->academic->faculty ?? '') }}"
                                                    class="form-control" id="faculty" placeholder="Enter Faculty">
                                                @error('faculty')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="program">Program:</label>
                                                <input type="text" name="program"
                                                    value="{{ old('program', $student->academic->program ?? '') }}"
                                                    class="form-control" id="program" placeholder="Enter Program">
                                                @error('program')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="admission_year">Admission Year (Batch):</label>
                                                <input type="text" name="admission_year"
                                                    value="{{ old('admission_year', $student->academic->admission_year ?? '') }}"
                                                    class="form-control" id="admission_year" placeholder="Enter Admission Year">
                                                @error('admission_year')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="date_of_admission">Date of Admission:</label>
                                                <input type="date" name="date_of_admission"
                                                    value="{{ old('date_of_admission', $student->academic->date_of_admission ?? '') }}"
                                                    class="form-control" id="date_of_admission">
                                                @error('date_of_admission')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="program_duration">Academic Program Duration:</label>
                                                <input type="text" name="program_duration"
                                                    value="{{ old('program_duration', $student->academic->program_duration ?? '') }}"
                                                    class="form-control" id="program_duration" placeholder="Enter Duration">
                                                @error('program_duration')
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

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="previous_level_of_study">Name of Level of Study:</label>
                                                <input type="text" name="previous_level_of_study"
                                                    value="{{ old('previous_level_of_study', $student->previousAcademic->level_of_study ?? '') }}"
                                                    class="form-control" id="previous_level_of_study" placeholder="Enter Previous Level of Study">
                                                @error('previous_level_of_study')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="previous_board">Board/University/College:</label>
                                                <input type="text" name="previous_board"
                                                    value="{{ old('previous_board', $student->previousAcademic->board ?? '') }}"
                                                    class="form-control" id="previous_board" placeholder="Enter Board/University/College">
                                                @error('previous_board')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="previous_registration">Registration Number:</label>
                                                <input type="text" name="previous_registration"
                                                    value="{{ old('previous_registration', $student->previousAcademic->registration ?? '') }}"
                                                    class="form-control" id="previous_registration" placeholder="Enter Registration Number">
                                                @error('previous_registration')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="previous_institution">Name of Institution:</label>
                                                <input type="text" name="previous_institution"
                                                    value="{{ old('previous_institution', $student->previousAcademic->institution ?? '') }}"
                                                    class="form-control" id="previous_institution" placeholder="Enter Name of Institution">
                                                @error('previous_institution')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="previous_records_attachment">Attachment of Previous Studies Records:</label>
                                                <input type="file" name="previous_records_attachment" class="form-control" id="previous_records_attachment">
                                                @error('previous_records_attachment')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                
                                                @if(!empty($student->previousAcademic->records_attachment))
                                                    <p class="mt-2">
                                                        <a href="{{ asset('uploads/previous_records/' . $student->previousAcademic->records_attachment) }}" target="_blank">View Uploaded Document</a>
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
        $(document).ready(function() {

            toggleGuardianFields();

            // Your other JavaScript code here...

            // Attach change event handlers to the radio buttons
            $('input[name="guardian_is"]').change(function() {
                toggleGuardianFields();
            });

            // Attach change event handler to the class dropdown
            $('select[name="class_id"]').change(function() {
                // Get the selected class ID
                var classId = $(this).val();

                // Fetch sections based on the selected class ID
                $.ajax({
                    url: 'get-sections/' + classId, // Replace with the actual route
                    type: 'GET',
                    success: function(data) {
                        // Clear existing options
                        $('select[name="section_id"]').empty();

                        // Add the default option
                        $('select[name="section_id"]').append(
                            '<option disabled>Select Section</option>');

                        // Add new options based on the fetched sections
                        $.each(data, function(key, value) {
                            $('select[name="section_id"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    }
                });
            });
        });
    </script>

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";

            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }

            if (n == (x.length - 1)) {
                // If it's the last tab, hide the "Next" button and show the "Submit" button
                document.getElementById("nextBtn").style.display = "none";
                document.getElementById("submitBtn").style.display = "inline";
            } else {
                // If it's not the last tab, show the "Next" button and hide the "Submit" button
                document.getElementById("nextBtn").style.display = "inline";
                document.getElementById("submitBtn").style.display = "none";
            }

            fixStepIndicator(n);
        }


        // function nextPrev(n) {
        //     // This function will figure out which tab to display
        //     var x = document.getElementsByClassName("tab");
        //     // Exit the function if any field in the current tab is invalid:
        //     if (n == 1 && !validateForm()) return false;
        //     // Hide the current tab:
        //     x[currentTab].style.display = "none";
        //     // Increase or decrease the current tab by 1:
        //     currentTab = currentTab + n;
        //     // if you have reached the end of the form... :
        //     if (currentTab >= x.length) {
        //         //...the form gets submitted:
        //         document.getElementById("regForm").submit();
        //         return false;
        //     }
        //     // Otherwise, display the correct tab:
        //     showTab(currentTab);
        // }

        function nextPrev(n) {
            var x = document.getElementsByClassName("tab");
            if (n == 1 && !validateForm()) return false;
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
                // Use AJAX to submit the form
                submitFormWithAjax();
                return false;
            }
            showTab(currentTab);
        }

        function submitFormWithAjax() {
            var form = document.getElementById("regForm");
            var formData = new FormData(form);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", form.action);
            xhr.setRequestHeader("X-CSRF-TOKEN", formData.get('_token'));
            xhr.setRequestHeader("X-HTTP-Method-Override", form.method);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    // Handle the response or redirect as needed
                }
            };
            xhr.send(formData);
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

            // $(document).on('change', '.state_id', function() {
            //     var state_id = $(this).val();
            //     // Retrieve and log the data attribute value
            //     var currentiteration = $(this).data("iteration");
            //     var append_to = 'district_id';
            //     $.ajax({
            //         url: '/admin/get-district-by-state/' + state_id,
            //         type: 'GET',
            //         success: function(response) {
            //             var clearThisData = $('#' + append_to + '').empty();
            //             if (response.length > 0) {
            //                 $('#' + append_to + '').append(
            //                     '<option disabled value="">Choose District</option>');
            //                 $.each(response, function(key, value) {
            //                     $('#' + append_to + '').append('<option value="' + value
            //                         .id + '" ' + (value.id == selectedDistrictId ?
            //                             'selected' : '') +
            //                         '>' + value.name + '</option>');
            //                 });
            //             } else {
            //                 $('#' + append_to + '').append(
            //                     '<option value="">No districts found</option>');
            //             }

            //             // Clear the municipalities dropdown when the state changes
            //             $('#municipalitiy_id').empty().append(
            //                 '<option value="">Choose Municipality</option>');
            //         },
            //         error: function() {
            //             console.log("error in the ajax");
            //         }
            //     });
            // });



            $(document).on('change', '.state_id', function() {
                var state_id = $(this).val();
                // Retrieve and log the data attribute value
                var currentiteration = $(this).data("iteration");
                var append_to = 'district_id';
                $.ajax({
                    url: '/admin/get-district-by-state/' + state_id,
                    type: 'GET',
                    success: function(response) {
                        var clearThisData = $('#' + append_to + '').empty();
                        if (response.length > 0) {
                            $('#' + append_to + '').append(
                                '<option disabled selected value>Choose District</option>');
                            $.each(response, function(key, value) {
                                $('#' + append_to + '').append('<option value="' + value
                                    .id +
                                    '">' + value.name + '</option>');
                            });
                        } else {
                            $('#' + append_to + '').append(
                                '<option value="">No districts found</option>');
                        }

                        // Clear the municipalities dropdown when the state changes
                        $('#municipalitiy_id').empty().append(
                            '<option value="">Choose Municipality</option>');
                    },
                    error: function() {
                        console.log("error in the ajax");
                    }
                });
            });

            $(document).on('change', '.district_id', function() {
                var district_id = $(this).val();
                var append_to = 'municipalitiy_id';
                $.ajax({
                    url: '/admin/get-municipality-by-district/' + district_id,
                    type: 'GET',
                    success: function(response) {
                        var clearThisData = $('#' + append_to + '').empty();
                        if (response.length > 0) {
                            $('#' + append_to + '').append(
                                '<option disabled selected value>Choose Municipality</option>'
                            );
                            $.each(response, function(key, value) {
                                $('#' + append_to + '').append('<option value="' + value
                                    .id +
                                    '">' + value.name + '</option>');
                            });
                        } else {
                            $('#' + append_to + '').append(
                                '<option value="">No municipalities found</option>');
                        }
                    },
                    error: function() {
                        console.log("error in the ajax");
                    }
                });
            });

            $(document).on('change', '.municipality_id', function() {
                var municipality_id = $(this).val();
                var append_to = 'ward_id';
                $.ajax({
                    url: '/admin/get-ward-by-municipality/' + municipality_id,
                    type: 'GET',
                    success: function(response) {
                        var clearThisData = $('#' + append_to + '').empty();
                        if (response.length > 0) {
                            $('#' + append_to + '').append(
                                '<option disabled selected value>Choose Ward</option>');
                            $.each(response, function(key, value) {
                                $('#' + append_to + '').append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        } else {
                            $('#' + append_to + '').append(
                                '<option value="">No wards found</option>');
                        }
                    },
                    error: function() {
                        console.log("error in the ajax");
                    }
                });
            });

        });
    </script>

    <script>
        function toggleGuardianFields() {
            var otherFieldsContainer = document.getElementById('otherGuardianFields');
            var guardianOtherRadio = document.getElementById('guardian_other');

            if (guardianOtherRadio.checked) {
                otherFieldsContainer.style.display = 'flex'; // Show the additional fields
                otherFieldsContainer.style.flexWrap = 'wrap'; // Show the additional fields
                otherFieldsContainer.style.justifyContent = 'space-between'; // Show the additional fields
                otherFieldsContainer.style.gap = '3px'; // Show the additional fields
            } else {
                otherFieldsContainer.style.display = 'none'; // Hide the additional fields
            }
        }
    </script>
@endsection
