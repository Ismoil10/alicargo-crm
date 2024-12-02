<?php
function getTrackCodes($order_id, $type, $url_link = "alicargo.senet.uz")
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
    if ($type == 'order') {
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                    "Cookie: foo=bar\r\n"
            )
        );
        $context = stream_context_create($opts);

        $params = array(
            "type" => $type,
            "order_id" => $order_id
        );
        $url = "https://{$url_link}/report/report_pdf/mega_report_data_tg.php?" . http_build_query($params);
        $file = file_get_contents($url, false);
        if (json_decode($file, TRUE) != "empty") {
            $time = explode('.', microtime(true));
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($file);
            $file_path = $_SERVER["DOCUMENT_ROOT"]."/report/report_pdf/track_code_pdf/{$order_id}_pdf_{$time[0]}.pdf";
            $mpdf->Output($file_path, 'F');
            return "https://{$url_link}/report/report_pdf/track_code_pdf/{$order_id}_pdf_{$time[0]}.pdf";
        }
    }
}
