<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card</title>
    <style>
        @page { size: A4; margin: 0; }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .id-card-container {
            width: 400px;
            position: relative;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.9);
            text-align: center;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .background-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .header {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            position: relative;
        }
        .middle-content {
            display: flex;
            flex-direction: column;
            align-items: center; 
            justify-content: center;
            text-align: center;
            width: 100%;
            position: relative;
        }
        .student-photo {
            margin-bottom: 15px;
            text-align: center;
        }
        .student-photo img {
            width: 100px;
            height: 120px;
            object-fit: cover;
            border: 1px solid #ddd;
            margin: 0 auto;
        }
        .no-photo {
            width: 100px;
            height: 120px;
            border: 1px dashed #999;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin: 0 auto;
        }
        .student-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
            margin: 0 auto;
        }
        .info-row {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 8px;
            text-align: center;
            width: 100%;
        }
        .header, .footer {
            text-align: center;
            position: relative;
            width: 100%;
        }
        .signature {
            text-align: center;
            margin: 15px auto;
            display: flex;
            justify-content: center;
        }
        .signature img {
            margin: 0 auto;
        }
        h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="id-card-container">
        @if($design->background_img)
        <div class="background-image">
            <img src="{{ public_path('uploads/id_cards/' . basename($design->background_img)) }}" alt="Background">
        </div>
        @endif
        
        <div class="header">
            <h3>{{ $design->college_name }}</h3>
        </div>

        <div class="middle-content">
            <div class="student-photo">
                @if($student->student_photo)
                <img src="{{ public_path('uploads/students/' . $student->student_photo) }}" alt="Student Photo">
                @else
                <div class="no-photo">
                    <span>No Photo</span>
                </div>
                @endif
            </div>
        
            <div class="student-info">
                <div class="info-row">
                    <strong>Name:</strong> {{ $student->first_name_en }} {{ $student->middle_name_en }} {{ $student->last_name_en }}
                </div>
                <div class="info-row">
                    <strong>Academic Level:</strong> {{ $student->class->class }}
                </div>
                <div class="info-row">
                    <strong>Faculty:</strong> {{ $student->section->section_name }}
                </div>
                <div class="info-row">
                    <strong>Program:</strong> {{ $student->program->title }}
                </div>
            </div>
        </div>
        
        <div class="signature">
            @if($design->sign)
            <img src="{{ public_path('uploads/id_cards/' . basename($design->sign)) }}" alt="Signature" style="max-height: 50px; max-width: 150px;">
            @else
            <div style="width: 150px; height: 30px; border-bottom: 1px solid #000; margin: 0 auto;"></div>
            @endif
        </div>

        <div class="footer">
            <p>{!! $design->content_footer !!}</p>
        </div>
    </div>
</body>
</html>