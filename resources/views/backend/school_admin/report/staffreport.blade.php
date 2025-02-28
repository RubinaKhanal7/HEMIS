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
    <form action="{{ route('admin.staff-reports.report') }}" method="GET">
        <div class="row align-items-end">          
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="level">Level:</label>
                    <select name="level[]" id="level" class="form-control select2" multiple>
                        @foreach($levels as $level)
                            <option value="{{ $level }}">{{ $level }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
           
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select name="role[]" id="role" class="form-control select2" multiple>
                        @foreach($roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                             
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="job_type">Job Type:</label>
                    <select name="job_type[]" id="job_type" class="form-control select2" multiple>
                        <option value="Temporary">Temporary</option>
                        <option value="Permanent">Permanent</option>
                        <option value="Contract">Contract</option>
                        <option value="Daily Basis">Daily Basis</option>
                    </select>
                </div>
            </div>
           
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select name="gender[]" id="gender" class="form-control select2" multiple>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
           
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="ethnicity">Ethnicity:</label>
                    <select name="ethnicity[]" id="ethnicity" class="form-control select2" multiple>
                        <option value="Dalit">Dalit</option>
                        <option value="Janajati">Janajati</option>
                        <option value="Madhesi">Madhesi</option>
                        <option value="Muslim">Muslim</option>
                        <option value="Tharu">Tharu</option>
                        <option value="Brahmin">Brahmin</option>
                        <option value="Chhetri">Chhetri</option>
                    </select>
                </div>
            </div>
           
            <div class="col-lg-3 col-sm-3">
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category[]" id="category" class="form-control select2" multiple>
                        <option value="Technical">Technical</option>
                        <option value="Non-Technical">Non-Technical</option>
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
   
    @if(request()->is('*report') && count(request()->all()) > 0)
        @if($staffs->count() > 0)
            <div id="table-container" class="mt-4">
                <div id="buttons-container"></div>
                <table id="staffTable" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Staff ID</th>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Role</th>
                            <th>Level</th>
                            <th>Job Type</th>
                            <th>Category</th>
                            <th>Ethnicity</th>
                            <th>Contact Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffs as $staff)
                        <tr>
                            <td>{{ $staff->id }}</td>
                            <td>{{ $staff->first_name_english }} {{ $staff->middle_name_english }} {{ $staff->last_name_english }}</td>
                            <td>{{ ucfirst($staff->gender) }}</td>
                            <td>{{ $staff->role }}</td>
                            <td>{{ $staff->level }}</td>
                            <td>{{ $staff->job_type }}</td>
                            <td>{{ $staff->category }}</td>
                            <td>{{ $staff->ethnicity }}</td>
                            <td>{{ $staff->mobile_number }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-warning mt-4">
                No staff members found matching your criteria.
            </div>
        @endif
    @else
        <div class="alert alert-info mt-4">
            Please apply filters and click the Search button to view staff reports.
        </div>
    @endif
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Initialize select2 for multiple selection
        $('.select2').select2({
            placeholder: "Select options",
            allowClear: true
        });
   
        @if(request()->is('*report') && count(request()->all()) > 0 && $staffs->count() > 0)
        // Initialize DataTables with server-side processing
        var table = $('#staffTable').DataTable({
            deferLoading: 0,
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
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
        @endif


        // Reset button functionality
        $('button[type="reset"]').on('click', function() {
            $('.select2').val(null).trigger('change');
            $('#full_name').val('');
        });
    });
</script>
@endsection

