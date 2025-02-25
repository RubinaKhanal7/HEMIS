<div class="modal fade" id="idCardModal" tabindex="-1" role="dialog" aria-labelledby="idCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="idCardModalLabel">Student ID Card Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="id-card-preview" style="position: relative; max-width: 400px; margin: 0 auto;">
                    @if($design->background_img)
                    <div class="background-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
                        <img src="{{ asset($design->background_img) }}" alt="Background" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    @endif
                    
                    <div class="id-card-content" style="position: relative; z-index: 2; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: rgba(255, 255, 255, 0.8);">
                        <div class="text-center mb-3">
                            <h3>{{ $design->college_name }}</h3>
                        </div>
                        
                        <div class="student-photo text-center mb-3">
                            @if($student->student_photo)
                                <img src="{{ asset($student->student_photo) }}" alt="Student Photo" style="width: 100px; height: 120px; object-fit: cover; border: 1px solid #ddd;">
                            @else
                                <div style="width: 100px; height: 120px; border: 1px dashed #999; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <span>No Photo</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="student-info mb-3">
                            <div class="row mb-2">
                                <div class="col-5 font-weight-bold">Name:</div>
                                <div class="col-7">{{ $student->first_name_en }} {{ $student->middle_name_en }} {{ $student->last_name_en }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 font-weight-bold">Academic Level:</div>
                                <div class="col-7">{{ $student->class->class }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 font-weight-bold">Faculty:</div>
                                <div class="col-7">{{ $student->section->section_name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 font-weight-bold">Program:</div>
                                <div class="col-7">{{ $student->program->title }}</div>
                            </div>
                        </div>
                        
                        <div class="signature text-center mb-3">
                            @if($design->sign)
                            <img src="{{ asset($design->sign) }}" alt="Signature" style="max-height: 50px; max-width: 150px;">
                            @else
                            <div style="width: 150px; height: 30px; border-bottom: 1px solid #000; margin: 0 auto;"></div>
                            @endif
                        </div>
                        
                        <div class="footer text-center">
                            <p>{!! $design->content_footer !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{ route('admin.generate-idcards.download-id-card', [$student->id, $design->id]) }}" class="btn btn-primary">Download</a>
            </div>
        </div>
    </div>
</div>