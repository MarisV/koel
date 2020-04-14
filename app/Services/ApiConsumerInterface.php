<?php

namespace App\Services;

interface ApiConsumerInterface
{
    /**
     * @return string|null
     */
    public function getEndpoint(): ?string;

    /**
     * @return string|null
     */
    public function getKey(): ?string;

    /**
     * @return string|null
     */
    public function getSecret(): ?string;
}
