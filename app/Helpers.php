<?php

use App\Models\BankInfo;
use App\Models\GeneralInfo;
use Faker\Provider\bg_BG\PhoneNumber;
use Illuminate\Support\Facades\Http;
use Pusher\Pusher;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\StatefulGeocoder;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\Intl\Intl;

function getCountryFromPhoneNumber($phoneNumber)
{
    $prefixToCountry  = [
        "+44" => "UK (+44)", "+1" => "Canada (+1)", "+213" => "Algeria (+213)", "+376" => "Andorra (+376)", "+244" => "Angola (+244)", "+1264" => "Anguilla (+1264)", "+1268" => "Antigua & Barbuda (+1268)", "+54" => "Argentina (+54)", "+374" => "Armenia (+374)", "+297" => "Aruba (+297)", "+61" => "Australia (+61)", "+43" => "Austria (+43)", "+994" => "Azerbaijan (+994)", "+1242" => "Bahamas (+1242)", "+973" => "Bahrain (+973)", "+880" => "Bangladesh (+880)", "+1246" => "Barbados (+1246)", "+375" => "Belarus (+375)", "+32" => "Belgium (+32)", "+501" => "Belize (+501)", "+229" => "Benin (+229)", "+1441" => "Bermuda (+1441)", "+975" => "Bhutan (+975)", "+591" => "Bolivia (+591)", "+387" => "Bosnia Herzegovina (+387)", "+267" => "Botswana (+267)", "+55" => "Brazil (+55)", "+673" => "Brunei (+673)", "+359" => "Bulgaria (+359)", "+226" => "Burkina Faso (+226)", "+257" => "Burundi (+257)", "+855" => "Cambodia (+855)", "+237" => "Cameroon (+237)", "+238" => "Cape Verde Islands (+238)", "+1345" => "Cayman Islands (+1345)", "+236" => "Central African Republic (+236)", "+56" => "Chile (+56)", "+86" => "China (+86)", "+57" => "Colombia (+57)", "+269" => "Mayotte (+269)", "+242" => "Congo (+242)", "+682" => "Cook Islands (+682)", "+506" => "Costa Rica (+506)", "+385" => "Croatia (+385)", "+53" => "Cuba (+53)", "+90392" => "Cyprus North (+90392)", "+357" => "Cyprus South (+357)", "+42" => "Czech Republic (+42)", "+45" => "Denmark (+45)", "+253" => "Djibouti (+253)", "+1809" => "Dominican Republic (+1809)", "+593" => "Ecuador (+593)", "+20" => "Egypt (+20)", "+503" => "El Salvador (+503)", "+240" => "Equatorial Guinea (+240)", "+291" => "Eritrea (+291)", "+372" => "Estonia (+372)", "+251" => "Ethiopia (+251)", "+500" => "Falkland Islands (+500)", "+298" => "Faroe Islands (+298)", "+679" => "Fiji (+679)", "+358" => "Finland (+358)", "+33" => "France (+33)", "+594" => "French Guiana (+594)", "+689" => "French Polynesia (+689)", "+241" => "Gabon (+241)", "+220" => "Gambia (+220)", "+7880" => "Georgia (+7880)", "+49" => "Germany (+49)", "+233" => "Ghana (+233)", "+350" => "Gibraltar (+350)", "+30" => "Greece (+30)", "+299" => "Greenland (+299)", "+1473" => "Grenada (+1473)", "+590" => "Guadeloupe (+590)", "+671" => "Guam (+671)", "+502" => "Guatemala (+502)", "+224" => "Guinea (+224)", "+245" => "Guinea - Bissau (+245)", "+592" => "Guyana (+592)", "+509" => "Haiti (+509)", "+504" => "Honduras (+504)", "+852" => "Hong Kong (+852)", "+36" => "Hungary (+36)", "+354" => "Iceland (+354)", "+91" => "India (+91)", "+62" => "Indonesia (+62)", "+98" => "Iran (+98)", "+964" => "Iraq (+964)", "+353" => "Ireland (+353)", "+972" => "Israel (+972)", "+39" => "Italy (+39)", "+1876" => "Jamaica (+1876)", "+81" => "Japan (+81)", "+962" => "Jordan (+962)", "+7" => "Uzbekistan (+7)", "+254" => "Kenya (+254)", "+686" => "Kiribati (+686)", "+850" => "Korea North (+850)", "+82" => "Korea South (+82)", "+965" => "Kuwait (+965)", "+996" => "Kyrgyzstan (+996)", "+856" => "Laos (+856)", "+371" => "Latvia (+371)", "+961" => "Lebanon (+961)", "+266" => "Lesotho (+266)", "+231" => "Liberia (+231)", "+218" => "Libya (+218)", "+417" => "Liechtenstein (+417)", "+370" => "Lithuania (+370)", "+352" => "Luxembourg (+352)", "+853" => "Macao (+853)", "+389" => "Macedonia (+389)", "+261" => "Madagascar (+261)", "+265" => "Malawi (+265)", "+60" => "Malaysia (+60)", "+960" => "Maldives (+960)", "+223" => "Mali (+223)", "+356" => "Malta (+356)", "+692" => "Marshall Islands (+692)", "+596" => "Martinique (+596)", "+222" => "Mauritania (+222)", "+52" => "Mexico (+52)", "+691" => "Micronesia (+691)", "+373" => "Moldova (+373)", "+377" => "Monaco (+377)", "+976" => "Mongolia (+976)", "+1664" => "Montserrat (+1664)", "+212" => "Morocco (+212)", "+258" => "Mozambique (+258)", "+95" => "Myanmar (+95)", "+264" => "Namibia (+264)", "+674" => "Nauru (+674)", "+977" => "Nepal (+977)", "+31" => "Netherlands (+31)", "+687" => "New Caledonia (+687)", "+64" => "New Zealand (+64)", "+505" => "Nicaragua (+505)", "+227" => "Niger (+227)", "+234" => "Nigeria (+234)", "+683" => "Niue (+683)", "+672" => "Norfolk Islands (+672)", "+670" => "Northern Marianas (+670)", "+47" => "Norway (+47)", "+968" => "Oman (+968)", "+680" => "Palau (+680)", "+507" => "Panama (+507)", "+675" => "Papua New Guinea (+675)", "+595" => "Paraguay (+595)", "+51" => "Peru (+51)", "+63" => "Philippines (+63)", "+48" => "Poland (+48)", "+351" => "Portugal (+351)", "+1787" => "Puerto Rico (+1787)", "+974" => "Qatar (+974)", "+262" => "Reunion (+262)", "+40" => "Romania (+40)", "+250" => "Rwanda (+250)", "+378" => "San Marino (+378)", "+239" => "Sao Tome & Principe (+239)", "+966" => "Saudi Arabia (+966)", "+221" => "Senegal (+221)", "+381" => "Serbia (+381)", "+248" => "Seychelles (+248)", "+232" => "Sierra Leone (+232)", "+65" => "Singapore (+65)", "+421" => "Slovak Republic (+421)", "+386" => "Slovenia (+386)", "+677" => "Solomon Islands (+677)", "+252" => "Somalia (+252)", "+27" => "South Africa (+27)", "+34" => "Spain (+34)", "+94" => "Sri Lanka (+94)", "+290" => "St. Helena (+290)", "+1869" => "St. Kitts (+1869)", "+1758" => "St. Lucia (+1758)", "+249" => "Sudan (+249)", "+597" => "Suriname (+597)", "+268" => "Swaziland (+268)", "+46" => "Sweden (+46)", "+41" => "Switzerland (+41)", "+963" => "Syria (+963)", "+886" => "Taiwan (+886)", "+66" => "Thailand (+66)", "+228" => "Togo (+228)", "+676" => "Tonga (+676)", "+1868" => "Trinidad & Tobago (+1868)", "+216" => "Tunisia (+216)", "+90" => "Turkey (+90)", "+993" => "Turkmenistan (+993)", "+1649" => "Turks & Caicos Islands (+1649)", "+688" => "Tuvalu (+688)", "+256" => "Uganda (+256)", "+380" => "Ukraine (+380)", "+971" => "United Arab Emirates (+971)", "+970" => "Palestine (+970)", "+598" => "Uruguay (+598)", "+678" => "Vanuatu (+678)", "+379" => "Vatican City (+379)", "+58" => "Venezuela (+58)", "+84" => "Virgin Islands - US (+1340)", "+681" => "Wallis & Futuna (+681)", "+969" => "Yemen (North)(+969)", "+967" => "Yemen (South)(+967)", "+260" => "Zambia (+260)", "+263" => "Zimbabwe (+263)"
    ];
    $prefixToCountryWithPlus = [];
 
    $prefix = substr($phoneNumber, 0, 4); // Assumes the prefix is 2 digits

    // Look up the country name from the mapping
    if (isset($prefixToCountry[$prefix])) {
        return $prefixToCountry[$prefix];
    } else {
        return null;
    }
}

function get_extra($id)
{
    $response = Http::get('http://dashboard.arabicreators.com/api/price_extra/' . $id);
    $data = json_decode($response->body());
    if ($data->code == 400) {
        return 'false';
    } else {
        return $data->data;
    }
}
function get_user_packge_type($per)
{
    if ($per == 12) {
        return 'سنوية';
    } else {
        return ('شهرية');
    }
}
function is_have_social_media()
{
    $exist = auth('api')->user()->soical_new()->exists();
    if ($exist == true) {
        return 1;
    } else {
        return 0;
    }
}
function is_have_social_media_old()
{
    $user = auth('api')->user();
    $socal = $user->soical()->exists();

    if ($socal == false) {
        return 0;
    } else {
        if (
            $user->soical->instagram != null ||
            $user->soical->facebook != null ||
            $user->soical->twitter != null ||
            $user->soical->pinterest != null ||
            $user->soical->snapchat != null ||
            $user->soical->linkedin != null ||
            $user->soical->podcast != null ||
            $user->soical->website != null ||
            $user->soical->ecommerce != null ||
            $user->soical->telegram != null ||
            $user->soical->youtube != null ||
            $user->soical->whatsapp != null
        ) {
            return 1;
        } else {
            return 0;
        }
    }
}
function get_status($stauts)
{
    if ($stauts == 1) {
        return 'مقبول';
    } elseif ($stauts == 0) {
        return 'مرفوض';
    } elseif ($stauts  == 2) {
        return 'قيد المراجعة';
    }
}
function get_status_button($stauts)
{
    if ($stauts == 1) {
        return 'success';
    } elseif ($stauts == 0) {
        return 'danger';
    } elseif ($stauts  == 2) {
        return 'warning';
    }
}
function numberToText($number)
{
    $text = '';

    switch ($number) {
        case 1:
            $text = 'MONTH';
            break;
        case 2:
            $text = 'TWO_MONTHS';
            break;
        case 3:
            $text = 'THREE_MONTHS';
            break;
        case 4:
            $text = 'FOUR_MONTHS';
            break;
        case 5:
            $text = 'FIVE_MONTHS';
            break;
        case 6:
            $text = 'SIX_MONTHS';
            break;
        case 7:
            $text = 'SEVEN_MONTHS';
            break;
        case 8:
            $text = 'EIGHT_MONTHS';
            break;
        case 9:
            $text = 'NINE_MONTHS';
            break;
        case 10:
            $text = 'TEN_MONTHS';
            break;
        case 11:
            $text = 'ELEVEN_MONTHS';
            break;
        case 12:
            $text = 'YEAR';
            break;
        default:
            $text = 'INVALID_NUMBER';
            break;
    }

    return $text;
}
function send_message($data)
{
    $options = array(
        'cluster' => env('PUSHER_APP_CLUSTER2'),
        'encrypted' => true
    );
    $pusher = new Pusher(
        env('PUSHER_APP_KEY2'),
        env('PUSHER_APP_SECRET2'),
        env('PUSHER_APP_ID2'),
        $options
    );
    $pusher->trigger('chat-user', 'chat_user', $data);
}
function get_user_status($user)
{
    if ($user->is_paid == 0 && $user->is_finish == 0) {
        return ' <button class="btn btn-info">مستخدم جديد</button>';
    }
    if ($user->is_paid == 0 &&  $user->is_finish == 1) {
        return ' <button class="btn btn-warning"> منتهي الاشتراك</button>';
    }
    if ($user->is_paid == 1  && $user->is_free == 0) {
        return ' <button class="btn btn-primary">نشط </button>';
    }
    if ($user->is_paid == 1  && $user->is_free == 1) {
        return ' <button class="btn btn-success">نشط مجاني </button>';
    }
}

function get_general_value($key)
{
    $general = GeneralInfo::where('key', $key)->first();
    if ($general) {
        return $general->value;
    }

    return '';
}
function get_detiles($user_id, $payment)
{
    $bank  = BankInfo::where('user_id', $user_id)->first();
    $detiles = [];
    $bankl = [];


    if ($payment == 'paypal') {
        array_push($detiles, $bankl['paypal_email'] = $bank->paypal_email);
    } elseif ($payment == 'bank') {
        array_push($detiles, $bankl['bank_name'] = $bank->bank_name);
        array_push($detiles, $bankl['iban_number'] = $bank->ibanNumber);
        array_push($detiles, $bankl['owner_name'] = $bank->owner_name);
    } elseif ($payment == 'westron') {
        array_push($detiles, $bankl['full_name'] = $bank->fullname);
        // array_push($detiles, $bankl['personID'] = $bank->persionID);
        array_push($detiles, $bankl['fullnameArabic'] = $bank->fullnameArabic);
        array_push($detiles, $bankl['counrty'] = $bank->counrty);
        array_push($detiles, $bankl['city'] = $bank->city);
        array_push($detiles, $bankl['phone'] = $bank->phone);
        // array_push($detiles, $bankl['Idimage'] = asset('uploads/' . $bank->Idimage));
    }
    // dd($bankl);
    return json_encode($bankl);
}
function get_payment($payment)
{
    if ($payment == 'paypal') {
        return 'PayPal';
    } elseif ($payment == 'visa') {
        return 'Visa';
    }
}
function get_withdrow_detiles($bank, $elemnt)
{
    return ($bank->$elemnt);
}
