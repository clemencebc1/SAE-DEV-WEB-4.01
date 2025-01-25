<?php
declare(strict_types=1);
namespace model;
use model\Restaurant;
use model\User;

class Critique {
    private int $id;
    private string $message;
    private Restaurant $restaurant;
    private User $user;
    function __construct(int $id, string $message, Restaurant $restaurant, User $user){
        $this->id = $id;
        $this->message = $message;
        $this->restaurant = $restaurant;
        $this->user = $user;
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

}

?>