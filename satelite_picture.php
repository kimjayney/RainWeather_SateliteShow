<?
date_default_timezone_set('Asia/Seoul');

$content = file_get_contents("http://www.kma.go.kr/weather/images/satellite_basic02.jsp");


 function getURL($html) {
                $doc = new DOMDocument;
                @$doc->loadHTML($html);

                $items = $doc->getElementsByTagName('img');
                foreach ($items as $tag) { // FIND VALUE AS FOREACH FUNC()
                        $width = $tag->getAttribute('width');
                        $style = $tag->getAttribute('style');
                        if ($width == "680") {
                                if ($style =="" ) {
                                        $value = $tag->getAttribute('src');
                                }
                        }
                }

                return "http://www.kma.go.kr" . $value;
        }
$date = date("Y-m-d H:i:s");

$photo_url = getURL($content);

$date2 = explode('/', $photo_url);
$date = $date2[7];
$date3 = explode('_', $date);

$date4 = $date3[2];

$date5 = explode('.', $date4);

$date6 = $date5[0];

$datetime = date("Y-m-d H:i:s ", strtotime($date6));

$message = "$datetime 에 올라온 사진 입니다. \n 출처 : 기상청";
$access_token = 'token';
$graph_url= "https://graph.facebook.com/page_id/photos";
  $postData = "url=" . urlencode($photo_url)
  . "&message=" . $message
  . "&access_token=" .$access_token;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $graph_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $output = curl_exec($ch);

        curl_close($ch);
	echo $output;
//	echo "data4 : $datetime";
?>

