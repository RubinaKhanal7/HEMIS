@extends('backend.layouts.master')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-between mb-4">
        <div class="border-bottom border-primary">
            <h2>{{ $page_title }}</h2>
        </div>
        @include('backend.school_admin.id_card_design.partials.action')
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>College Name</th>
                            <th>Signature</th>
                            <th>Background</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($designs as $key => $design)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $design->college_name }}</td>
                            <td>
                                @if($design->sign)
                                <img src="{{ asset($design->sign) }}" alt="Signature" width="50">
                                @else
                                No Signature
                                @endif
                            </td>
                            <td>
                                @if($design->background_img)
                                <img src="{{ asset($design->background_img) }}" alt="Background" width="50">
                                @else
                                No Background
                                @endif
                            </td>

                            @include('backend.school_admin.id_card_design.partials.controller_action')
                           
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for displaying details -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">ID Card Design Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailsContent">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to delete this?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable();
        
        // View details using AJAX
        $('.view-details').on('click', function() {
            var designId = $(this).data('id');
            
        });
    });
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable();
        
        // Handle delete button click
        $('.delete-btn').on('click', function() {
            var id = $(this).data('id');
            var url = $(this).data('url');
            
            // Set the form action URL
            $('#deleteForm').attr('action', url);
            
            // Show the modal
            $('#deleteModal').modal('show');
        });
    });
</script>
@endsection