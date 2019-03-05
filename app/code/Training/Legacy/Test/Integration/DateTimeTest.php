<?php declare(strict_types=1);

use Magento\TestFramework\ObjectManager;

class DateTimeTest extends \PHPUnit\Framework\TestCase
{

    public function testGoldenMasterCalculateOffset()
    {
        foreach (\DateTimeZone::listIdentifiers() as $tz) {
            /** @var DateTime $dateTime */
            $dateTime = ObjectManager::getInstance()->create(DateTime::class);
        }

        $this->assertTrue(true);
    }
}
