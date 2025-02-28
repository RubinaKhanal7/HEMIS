@extends('backend.layouts.master')
@section('content')
    <!-- Main content -->
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>
                    {{ $page_title }}
                </h2>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-12">
                        <div class="box box-info" style="padding:5px;">
                            <div class="box-header with-border">
                                <div class="pull-right box-tools">
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ asset('sample-files/sample_staffImport.csv') }}">
                                        <i class="fa fa-download"></i>
                                        Download Sample Import File
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <br />
                                <h5>Guidelines for CSV Upload:</h5>
                                <ol>
                                    <li>Your CSV data should be in the format below. The first line of your CSV file should be the column headers as in the table example. Also make sure that your file is UTF-8 to avoid unnecessary encoding problems.</li>
                                    <li>For date fields (date_of_birth, appointment_date), use the format YYYY-MM-DD (e.g., 2023-06-06).</li>
                                    <li>For gender, use one of: male, female, other.</li>
                                    <li>For ethnicity, use one of: Dalit, Janajati, Madhesi, Muslim, Tharu, Brahmin, Chhetri.</li>
                                    <li>For job_type, use one of: Temporary, Permanent, Contract, Daily Basis.</li>
                                    <li>For category, use one of: Technical, Non-Technical.</li>
                                    <li>For boolean fields (edj, disability_status), use 1 for true or 0 for false.</li>
                                    <li><strong>Important:</strong> All numeric fields will be treated as strings during import, so there's no need to format them specially.</li>
                                </ol>
                                
                                <h5>Required Fields:</h5>
                                <ul>
                                    <li>first_name_nepali, last_name_nepali</li>
                                    <li>first_name_english, last_name_english</li>
                                    <li>mobile_number, date_of_birth, gender</li>
                                    <li>ethnicity, citizenship_id</li>
                                    <li>permanent_province, permanent_district, permanent_local_level, permanent_ward_no</li>
                                    <li>role, level, job_type, category, appointment_date</li>
                                </ul>
                                
                                <h5>Optional Fields:</h5>
                                <ul>
                                    <li>middle_name_nepali, middle_name_english</li>
                                    <li>caste, edj, disability_status</li>
                                    <li>national_id, spouse_name, spouse_occupation</li>
                                    <li>permanent_tole, permanent_house_no</li>
                                    <li>temporary_province, temporary_district, temporary_local_level, temporary_ward_no, temporary_tole, temporary_house_no</li>
                                    <li>email (if not provided, one will be generated)</li>
                                    <li>level_of_study, board_university_college, registration, institution_name (separate multiple values with commas)</li>
                                </ul>
                                <hr />
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12">
                                            <form action="{{ route('admin.staffs.import') }}" id="staffImportForm"
                                                name="staffImportForm" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mb-5">
                                                    <div class="col-sm-12 col-md-12">
                                                        <label>Select file (CSV/Excel):</label><small class="req"> *</small>
                                                        <div class="form-group">
                                                            <input type="file" name="file" required class="form-control" accept=".csv, .xls, .xlsx">
                                                            @error('file')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <button type="submit" class="btn btn-primary" id="saveButton">Import</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection