@extends('backend.layouts.master')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-between mb-4">
        <div class="border-bottom border-primary">
            <h2>{{ $page_title }}</h2>
        </div>
        <div>
            <a href="{{ route('admin.id-carddesigns.index') }}" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
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
                            
                            <div class="student-photo-placeholder text-center mb-3">
                                <div style="width: 100px; height: 120px; border: 1px dashed #999; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <span>Photo</span>
                                </div>
                            </div>
                            
                            <div class="student-info mb-3">
                                <div class="row mb-2">
                                    <div class="col-5 font-weight-bold">Name:</div>
                                    <div class="col-7">________________</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 font-weight-bold">Academic Level:</div>
                                    <div class="col-7">________________</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 font-weight-bold">Faculty:</div>
                                    <div class="col-7">________________</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 font-weight-bold">Program:</div>
                                    <div class="col-7">________________</div>
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .id-card-preview {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>
@endsection