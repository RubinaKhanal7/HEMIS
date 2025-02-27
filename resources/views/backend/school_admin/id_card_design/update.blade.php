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
                            <form id="quickForm" method="POST" action="{{ route('admin.id-carddesigns.update', $design->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')  <!-- Ensure we're using PUT method to update -->
                                <input type="hidden" name="form_submitted" value="1">
                                <div class="row">
                                    <!-- College Name -->
                                    <div class="form-group col-lg-6 col-sm-6">
                                        <label for="college_name">College Name</label>
                                        <input type="text" name="college_name" class="form-control" id="college_name"
                                            value="{{ old('college_name', $design->college_name) }}" placeholder="Enter College Name" required>
                                        @error('college_name')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                   
                                    <!-- Signature -->
                                    <div class="col-lg-6">
                                        <label for="sign">Signature</label>
                                        @if($design->sign)
                                            <img src="{{ asset($design->sign) }}" id="image_sign" style="width: 20%; display: block;">
                                        @else
                                            <img src="" id="image_sign" style="width: 20%; display: none;">
                                        @endif
                                        <div class="form-group">
                                            <input type="file" id="imageFile_sign" class="form-control"
                                                placeholder="Image" name="sign">
                                        </div>
                                        @error('sign')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>


                                    <!-- Background Image -->
                                    <div class="col-lg-6">
                                        <label for="background_img">Background Image</label>
                                        @if($design->background_img)
                                            <img src="{{ asset($design->background_img) }}" id="image_background" style="width: 20%; display: block;">
                                        @else
                                            <img src="" id="image_background" style="width: 20%; display: none;">
                                        @endif
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control"
                                                placeholder="Image" name="background_img">
                                        </div>
                                        @error('background_img')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>


                                    <!-- Footer Content -->
                                    <div class="form-group col-lg-12 col-sm-12">
                                        <label for="content_footer">Footer Content</label>
                                        <textarea name="content_footer" class="form-control" id="content_footer"
                                            placeholder="Enter Footer Content" required>{{ old('content_footer', $design->content_footer) }}</textarea>
                                        @error('content_footer')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>


                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
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


        // Add this to ensure the form submits even without file changes
        $("#quickForm").submit(function(event) {
            // Don't prevent default - let form submit normally
            console.log("Form submitted");
        });
    </script>
@endsection



