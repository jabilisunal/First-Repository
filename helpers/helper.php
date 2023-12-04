<?php

use App\Models\ProductVariant;
use App\Models\ProductVariantBarcodes;
use App\Models\Settings;
use Illuminate\Support\Arr;

if (!function_exists('getBaseDomain')) {
    function getBaseDomain(): string
    {
        return config('app.env') === 'production' ? 'myselftravel.az' : '';
    }
}


if (!function_exists('setting')) {

    function setting($key, $default = null)
    {
        if (is_null($key)) {
            return new Settings();
        }

        if (is_array($key)) {
            return Settings::set($key[0], $key[1]);
        }

        $value = Settings::get($key);

        return is_null($value) ? value($default) : $value;
    }
}


if (!function_exists('array_wrap')) {
    /**
     * If the given value is not an array, wrap it in one.
     *
     * @param mixed $value
     * @return array
     */
    function array_wrap(mixed $value): array
    {
        return Arr::wrap($value);
    }
}

if (!function_exists('animateList')) {
    /**
     * If the given value is not an array, wrap it in one.
     *
     * @return array
     */
    function animateList(): array
    {
        return [
            'bounce',
            'flash',
            'pulse',
            'rubberBand',
            'shakeX',
            'shakeY',
            'headShake',
            'swing',
            'tada',
            'wobble',
            'jello',
            'heartBeat',
            'backInDown',
            'backInLeft',
            'backInRight',
            'backInUp',
            'backOutDown',
            'backOutLeft',
            'backOutRight',
            'backOutUp',
            'bounceIn',
            'bounceInDown',
            'bounceInLeft',
            'bounceInRight',
            'bounceInUp',
            'bounceOut',
            'bounceOutDown',
            'bounceOutLeft',
            'bounceOutRight',
            'bounceOutUp',
            'fadeIn',
            'fadeInDown',
            'fadeInDownBig',
            'fadeInLeft',
            'fadeInLeftBig',
            'fadeInRight',
            'fadeInRightBig',
            'fadeInUp',
            'fadeInUpBig',
            'fadeInTopLeft',
            'fadeInTopRight',
            'fadeInBottomLeft',
            'fadeInBottomRight',
            'fadeOut',
            'fadeOutDown',
            'fadeOutDownBig',
            'fadeOutLeft',
            'fadeOutLeftBig',
            'fadeOutRight',
            'fadeOutRightBig',
            'fadeOutUp',
            'fadeOutUpBig',
            'fadeOutTopLeft',
            'fadeOutTopRight',
            'fadeOutBottomRight',
            'fadeOutBottomLeft',
            'flip',
            'flipInX',
            'flipInY',
            'flipOutX',
            'flipOutY',
            'lightSpeedInRight',
            'lightSpeedInLeft',
            'lightSpeedOutRight',
            'lightSpeedOutLeft',
            'rotateIn',
            'rotateInDownLeft',
            'rotateInDownRight',
            'rotateInUpLeft',
            'rotateInUpRight',
            'rotateOut',
            'rotateOutDownLeft',
            'rotateOutDownRight',
            'rotateOutUpLeft',
            'rotateOutUpRight',
            'hinge',
            'jackInTheBox',
            'rollIn',
            'rollOut',
            'zoomIn',
            'zoomInDown',
            'zoomInLeft',
            'zoomInRight',
            'zoomInUp',
            'zoomOut',
            'zoomOutDown',
            'zoomOutLeft',
            'zoomOutRight',
            'zoomOutUp',
            'slideInDown',
            'slideInLeft',
            'slideInRight',
            'slideInUp',
            'slideOutDown',
            'slideOutLeft',
            'slideOutRight',
            'slideOutUp'
        ];
    }
}
if (!function_exists('cleanBody')) {
    function cleanBody($body): string
    {
        return trim(preg_replace('/\s\s+/', ' ', trim(html_entity_decode(strip_tags($body)), " \t\n\r\0\x0B\xC2\xA0")));
    }
}

if (!function_exists('shortenText')) {
    function shortenText($text, $maxlength = 70, $appendix = "...")
    {
        if (mb_strlen($text) <= $maxlength) {
            return $text;
        }
        $text = mb_substr($text, 0, $maxlength - mb_strlen($appendix));
        $text .= $appendix;
        return $text;
    }
}

if (!function_exists('calculateTourDuration')) {
    /**
     * @throws Exception
     */
    function calculateTourDuration($startDatetime, $endDatetime): array
    {
        // Convert input strings to DateTime objects
        $startDate = new DateTime($startDatetime);
        $endDate = new DateTime($endDatetime);

        // Calculate the difference between two dates
        $interval = $startDate->diff($endDate);

        // Extract nights and days from the interval
        $nights = $interval->format('%a') - 1; // Subtract 1 to get the number of nights
        $days = $nights + 1; // Number of days is one more than nights

        // Create a result array
        return array(
            'nights' => $nights,
            'days' => $days
        );
    }
}

if (!function_exists('getRatingStatus')) {
    /**
     * @param $rating
     * @return string
     */
    function getRatingStatus($rating): string
    {
        if ($rating < 1 || $rating > 5) {
            return __('poor');
        } elseif ($rating < 2) {
            return __('poor');
        } elseif ($rating < 3) {
            return __('fair');
        } elseif ($rating < 4) {
            return __('average');
        } elseif ($rating < 5) {
            return __('good');
        } else {
            return __('excellent');
        }
    }
}

if (!function_exists('delTree')) {
    function delTree($dir): bool
    {
        $files = array_diff(scandir($dir), array('.', '..'));

        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }

        return rmdir($dir);
    }
}

if (!function_exists('searchForId')) {
    /**
     * @param $id
     * @param $array
     * @param $searchKey
     * @return int|string|null
     */
    function searchForKey($id, $array, $searchKey)
    {
        foreach ($array as $key => $val) {
            if ($val[$searchKey] === $id) {
                return $key;
            }
        }
        return null;
    }
}

if (!function_exists('json_validate')) {


    /**
     * @throws JsonException
     */
    function json_validate($string): bool
    {
        $json = json_decode($string, false, 512, JSON_THROW_ON_ERROR);
        return $json && $string !== $json;
    }
}

if (!function_exists('is_json')) {


    /**
     * @param $string
     * @return bool
     */
    function is_json($string): bool
    {
        return !empty($string) && is_string($string) && is_array(json_decode($string, true)) && json_last_error() == 0;
    }
}


if (!function_exists('object_to_array')) {
    function object_to_array($data)
    {
        if (is_array($data) || is_object($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = (is_array($value) || is_object($value)) ? object_to_array($value) : $value;
            }
            return $result;
        }
        return $data;
    }
}

if (!function_exists('string_to_int_from_array')) {
    function string_to_int_from_array(array $array): array
    {
        return array_map(static function ($value) {
            return (int)$value;
        }, $array);
    }
}


if (!function_exists('getRedirectUrlRealPath')) {
    function getRedirectUrlRealPath(): string
    {
        return implode('/', array_slice(explode('/', redirect()->back()->getTargetUrl()), 4));
    }
}

if (!function_exists('filePathGenerator')) {
    /**
     * @param string $path
     * @param string $prefix
     * @param string $format
     * @return string
     */
    function filePathGenerator(string $path, string $prefix, string $format): string
    {
        return $path . uniqid($prefix, true) . '-' . time() . $format;
    }
}

if (!function_exists('isShelf')) {
    /**
     * @param $barcode
     * @return bool
     */
    function isShelf($barcode): bool
    {
        return strlen($barcode) === 5 and str_starts_with($barcode, "T");
    }
}

if (!function_exists('generateProductVariants')) {
    /**
     * @param $options
     * @return array
     */
    function generateProductVariants($options): array
    {
        // Initialize an empty array to store the variant combinations
        $combinations = array();

        // Get all possible combinations of option values
        $option_values = array_values($options);
        $combinations = array_shift($option_values);
        while ($option_values) {
            $new_combinations = array();
            $option = array_shift($option_values);
            foreach ($combinations as $value) {
                // Check if $combinations is an array before merging with $option
                if (is_array($value)) {
                    foreach ($option as $option_value) {
                        $new_combinations[] = array_merge($value, array($option_value));
                    }
                } else {
                    $new_combinations[] = array($value, $option);
                }
            }
            $combinations = $new_combinations;
        }

        // Combine the option values with their corresponding option names to create the variant combinations
        $variant_combinations = array();
        foreach ($combinations as $combination) {
            $variant = array();
            foreach ($combination as $index => $value) {
                $option_name = array_keys($options)[$index];
                $variant[$option_name] = $value;
            }
            $variant_combinations[] = $variant;
        }

        return $variant_combinations;
    }
}

if (!function_exists('generateBarcode')) {
    /**
     * @return string
     * @throws \Exception
     */
    function generateBarcode(): string
    {
        // Generate a 12-digit random number
        $random_number = random_int(100000000000, 999999999999);

        // Calculate the check digit
        $digits = str_split($random_number);
        $sum = 0;
        foreach ($digits as $key => $digit) {
            if ($key % 2 === 0) {
                $sum += $digit;
            } else {
                $sum += $digit * 3;
            }
        }
        $check_digit = (10 - ($sum % 10)) % 10;

        // Combine the random number and check digit to form the barcode value
        return $random_number . $check_digit;
    }
}

if (!function_exists('isBundle')) {
    /**
     * @param $barcode
     * @return bool
     */
    function isBundle($barcode): bool
    {
        return in_array(substr($barcode, -4), ['-888', '*888']);
    }
}

if (!function_exists('bundleBarcodeParser')) {
    /**
     * @param $barcode
     * @return array|bool
     */
    function bundleBarcodeParser($barcode)
    {
        if (strpos($barcode, '-888')) {
            $barcode = explode('-888', $barcode)[0];
        } else if (strpos($barcode, '*888')) {
            $barcode = explode('*888', $barcode)[0];
        } else {
            $barcode = false;
        }

        if ($barcode) {
            if ($productVariantBarcode = ProductVariantBarcodes::where(['barcode' => $barcode])->first()) {
                if ($productVariant = ProductVariant::find($productVariantBarcode->product_variant_id)) {
                    return [
                        'sku' => $productVariant->sku,
                        'product_variant_barcode_id' => $productVariantBarcode->id,
                        'barcode' => $productVariantBarcode->barcode,
                        'variant_id' => $productVariant->id,
                        'product_id' => $productVariant->product_id,
                        'stock_count' => $productVariant->stock_count
                    ];
                }
                return false;
            }
            return false;
        }

        return false;
    }
}
