<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 17.5.4
 * Time: 22:54
 */

namespace factions\event\faction;


use factions\entity\Faction;
use factions\relation\Relation;
use pocketmine\command\CommandSender;
use pocketmine\event\Cancellable;

class FactionRelationChangeEvent extends FactionEvent implements Cancellable
{

    public static $handlerList = null;
    public static $eventPool = [];
    public static $nextEvent = 0;

    /** @var string */
    private $newRelation = Relation::NONE;

    /** @var CommandSender */
    protected $issuer;

    /** @var Faction */
    protected $otherFaction;

    public function __construct(CommandSender $sender, Faction $faction, Faction $otherFaction, string $newRelation)
    {
        if($faction === $otherFaction) {
            throw new \InvalidArgumentException("faction '{$faction->getName()}' cannot declare relation to itself");
        }
        parent::__construct($faction);
        $this->setNewRelation($newRelation);
        $this->otherFaction = $otherFaction;
        $this->issuer = $sender;
    }

    public function getOtherFaction(): Faction {
        return $this->otherFaction;
    }

    public function getIssuer(): CommandSender {
        return $this->issuer;
    }

    public function getNewRelation(): string
    {
        return $this->newRelation;
    }

    public function setNewRelation(string $relation)
    {
        if(!Relation::isValid($relation))
            throw new \InvalidArgumentException("cannot set new relation '$relation' is invalid");
        $this->newRelation = $relation;
    }

}