<?php

namespace App\Services;

use App\Repository\BannerRepository;

class ReviewService
{
    /**
     * @return mixed
     */
    public function getList(): array
    {
        return [
            [
                'id' => 1,
                'clientName' => 'Tiana Abie',
                'content' => 'Great quality products, affordable prices, fast and friendly delivery. I very recommend.',
            ],
            [
                'id' => 2,
                'clientName' => 'Lennie Swiffan',
                'content' => 'Great quality products, affordable prices, fast and friendly delivery. I very recommend.',
            ],
            [
                'id' => 3,
                'clientName' => 'Berta Emili',
                'content' => 'Great quality products, affordable prices, fast and friendly delivery. I very recommend.',
            ]
        ];
    }
}
