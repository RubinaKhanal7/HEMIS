@extends('backend.layouts.master')
@section('content')
<style>
    .container-fluid {
        padding-left: 0;
        padding-right: 0;
    }
    #table-container {
        width: 100%;
        overflow-x: auto;
    }
    #buttons-container {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    #buttons-container .dt-buttons {
        display: flex;
        flex-direction: row;
    }
    #buttons-container .dt-buttons button {
        margin-right: 5px;
    }
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
    }
    #staffTable {
        width: 100% !important;
    }
</style>
<div class="container-fluid">
    <h1>Staff Reports</h1>
    <form action="{{ route('admin.staff_reports.report') }}" method="GET">
        <div class="row align-items-end">
            <div class="col-lg-3 col-sm-3 mt-2">
                <div class="p-2 label-input">
                    <label for="fiscal-year">Fiscal Year:</label>
                    <div class="form-group">
                        <select name="fiscal_year" id="fiscal-year" class="form-control">
                            <option value="">All Fiscal Years</option>
                            <option value="1">2022/2023</option>
                            <option value="2">2023/2024</option>
                            <option value="3">2024/2025</option>
                        </select>
                    </div>
                </div>
            </div>
           
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="academic_level">Academic Level:</label>
                    <select name="academic_level" id="academic_level" class="form-control select2" multiple>
                        <option value="1">Bachelor</option>
                        <option value="2">Master</option>
                        <option value="3">PhD</option>
                    </select>
                </div>
            </div>
           
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="faculty">Faculty:</label>
                    <select name="faculty" id="faculty" class="form-control select2" multiple>
                        <option value="1">Engineering</option>
                        <option value="2">Management</option>
                        <option value="3">Science</option>
                        <option value="4">Arts</option>
                    </select>
                </div>
            </div>
                             
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="program">Program:</label>
                    <select name="program" id="program" class="form-control select2" multiple>
                        <option value="1">Computer Science</option>
                        <option value="2">Civil Engineering</option>
                        <option value="3">Business Administration</option>
                        <option value="4">Fine Arts</option>
                    </select>
                </div>
            </div>
           
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select name="gender" id="gender" class="form-control select2" multiple>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
           
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="caste">Caste:</label>
                    <select name="caste" id="caste" class="form-control select2" multiple>
                        <option value="1">Brahmin</option>
                        <option value="2">Chhetri</option>
                        <option value="3">Tamang</option>
                        <option value="4">Newar</option>
                    </select>
                </div>
            </div>
           
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="ethnicity">Ethnicity:</label>
                    <select name="ethnicity" id="ethnicity" class="form-control select2" multiple>
                        <option value="1">Khas Arya</option>
                        <option value="2">Janajati</option>
                        <option value="3">Madhesi</option>
                        <option value="4">Dalit</option>
                    </select>
                </div>
            </div>
           
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" name="full_name" id="full_name" class="form-control">
                </div>
            </div>
           
            <div class="col-lg-3 col-sm-3 mt-2">
                <div class="search-button-container d-flex align-items-end">
                    <button type="submit" class="btn btn-sm btn-primary">Search</button>
                    <button type="reset" class="btn btn-sm btn-secondary ml-2">Reset</button>
                </div>
            </div>
        </div>
    </form>
   
    <div id="table-container" class="mt-4">
        <div id="buttons-container"></div>
        <table id="staffTable" class="table table-striped table-bordered w-100">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Full Name</th>
                    <th>Gender</th>
                    <th>Faculty</th>
                    <th>Program</th>
                    <th>Academic Level</th>
                    <th>Caste</th>
                    <th>Ethnicity</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ST001</td>
                    <td>John Doe</td>
                    <td>Male</td>
                    <td>Engineering</td>
                    <td>Computer Science</td>
                    <td>PhD</td>
                    <td>Brahmin</td>
                    <td>Khas Arya</td>
                    <td>9801234567</td>
                    <td>john.doe@example.com</td>
                </tr>
                <tr>
                    <td>ST002</td>
                    <td>Jane Smith</td>
                    <td>Female</td>
                    <td>Management</td>
                    <td>Business Administration</td>
                    <td>Master</td>
                    <td>Chhetri</td>
                    <td>Khas Arya</td>
                    <td>9807654321</td>
                    <td>jane.smith@example.com</td>
                </tr>
                <tr>
                    <td>ST003</td>
                    <td>Ram Thapa</td>
                    <td>Male</td>
                    <td>Science</td>
                    <td>Physics</td>
                    <td>PhD</td>
                    <td>Tamang</td>
                    <td>Janajati</td>
                    <td>9812345678</td>
                    <td>ram.thapa@example.com</td>
                </tr>
                <tr>
                    <td>ST004</td>
                    <td>Sita Sharma</td>
                    <td>Female</td>
                    <td>Arts</td>
                    <td>Fine Arts</td>
                    <td>Bachelor</td>
                    <td>Newar</td>
                    <td>Janajati</td>
                    <td>9823456789</td>
                    <td>sita.sharma@example.com</td>
                </tr>
                <tr>
                    <td>ST005</td>
                    <td>Hari Prasad</td>
                    <td>Male</td>
                    <td>Engineering</td>
                    <td>Civil Engineering</td>
                    <td>Master</td>
                    <td>Brahmin</td>
                    <td>Khas Arya</td>
                    <td>9834567890</td>
                    <td>hari.prasad@example.com</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Initialize select2 for multiple selection
        $('.select2').select2({
            placeholder: "Select options",
            allowClear: true
        });
   
        // Initialize DataTables with static data
        var table = $('#staffTable').DataTable({
            dom: '<"d-flex justify-content-between"lfB>rtip',
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-sm btn-primary'
                    }
                },
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                container: '#buttons-container'
            },
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ordering: true,
            language: {
                emptyTable: "No matching records found"
            }
        });


        // Client-side filtering when form is submitted
        $('form').on('submit', function(e) {
            e.preventDefault();
           
            // Get filter values
            var fiscalYear = $('#fiscal-year').val();
            var academicLevels = $('#academic_level').val();
            var faculties = $('#faculty').val();
            var programs = $('#program').val();
            var genders = $('#gender').val();
            var castes = $('#caste').val();
            var ethnicities = $('#ethnicity').val();
            var fullName = $('#full_name').val().toLowerCase();
           
            // Clear previous search and apply client-side filtering
            table.search('').columns().search('').draw();
           
            if (fullName) {
                table.column(1).search(fullName, true, false).draw();
            }
           
            // Note: More sophisticated client-side filtering could be implemented here
            // but for a static example this basic search is sufficient
        });
       
        // Reset button functionality
        $('button[type="reset"]').on('click', function() {
            $('.select2').val(null).trigger('change');
            $('#full_name').val('');
            table.search('').columns().search('').draw();
        });
    });
</script>


@endsection

