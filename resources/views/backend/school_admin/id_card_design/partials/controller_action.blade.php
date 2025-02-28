<td>
    <a href="{{ route('admin.id-carddesigns.show-design', $design->id) }}" class="btn btn-info btn-sm" title="View ID Card Preview">
        <i class="fa fa-eye"></i>
    </a>
    @can('edit_idcard_design')
    <a href="{{ route('admin.id-carddesigns.edit', $design->id) }}" class="btn btn-primary btn-sm" title="Edit" data-toggle="tooltip">
        <i class="fa fa-edit"></i>
    </a>
    @endcan


    @can('delete_idcard_design')
    <button type="button" class="btn btn-danger btn-sm delete-btn"
    data-id="{{ $design->id }}"
    data-url="{{ route('admin.id-carddesigns.destroy', $design->id) }}"
    title="Delete">
<i class="fa fa-trash"></i>
</button>
@endcan
</td>

