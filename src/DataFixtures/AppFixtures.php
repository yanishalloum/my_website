<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Cap;
use App\Entity\Inventory;
use App\Entity\Member;

class AppFixtures extends Fixture
{
    // defines reference names for instances of member
    private const JOHN = 'john';
    private const REDA = 'reda';
    private const SARAH = 'sarah';
    private const CHRIS = 'chris';
    private const ANNA = 'anna';

    // defines reference names for instances of inventory
    private const JOHN_INVENTORY_1 = 'john-inventory-1';
    private const REDA_INVENTORY_1 = 'reda-inventory-1';
    private const SARAH_INVENTORY_1 = 'sarah-inventory-1';

    // defines reference names for instances of caps
    private const CAP_SARAH = 'cap-sarah';
    private const CAP_REDA = 'cap-reda';
    private const CAP_JOHN = 'cap-john';

    /**
     * Generates initialization data for inventories: [title]
     * @return \Generator
     */
    private static function inventoryDataGenerator()
    {
        yield ["Reda's inventory", self::REDA_INVENTORY_1];
        yield ["John's inventory", self::JOHN_INVENTORY_1];
        yield ["Sarah's inventory", self::SARAH_INVENTORY_1];
    }

    /**
     * @return \Generator
     */
    private static function capsGenerator()
    {
        yield [self::SARAH, "Chicago Bulls Snapback", 'navy blue', '54-60cm', 'very good', 'Starter', "90's"];
        yield [self::REDA, "Grim Reaper Japan", 'navy blue', '54-60cm', 'perfect', 'Polo Ralph Lauren', ' '];
        yield [self::JOHN, "San Francisco 49ers Snapback", 'red', '44-50cm', 'good', 'Starter', '1990'];
    }

    private static function memberGenerator()
    {
        yield ["Reda", self::REDA];
        yield ["John", self::JOHN];
        yield ["Sarah", self::SARAH];
        yield ["Chris", self::CHRIS];
        yield ["Anna", self::ANNA];
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::memberGenerator() as [$name, $memberReference]) {
            $member = new Member();
            $member->setName($name);
            $manager->persist($member);
            $this->addReference($memberReference, $member);
        }

        foreach (self::inventoryDataGenerator() as [$name, $inventoryReference]) {
            $inventory = new Inventory();
            $inventory->setName($name);
            $inventory->setDescription('');
            $manager->persist($inventory);
            $memberReference = str_replace('-inventory-1', '', $inventoryReference);
            $member = $this->getReference($memberReference);
            $inventory->setMember($member);
            $manager->persist($inventory);
            $this->addReference($inventoryReference, $inventory);
        }

        foreach (self::capsGenerator() as [$memberReference, $model, $color, $size, $condition, $brand, $year]) {
            $inventory = $this->getReference($memberReference . '-inventory-1');
            $cap = new Cap();
            $cap->setDescription('rare vintage cap');
            $cap->setName($model);
            $cap->setColor($color);
            $cap->setSize($size);
            $cap->setCondition($condition);
            $cap->setBrand($brand);
            $cap->setYear($year);
            $cap->setInventory($inventory);
            $manager->persist($cap);
            $this->addReference('cap-' . $memberReference, $cap);
        }

        $manager->flush();
    }
}
