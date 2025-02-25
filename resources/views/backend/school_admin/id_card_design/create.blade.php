@extends('backend.layouts.master')

<!-- Main content -->
@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>
                    {{ $page_title }}
                </h2>
            </div>
            @include('backend.school_admin.id_card_design.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="quickForm" novalidate="novalidate" method="POST" action="{{ route('admin.id-carddesigns.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-6 col-sm-6">
                                        <label for="college_name">College Name</label>
                                        <input type="text" name="college_name" class="form-control" id="college_name"
                                            value="{{ old('college_name') }}" placeholder="Enter College Name" required>
                                        @error('college_name')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="sign">Signature</label>
                                        <img src="" id="image_sign" style="width: 20%;">
                                        <div class="form-group">
                                            <input type="file" id="imageFile_sign" class="form-control"
                                                placeholder="Image" name="sign">
                                        </div>
                                        @error('sign')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="background_img">Background Image</label>
                                        <img src="" id="image_background">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" 
                                                placeholder="Image" name="background_img">
                                        </div>
                                        @error('background_img')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>

                                    <div class="form-group col-lg-12 col-sm-12">
                                        <label for="content_footer">Footer Content</label>
                                        <textarea name="content_footer" class="form-control" id="content_footer"
                                            placeholder="Enter Footer Content" required>{{ old('content_footer') }}</textarea>
                                        @error('content_footer')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.includes.modal')
@endsection

@section('scripts')
    <script>
        // Preview image before upload
        function readURL(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $(previewId).attr('src', e.target.result);
                    $(previewId).css('display', 'block');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#imageFile_sign").change(function() {
            readURL(this, "#image_sign");
        });
        
        $("#imageFile").change(function() {
            readURL(this, "#image_background");
        });
    </script>
@endsection