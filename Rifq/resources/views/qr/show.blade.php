<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $animal->name ?? 'حيوان' }} - رِفْق</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { font-family: 'Cairo', sans-serif; }
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; margin: 0; display: flex; align-items: center; justify-content: center; }
        .card { background: white; border-radius: 20px; padding: 40px; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 20px; }
        .logo-icon { width: 40px; height: 40px; color: #9333ea; }
        .logo-text { font-size: 24px; font-weight: bold; color: #9333ea; }
        .title { font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 5px; }
        .subtitle { color: #6b7280; font-size: 14px; }
        .image-placeholder { height: 200px; background: linear-gradient(135deg, #c084fc 0%, #f472b6 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-bottom: 25px; }
        .image-placeholder svg { width: 80px; height: 80px; color: white; opacity: 0.8; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px; }
        .info-item { background: #f3f4f6; padding: 15px; border-radius: 10px; }
        .info-label { font-size: 12px; color: #6b7280; margin-bottom: 5px; }
        .info-value { font-size: 16px; font-weight: 600; color: #1f2937; }
        .status { background: #dcfce7; color: #166534; padding: 8px 16px; border-radius: 20px; display: inline-block; font-size: 14px; font-weight: 600; }
        .org-info { background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; padding: 15px; margin-top: 20px; }
        .org-title { font-weight: 600; color: #0369a1; margin-bottom: 5px; }
        .qr-badge { position: absolute; top: -10px; right: -10px; background: #9333ea; color: white; padding: 5px 10px; border-radius: 10px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="card" style="position: relative;">
        <div class="header">
            <div class="logo">
                <svg class="logo-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <span class="logo-text">رِفْق</span>
            </div>
            <div class="title">{{ $animal->name ?? 'حيوان' }}</div>
            <div class="subtitle">تم العثور على هذا الحيوان عبر رمز QR</div>
        </div>
        
        <div class="image-placeholder">
            <svg fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 4c-1 0-2 .5-3 1-.5-.5-1-1-2-1s-2 .5-3 1c-.5-.5-1-1-2-1s-2 .5-3 1c-1-.5-2-1-3-1v2c1 0 1.5.5 2 1 .5-.5 1-1 2-1s1.5.5 2 1c.5-.5 1-1 2-1s1.5.5 2 1c.5-.5 1-1 2-1s1.5.5 2 1c.5-.5 1-1 2-1v-2zM6 9v11h3v-5c0-1.1.9-2 2-2s2 .9 2 2v5h3V9H6z"/>
            </svg>
        </div>
        
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">النوع</div>
                <div class="info-value">{{ $animal->species === 'dog' ? 'كلب' : 'قطة' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">السلالة</div>
                <div class="info-value">{{ $animal->breed }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">العمر</div>
                <div class="info-value">{{ $animal->estimated_age }} سنوات</div>
            </div>
            <div class="info-item">
                <div class="info-label">الجنس</div>
                <div class="info-value">{{ $animal->gender === 'Male' ? 'ذكر' : 'أنثى' }}</div>
            </div>
        </div>
        
        <div style="text-align: center; margin-bottom: 15px;">
            <span class="status">
                @if($animal->status === 'available_for_adoption')
                    متاح للتبني
                @elseif($animal->status === 'in_shelter')
                    في المأوى
                @elseif($animal->status === 'adopted')
                    تم تبنيه
                @else
                    {{ $animal->status }}
                @endif
            </span>
        </div>
        
        @if($animal->organization)
            <div class="org-info">
                <div class="org-title">المأوى المسؤول</div>
                <p style="color: #0369a1; margin: 0;">{{ $animal->organization->name }}</p>
                @if($animal->organization->phone)
                    <p style="color: #6b7280; margin: 5px 0 0 0; font-size: 14px;">
                        📞 {{ $animal->organization->phone }}
                    </p>
                @endif
            </div>
        @endif
        
        <div style="margin-top: 25px; text-align: center;">
            <a href="/" style="background: #9333ea; color: white; padding: 12px 30px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block;">
                زيارة موقع رِفْق
            </a>
        </div>
    </div>
</body>
</html>
