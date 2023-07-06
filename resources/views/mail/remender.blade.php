<!DOCTYPE html>
<html>
    @php
        $community = App\Models\Community::find($community_id)
    @endphp
<head>
    <meta charset="utf-8">
    <title>جلسة مجتمع صناعة المحتوى    </title>
</head>
<body style="text-align: center">

    <h1>مرحبا {{ $name }} اسم الشخص</h1>
    <p>نود ان نذكركم بأنه سيتم عقد جلسة المجتمع مع الأعضاء بعد 3 ساعات من الان</p>
    <p> {{ $date }}<br> </p>
    <p>توقيت : مكة المكرمة | الرياض </p> <br>
    <p>رابط الحضور :      

        كونوا على الموعد لنحقق قصص نجاح واهدافنا سوياً
        
        
        اذا كنت تريد الاستفادة و مشاهدة المزيد من الجلسات السابقة 
        
        سجل دخولك
        </p>
    <p>كونوا على الموعد لنحقق قصص نجاح واهدافنا سوياً </p>
    <a href="{{ $community->meeting_url }}" style="background: #1B7FED; color:white" class="btn btn-primary"> سجل دخولك </a>
    <p>للاستفسار او التواصل من خلال الضغط هنا 
        ( https://api.whatsapp.com/send/?phone=971506361956&text&type=phone_number&app_absent=0 ) 
        او مراسلتنا عبر : info@arabicreators.com</p>
</body>
</html>
