@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.program.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">
                                <div class="table-responsive">
                                    <table id="program-table" class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Academic Level</th>
                                                <th>Faculty</th>
                                                <th>Program Title</th>
                                                <th>Status</th>
                                                <th>Created At</th>
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

        <div class="modal fade" id="createProgram" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="programForm" action="{{ route('admin.programs.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            
                            <div class="col-md-12">
                                <div class="p-2 label-input">
                                    <label>Academic Level<span class="must"> *</span></label>
                                    <div class="single-input-modal">
                                        <select name="class_id" class="input-text single-input-text" id="dynamic_class_id" required>
                                            <option value="">Select Academic Level</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->class }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Faculty<span class="must"> *</span></label>
                                    <div class="single-input-modal">
                                        <select name="section_id" class="input-text single-input-text" id="dynamic_section_id" required>
                                            <option value="">Select Faculty</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Program Title<span class="must"> *</span></label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('title') }}" name="title"
                                            class="input-text single-input-text" id="dynamic_title" required>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Status<span class="must">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_active" id="option1"
                                                value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_active" id="option2"
                                                value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="option2">Inactive</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top col-md-12 d-flex justify-content-end p-2">
                                    <button type="submit" class="btn btn-sm btn-success mt-2">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#program-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.programs.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'class',
                    name: 'class'
                },
                {
                    data: 'section',
                    name: 'section'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions'
                }
            ]
        });

        $(document).on('click', '.edit-program', function() {
            var id = $(this).data('id');
            var class_id = $(this).data('class_id');
            var section_id = $(this).data('section_id');
            var title = $(this).data('title');
            var is_active = $(this).data('is_active');

            $('#dynamic_id').val(id);
            $('#dynamic_class_id').val(class_id);
            $('#dynamic_section_id').val(section_id);
            $('#dynamic_title').val(title);
            
            $('input[name="is_active"]').prop('checked', false);
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked', true);

            $('#programForm').attr('action', '{{ route('admin.programs.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            $('#createProgram').modal('show');
            return false;
        });
    </script>
@endsection
@endsection