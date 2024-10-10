<?php
namespace VaccineRegistration\User\DTO;

class UserRegistrationDTO
{
    public function __construct(
        public string $nid,
        public string $name,
        public string $email,
        public int $vaccine_center_id
    ) {}

    public static function fromRequest($request)
    {
        return new self(
            $request->input('nid'),
            $request->input('name'),
            $request->input('email'),
            $request->input('vaccine_center_id')
        );
    }
}
