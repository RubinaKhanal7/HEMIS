<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Student ID Card</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }
        .id-card {
            width: 3.37in;
            height: 2.125in;
            position: relative;
            margin: 0 auto;
            border: 1px solid #ccc;
            overflow: hidden;
            box-sizing: border-box;
        }
        .id-card-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .id-card-content {
            position: relative;
            padding: 10px;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.8);
        }
        .college-name {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .student-photo {
            width: 0.8in;
            height: 0.95in;
            border: 1px solid #ddd;
            margin: 0 auto 10px auto;
            text-align: center;
        }
        .student-info {
            font-size: 9px;
        }
        .info-row {
            margin-bottom: 4px;
            display: flex;
        }
        .info-label {
            font-weight: bold;
            width: 40%;
        }
        .info-value {
            width: 60%;
        }
        .signature {
            margin: 5px auto;
            text-align: center;
        }
        .signature img {
            max-height: 20px;
            max-width: 80px;
        }
        .footer {
            text-align: center;
            font-size: 8px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="id-card">
        @if($design->background_img && file_exists($backgroundImgPath))
        <div class="id-card-background">
            <img src="{{ $backgroundImgPath }}" alt="Background" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        @endif
        
        <div class="id-card-content">
            <div class="college-name">
                {{ $design->college_name }}
            </div>
            
            <div class="student-photo">
                @if($student->student_photo && file_exists($studentPhotoPath))
                    <img src="{{ $studentPhotoPath }}" alt="Student Photo" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; border: 1px dashed #999;">
                        <span>No Photo</span>
                    </div>
                @endif
            </div>
            
            <div class="student-info">
                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value">{{ $student->first_name_en }} {{ $student->middle_name_en }} {{ $student->last_name_en }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Academic Level:</div>
                    <div class="info-value">{{ $student->class->class }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Faculty:</div>
                    <div class="info-value">{{ $student->section->section_name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Program:</div>
                    <div class="info-value">{{ $student->program->title }}</div>
                </div>
            </div>
            
            <div class="signature">
                @if($design->sign && file_exists($signPath))
                <img src="{{ $signPath }}" alt="Signature">
                @else
                <div style="width: 80px; height: 20px; border-bottom: 1px solid #000; margin: 0 auto;"></div>
                @endif
            </div>
            
            <div class="footer">
                {!! $design->content_footer !!}
            </div>
        </div>
    </div>
</body>
</html>