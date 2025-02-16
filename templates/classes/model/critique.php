<?php
declare(strict_types=1);
namespace classes\model;
use classes\model\Restaurant;
use classes\model\User;

class Critique {
    private int $id;
    private string $message;
    private Restaurant $restaurant;
    private User $user;
    private string $date_test;
    private int $note;
    function __construct(int $id, string $message, Restaurant $restaurant, User $user, string $date_test, int $note){
        $this->id = $id;
        $this->message = $message;
        $this->restaurant = $restaurant;
        $this->user = $user;
        $this->date_test = $date_test;
        $this->note = $note;
    }
    function getId():int{
        return $this->id;
    }
    function getMessage(): string{
        return $this->message;
    }
    function getRestaurant(): Restaurant{
        return $this->restaurant;
    }
    function getUser(): User{
        return $this->user;
    }
    function getDateTest(): string{
        return $this->date_test;
    }
    function getNote(): int{
        return $this->note;
    }

}

?>