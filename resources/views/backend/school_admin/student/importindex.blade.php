@extends('backend.layouts.master')
@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
        </div>
    </div>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    @if(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
            @if(session('import_errors'))
                <button class="btn btn-sm btn-outline-warning" type="button" data-toggle="collapse" data-target="#importErrors">
                    Show Errors
                </button>
                <div class="collapse mt-2" id="importErrors">
                    <ul>
                        @foreach(session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <div class="box box-info" style="padding:5px;">
                <div class="box-header with-border">
                    <div class="pull-right box-tools">
                        <a class="btn btn-primary btn-sm" href="{{ asset('sample-files/student_import_sample.csv') }}">
                            <i class="fa fa-download"></i> Download Sample Import File
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <br/>
                    <h4>Important Instructions:</h4>
                    <ol>
                        <li>CSV file should match the format shown below. First line must contain column headers.</li>
                        <li>Ensure your file is UTF-8 encoded to avoid character issues.</li>
                        <li>Dates should be in Y-m-d format (e.g., 2024-02-24).</li>
                        <li>For gender, use: Male, Female, Other</li>
                        <li>Required fields are marked with *</li>
                    </ol>
                    <hr/>
                </div>
                
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><span class="text-danger">*</span>first_name_np</th>
                                <th>middle_name_np</th>
                                <th><span class="text-danger">*</span>last_name_np</th>
                                <th><span class="text-danger">*</span>first_name_en</th>
                                <th>middle_name_en</th>
                                <th><span class="text-danger">*</span>last_name_en</th>
                                <th><span class="text-danger">*</span>mobile_number</th>
                                <th><span class="text-danger">*</span>date_of_birth</th>
                                <th><span class="text-danger">*</span>gender</th>
                                <th>caste</th>
                                <th><span class="text-danger">*</span>ethnicity</th>
                                <th>edj</th>
                                <th>disability_status</th>
                                <th><span class="text-danger">*</span>permanent_district</th>
                                <th><span class="text-danger">*</span>permanent_province</th>
                                <th><span class="text-danger">*</span>permanent_local_level</th>
                                <th><span class="text-danger">*</span>permanent_ward_no</th>
                                <th><span class="text-danger">*</span>admission_year</th>
                                <th><span class="text-danger">*</span>date_of_admission</th>
                                <th><span class="text-danger">*</span>academic_program_duration</th>
                                <th><span class="text-danger">*</span>previous_level_of_study</th>
                                <th><span class="text-danger">*</span>previous_board_university_college</th>
                                <th><span class="text-danger">*</span>previous_registration_no</th>
                                <th><span class="text-danger">*</span>previous_institution_name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>राम</td>
                                <td>प्रसाद</td>
                                <td>शर्मा</td>
                                <td>Ram</td>
                                <td>Prasad</td>
                                <td>Sharma</td>
                                <td>9876543210</td>
                                <td>2000-01-01</td>
                                <td>Male</td>
                                <td>Brahmin</td>
                                <td>Khas Arya</td>
                                <td>No</td>
                                <td>None</td>
                                <td>Kathmandu</td>
                                <td>Bagmati</td>
                                <td>Kathmandu</td>
                                <td>10</td>
                                <td>2024</td>
                                <td>2024-02-24</td>
                                <td>4</td>
                                <td>+2</td>
                                <td>NEB</td>
                                <td>12345</td>
                                <td>ABC School</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <form action="{{ route('admin.students.bulkimport') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 d-flex justify-content-between">
                                <div class="col-lg-3 col-sm-3 mt-2">
                                    <label for="class_id">Level:</label>
                                    <select name="class_id" class="form-control" required>
                                        <option value="">Select Level</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->class }}</option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="col-lg-3 col-sm-3 mt-2">
                                    <label for="section_id">Faculty:</label>
                                    <select name="section_id" class="form-control" required>
                                        <option value="">Select Faculty</option>
                                    </select>
                                    @error('section_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-3 col-sm-3 mt-2">
                                    <label for="program_id">Program:</label>
                                    <select name="program_id" class="form-control" required>
                                        <option value="">Select Program</option>
                                    </select>
                                    @error('program_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <label for="file">Select CSV/Excel File:</label>
                                    <input type="file" name="file" id="file" class="form-control" required accept=".csv,.xlsx,.xls">
                                    <small class="form-text text-muted">Allowed file types: CSV, Excel (.xlsx, .xls). Max size: 2MB</small>
                                    @error('file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fa fa-upload"></i> Import Students
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
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
</script>
@endsection