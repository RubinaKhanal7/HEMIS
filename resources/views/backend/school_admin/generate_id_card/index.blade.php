@extends('backend.layouts.master')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-between mb-4">
        <div class="border-bottom border-primary">
            <h2>{{ $page_title }}</h2>
        </div>
    </div>
    
    <form id="filterForm">
        @csrf
        <div class="d-flex justify-content-between">
            <div class="col-lg-3 col-sm-3 mt-2">
                <label for="class_id">Level of Study:</label>
                <div class="select">
                    <select name="class_id" class="form-control">
                        <option value="">Select Level of Study</option>
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
                <label for="section_id">Faculty:</label>
                <div class="select">
                    <select name="section_id" class="form-control">
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
                    <select name="program_id" class="form-control">
                        <option value="">Select Program</option>
                    </select>
                </div>
                @error('program_id')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>

            <div class="col-lg-3 col-sm-3 mt-2">
                <label for="id_card_id">ID Card Design:</label>
                <div class="select">
                    <select name="id_card_id" class="form-control">
                        <option value="">Select ID Card Design</option>
                        @foreach ($idcard_designs as $design)
                            <option value="{{ $design->id }}">{{ $design->college_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('id_card_id')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>
        </div>
        
        <div class="form-group col-md-12 d-flex justify-content-end pt-2">
            <button type="button" class="btn btn-primary" id="searchButton">Search</button>
        </div>
    </form>

    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-6">
                        <button id="bulkDownloadBtn" class="btn btn-primary" disabled>Bulk Download</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="student-table" class="table table-bordered table-striped dataTable dtr-inline">
                                <thead>
                                    <tr>
                                        <th>
                                            Select All <input type="checkbox" id="select-all-checkbox">
                                        </th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Level of Study</th>
                                        <th>Faculty</th>
                                        <th>Program</th>
                                        <th>Photo</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="ajax_response"></div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Setup ajax headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize DataTable
        var dataTable = $('#student-table').DataTable({
            processing: true,
            serverSide: true,
            deferLoading: 0,
            ajax: {
                url: '{{ route("admin.generate-idcards.students.get") }}',
                type: 'POST',
                data: function(d) {
                    d.class_id = $('select[name="class_id"]').val();
                    d.section_id = $('select[name="section_id"]').val();
                    d.program_id = $('select[name="program_id"]').val();
                    d.id_card_id = $('select[name="id_card_id"]').val();
                }
            },
            columns: [
    {
        data: null,
        render: function(data, type, row) {
            return '<input type="checkbox" class="student-checkbox" data-student-id="' + row.id + '">';
        },
        orderable: false,
        searchable: false
    },
    {data: 'id', name: 'id'},
    {data: 'full_name', name: 'full_name'},
    {data: 'class.class', name: 'class.class', defaultContent: ''},
    {data: 'section.section_name', name: 'section.section_name', defaultContent: ''},
    {data: 'program.title', name: 'program.title', defaultContent: ''},
    {
        data: 'student_photo', 
        name: 'student_photo',
        render: function(data) {
            if (data) {
                return '<img src="' + "{{ asset('uploads/students') }}/" + data + '" alt="Student Photo" width="50">';
            }
            return 'No Photo';
        }
    },
    {data: 'actions', name: 'actions', orderable: false, searchable: false}
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

        // Search button click
        $('#searchButton').on('click', function() {
            dataTable.ajax.reload();
            selectedStudents.clear();
            updateSelectAllCheckbox();
            updateBulkDownloadButton();
        });

        // Bulk Download Management
        var selectedStudents = new Set();

        // Select All checkbox
        $('#select-all-checkbox').on('change', function() {
            var isChecked = $(this).prop('checked');
            $('.student-checkbox').prop('checked', isChecked);
            
            if (isChecked) {
                dataTable.rows().every(function(rowIdx, tableLoop, rowLoop) {
                    selectedStudents.add(this.data().id);
                });
            } else {
                selectedStudents.clear();
            }
            
            updateBulkDownloadButton();
        });

        // Individual Student checkbox
        $('#student-table').on('change', '.student-checkbox', function() {
            var studentId = $(this).data('student-id');
            
            if (this.checked) {
                selectedStudents.add(studentId);
            } else {
                selectedStudents.delete(studentId);
            }
            
            updateSelectAllCheckbox();
            updateBulkDownloadButton();
        });

        function updateSelectAllCheckbox() {
            var totalRows = dataTable.rows().count();
            var selectedRows = selectedStudents.size;
            
            $('#select-all-checkbox').prop({
                checked: selectedRows > 0 && selectedRows === totalRows,
                indeterminate: selectedRows > 0 && selectedRows < totalRows
            });
        }

        function updateBulkDownloadButton() {
            $('#bulkDownloadBtn').prop('disabled', selectedStudents.size === 0);
        }

        // Bulk Download Button Click
        $('#bulkDownloadBtn').on('click', function() {
            var idCardId = $('select[name="id_card_id"]').val();

            if (!idCardId) {
                alert('Please select ID Card Design');
                return;
            }

            $.ajax({
                url: '{{ route("admin.generate-idcards.bulk-download") }}',
                type: 'POST',
                data: {
                    student_ids: Array.from(selectedStudents),
                    id_card_id: idCardId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response, status, xhr) {
                    var filename = '';
                    var disposition = xhr.getResponseHeader('Content-Disposition');

                    if (disposition && disposition.indexOf('attachment') !== -1) {
                        var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                        var matches = filenameRegex.exec(disposition);
                        if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                    }

                    if (!filename) {
                        filename = 'id_cards.zip';
                    }

                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while downloading the ID cards.');
                }
            });
        });

        // Show ID Card
        $(document).on('click', '.show-id-card', function() {
            var studentId = $(this).data('student-id');
            var idCardId = $(this).data('id-card-id');

            $.ajax({
                url: '/admin/generate-idcards/show-idcard-design/' + studentId + '/' + idCardId,
                type: 'GET',
                success: function(data) {
                    $('#ajax_response').empty();
                    $('#ajax_response').html(data);
                    $('#idCardModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while loading the ID card.');
                }
            });
        });

       // Download ID Card
$(document).on('click', '.download-id-card', function() {
    var studentId = $(this).data('student-id');
    var idCardId = $('select[name="id_card_id"]').val();
    
    if (!idCardId) {
        alert('Please select ID Card Design');
        return;
    }
    
    window.location.href = '/admin/generate-idcards/download-id-card/' + studentId + '/' + idCardId;
});
    });
</script>
@endsection