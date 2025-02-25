@extends('backend.layouts.master')


@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Student Reports</h1>
   
    <!-- Add total student count display -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Total Students</h5>
                           
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $totalStudentsCount ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        @if(request()->has('admission_year') || request()->has('program_id') || request()->has('class_id') ||
            request()->has('gender') || request()->has('ethnicity') ||
            request()->has('permanent_province') || request()->has('permanent_district'))
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Filtered Students</h5>
                           
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $filteredCount ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
   
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.school_attendance_reports.index') }}" method="GET" id="filterForm">
                <div class="row g-3">
                    <!-- Admission Year -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="admission_year">Fiscal Year</label>
                            <select name="admission_year" id="admission_year" class="form-select select2">
                                <option value="">Select Year</option>
                                @foreach($admissionYears as $year)
                                    <option value="{{ $year }}" {{ request('admission_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Class -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="class_id">Academic Level</label>
                            <select name="class_id" id="class_id" class="form-select select2">
                                <option value="">Select Academic Level</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->class }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Section -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="class_id">Faculty</label>
                            <select name="class_id" id="class_id" class="form-select select2">
                                <option value="">Select Faculty</option>
                                @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>{{ $section->section_name }}</option>


                                @endforeach
                            </select>
                        </div>
                    </div>




                    <!-- Program -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="program_id">Program</label>
                            <select name="program_id" id="program_id" class="form-select select2">
                                <option value="">Select Program</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>{{ $program->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Gender -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-select select2">
                                <option value="">Select Gender</option>
                                @foreach(['Male', 'Female', 'Other'] as $gender)
                                    <option value="{{ $gender }}" {{ request('gender') == $gender ? 'selected' : '' }}>{{ $gender }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Ethnicity -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="ethnicity">Ethnicity</label>
                            <select name="ethnicity" id="ethnicity" class="form-select select2">
                                <option value="">Select Ethnicity</option>
                                @foreach($ethnicities as $ethnicity)
                                    <option value="{{ $ethnicity }}" {{ request('ethnicity') == $ethnicity ? 'selected' : '' }}>{{ $ethnicity }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Province -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="permanent_province">Province</label>
                            <select name="permanent_province" id="permanent_province" class="form-select select2">
                                <option value="">Select Province</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ request('permanent_province') == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- District -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="permanent_district">District</label>
                            <select name="permanent_district" id="permanent_district" class="form-select select2">
                                <option value="">Select District</option>
                                @if(request('permanent_province'))
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" {{ request('permanent_district') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>


                    <!-- Search Button -->
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('admin.school_attendance_reports.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Results Table -->
    @if($students->isNotEmpty())
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Student List</h5>
        </div>
        <div class="card-body">
            <div id="table-container">
                <div class="table-responsive">
                    <table id="studentTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Program</th>
                                <th>Class</th>
                                <th>Ethnicity</th>
                                <th>Province</th>
                                <th>District</th>
                                <th>Mobile</th>
                                <th>Admission Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->first_name_en }}</td>
                                    <td>{{ $student->gender }}</td>
                                    <td>{{ $student->program->title }}</td>
                                    <td>{{ $student->class->class }}</td>
                                    <td>{{ $student->ethnicity }}</td>
                                    <td>{{ $student->permanent_province }}</td>
                                    <td>{{ $student->permanent_district }}</td>
                                    <td>{{ $student->mobile_number }}</td>
                                    <td>{{ $student->admission_year }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info mt-4">No data found. Please apply filters and search.</div>
    @endif
</div>


@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable without export buttons
        var table = $('#studentTable').DataTable();
       
        // Initialize select2
        $('.select2').select2({
            width: '100%'
        });
       
        // Make district dropdown dependent on province selection
        $('#permanent_province').on('change', function() {
            var provinceId = $(this).val();
           
            // Clear and disable district dropdown if no province selected
            if (!provinceId) {
                $('#permanent_district').empty();
                $('#permanent_district').append('<option value="">Select District</option>');
                return;
            }
           
            // Make AJAX call to get districts for selected province
            $.ajax({
                url: '/get-districts/' + provinceId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#permanent_district').empty();
                    $('#permanent_district').append('<option value="">Select District</option>');
                   
                    if (data && data.length > 0) {
                        $.each(data, function(key, district) {
                            $('#permanent_district').append('<option value="' + district.id + '">' + district.name + '</option>');
                        });
                    } else {
                        $('#permanent_district').append('<option value="">No districts found</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching districts:', error);
                    console.log('Status:', status);
                    console.log('Response:', xhr.responseText);
                   
                    $('#permanent_district').empty();
                    $('#permanent_district').append('<option value="">Error loading districts</option>');
                }
            });
        });
       
        // Trigger change event if province is already selected (for page reload)
        if ($('#permanent_province').val()) {
            $('#permanent_province').trigger('change');
        }
    });
</script>
@endpush
@endsection

