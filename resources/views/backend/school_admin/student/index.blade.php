@extends('backend.layouts.master')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-between mb-4">
        <div class="border-bottom border-primary">
            <h2>{{ $page_title }}</h2>
        </div>
        @include('backend.school_admin.student.partials.action')
    </div>
    <div class="card mb-2">
        <div class="card-body">
            <form id="filterForm" onsubmit="return false;">
                @csrf
                <div class="d-flex justify-content-between">
                    <div class="col-lg-3 col-sm-3 mt-2">
                        <label for="class_id">Level of Study:<span class="text-danger">*</span></label>
                        <div class="select">
                            <select name="class_id" required>
                                <option value="">Select Level</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->class }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('class_id')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
            
                    <div class="col-lg-3 col-sm-3 mt-2">
                        <label for="section_id">Faculty:<span class="text-danger">*</span></label>
                        <div class="select">
                            <select name="section_id" required>
                                <option value="">Select Faculty</option>
                            </select>
                        </div>
                        @error('section_id')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
            
                    <div class="col-lg-3 col-sm-3 mt-2">
                        <label for="program_id">Program:</label>
                        <div class="select">
                            <select name="program_id">
                                <option value="">Select Program</option>
                            </select>
                        </div>
                        @error('program_id')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-12 d-flex justify-content-end pt-2">
                    <button type="button" class="btn btn-primary" id="searchButton">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="student-table" class="table table-bordered table-striped dataTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>ID</th>
                            <th>Name (English)</th>
                            <th>Name (Nepali)</th>
                            <th>Level of Study</th>
                            <th>Faculty</th>
                            <th>Program</th>
                            <th>Mobile</th>
                            <th>Father Name</th>
                            <th>Mother Name</th>
                            <th>Admission Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="form-group col-md-12 d-flex justify-content-end pt-2">
                <button type="button" class="btn btn-danger" id="bulkDeleteButton">Delete</button>
            </div>
        </div>
    </div>


    <script>
   $(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var dataTable = $('#student-table').DataTable({
    processing: true,
    serverSide: true,
    deferLoading: 0,
    ajax: {
        url: "{{ route('admin.student.get') }}",
        type: 'POST',
        data: function(d) {
            d.class_id = $('select[name="class_id"]').val();
            d.section_id = $('select[name="section_id"]').val();
            d.program_id = $('select[name="program_id"]').val();
        }
    },
        columns: [
            { 
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            { data: 'id', name: 'id' },
            { 
                data: null,
                name: 'name_en',
                render: function(data) {
                    return data.first_name_en + ' ' + 
                           (data.middle_name_en ? data.middle_name_en + ' ' : '') + 
                           data.last_name_en;
                }
            },
        { 
            data: null,
            name: 'name_np',
            render: function(data) {
                return data.first_name_np + ' ' + 
                       (data.middle_name_np ? data.middle_name_np + ' ' : '') + 
                       data.last_name_np;
            }
        },
        { data: 'class.class', name: 'class.class' },
        { data: 'section.section_name', name: 'section.section_name' },
        { data: 'program.title', name: 'program.title' },
        { data: 'mobile_number', name: 'mobile_number' },
        { data: 'father_name', name: 'father_name' },
        { data: 'mother_name', name: 'mother_name' },
        { data: 'admission_year', name: 'admission_year' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ]
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


    // Add this to your existing document.ready function
$(document).ready(function() {
    // Check if we have search parameters and should perform search
    var selectedClass = @json($selectedClass);
    var selectedSection = @json($selectedSection);
    var selectedProgram = @json($selectedProgram);
    var shouldSearch = @json($shouldSearch);
    
    if (shouldSearch && selectedClass) {
        // Set the class value
        $('select[name="class_id"]').val(selectedClass).trigger('change');
        
        // Wait for cascading dropdowns to populate
        setTimeout(function() {
            // Set section and program if they exist
            if (selectedSection) {
                $('select[name="section_id"]').val(selectedSection);
            }
            if (selectedProgram) {
                $('select[name="program_id"]').val(selectedProgram);
            }
            
            // Trigger the search
            $('#searchButton').trigger('click');
        }, 1000);
    }
});

// Update your existing search button handler
$('#searchButton').on('click', function() {
    var class_id = $('select[name="class_id"]').val();
    var section_id = $('select[name="section_id"]').val();
    var program_id = $('select[name="program_id"]').val();
    
    if (!class_id) {
        alert('Please select a Level of Study');
        return;
    }
    
    dataTable.clear();
    dataTable.ajax.reload();
    checkExportSelectedVisibility();
});
});
    </script>
</div>
@endsection