<?php

namespace VaccineRegistration\Common\DTO;

class NotificationDataDTO
{
    public $date;
    public $center;

    /**
     * Create a new NotificationDataDTO instance.
     *
     * @param string $date
     * @param string $center
     */
    public function __construct(string $date, string $center)
    {
        $this->date = $date;
        $this->center = $center;
    }

    /**
     * Static method to create DTO from an array.
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['date'] ?? '',
            $data['center'] ?? ''
        );
    }
}
