<?php
class FormValidator
{
    private array $error = [];
    public function validator(array $datas): bool
    {
        if (empty($datas["firstName"])) {
            $this->error["firstName"] = "first name is required";
        } elseif (strlen($datas["firstName"]) < 2) {
            $this->error["firstName"] = "first name should be more than 2 length";
        }

        if (empty($datas["lastName"])) {
            $this->error["lastName"] = "last name is required";
        } elseif (strlen($datas["lastName"]) < 2) {
            $this->error["lastName"] = "last name should be more than 2 length";
        }

        if (empty($datas["address"])) {
            $this->error["address"] = "address name is required";
        }

        if (empty($datas["email"])) {
            $this->error["email"] = "email is required";
        }
        return empty($this->error);
    }

    public function getError()
    {
        return $this->error;
    }
}
