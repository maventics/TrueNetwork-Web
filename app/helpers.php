
<?php

    function formatNumber($number, $precision = 1) {
        if ($number < 1000) {
            // 0 - 999
            $format = number_format($number);
        } elseif ($number < 1000000) {
            // 1,000 - 999,999
            $format = number_format($number / 1000, $precision) . 'k';
        } elseif ($number < 1000000000) {
            // 1,000,000 - 999,999,999
            $format = number_format($number / 1000000, $precision) . 'm';
        } else {
            // 1,000,000,000+
            $format = number_format($number / 1000000000, $precision) . 'b';
        }

        // Remove unnecessary decimal .0
        if ($precision > 0) {
            $format = str_replace('.0', '', $format);
        }

        return $format;
    }

