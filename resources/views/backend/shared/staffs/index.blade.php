@extends('backend.layouts.master')


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
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">
                                <div class="table-responsive">
                                    <table id="staff-table" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                                        <thead>
                                           
                                            <tr>
                                                <th>Id</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Role / Position</th>
                                                <th>Level</th>
                                                <th>Job Type</th>
                                                <th>Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script>
    $(document).ready(function() {
        $('#staff-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.staffs.get') }}',  
                type: 'POST',
                data: function(d) {
                    // Send CSRF token to ensure the request is legitimate
                    d._token = '{{ csrf_token() }}';
                },
                error: function(xhr, error, thrown) {
                    console.error('Error fetching staff data:', error);  // Log error details for debugging
                    alert('An error occurred while fetching the data. Please try again.');
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'first_name_english', name: 'first_name_english' },
                { data: 'last_name_english', name: 'last_name_english' },
                { data: 'role', name: 'role' },
                { data: 'level', name: 'level' },
                { data: 'job_type', name: 'job_type' },
                { data: 'category', name: 'category' },
                { data: 'actions', name: 'actions' }
            ],
            drawCallback: function(settings) {
                // Handle any post-table rendering tasks here
            }
        });
    });
</script>

@endsection



