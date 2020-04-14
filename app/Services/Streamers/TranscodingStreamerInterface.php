<?php

namespace App\Services\Streamers;

interface TranscodingStreamerInterface extends StreamerInterface
{
    /**
     * @param int $bitRate
     */
    public function setBitRate(int $bitRate): void;

    /**
     * @param float $startTime
     */
    public function setStartTime(float $startTime): void;
}
