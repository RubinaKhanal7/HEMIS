@can('edit_programs')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-program" 
        data-id="{{ $program->id }}"
        data-class_id="{{ $program->class_id }}"
        data-section_id="{{ $program->section_id }}"
        data-title="{{ $program->title }}"
        data-is_active="{{ $program->is_active }}"
        data-toggle="tooltip" 
        data-placement="top" 
        title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_programs')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $program->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>

    <div class="modal fade" id="delete{{ $program->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.programs.destroy', $program->id) }}">
                    <div class="modal-body">
                        @method('DELETE')
                        @csrf
                        <p>Are you sure to delete <span id="underscore">{{ $program->title }}</span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endcan