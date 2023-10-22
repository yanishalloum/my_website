<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Cap;
use App\Entity\Inventory;
use App\Entity\Member;

class AppFixtures extends Fixture
{
    // defines reference names for instances of inventory
    private const JOHN_INVENTORY_1 = 'john-inventory-1';
    private const REDA_INVENTORY_1 = 'reda-inventory-1';

    /**
     * Generates initialization data for inventories: [title]
     * @return \Generator
     */
    private static function inventoryDataGenerator()
    {
        yield ["Reda's inventory", self::REDA_INVENTORY_1];
        yield ["John's inventory", self::JOHN_INVENTORY_1];
    }

    /**
     * @return \Generator
     */
    private static function capsGenerator()
    {
        yield [self::REDA_INVENTORY_1, "Chicago Bulls Snapback", 'navy blue', '54-60cm', 'very good', 'Starter',"90's"];
        yield [self::REDA_INVENTORY_1, "Grim Reaper Japan", 'navy blue', '54-60cm', 'perfect', 'Polo Ralph Lauren', ' ' ];
        yield [self::JOHN_INVENTORY_1, "San Francisco 49ers Snapback", 'red', '44-50cm', 'good', 'Starter', '1990'];
    }

    private static function memberGenerator()
    {
        yield ["Reda", self::REDA_INVENTORY_1];
        yield ["John", self::JOHN_INVENTORY_1];
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::inventoryDataGenerator() as [$name, $inventoryReference]) {
            $member = new Member();
            $member->setName($name);
            $manager->persist($member);
            $this->addReference($inventoryReference, $member);
        }

        foreach (self::inventoryDataGenerator() as [$name, $inventoryReference]) {
            $inventory = new Inventory();
            $inventory->setName($name);
            $inventory->setDescription('');
            $manager->persist($inventory);
            $this->addReference($inventoryReference, $inventory);
        }

        foreach (self::capsGenerator() as [$inventoryReference, $model, $color, $size, $condition, $brand, $year]) {
            $inventory = $this->getReference($inventoryReference);
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
        }

        $manager->flush();
    }
}
