<?php declare(strict_types=1);

namespace Training\Legacy\Test\Integration;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\TestFramework\ObjectManager;

class DateTimeTest extends \PHPUnit\Framework\TestCase
{

    public function testGoldenMasterCalculateOffset()
    {
        foreach (\DateTimeZone::listIdentifiers() as $tz) {
            $result = $this->getGmtOffsetForTimezone($tz);
            $this->assertSame($this->getGoldenMasterForTimezone($tz), $result);
        }

        $this->assertTrue(true);
    }

    private function getGoldenMasterForTimezone($tz): int
    {
        $file = __DIR__ . '/golden-master/gmtOffset-' . $tz;
        if ( ! file_exists(dirname($file))) {
            mkdir(dirname($file), 0700, true);
        }

        if ( ! file_exists($file)) {
            file_put_contents($file, json_encode($this->getGmtOffsetForTimezone($tz)));
        }

        return json_decode(file_get_contents($file), true);
    }

    /**
     * @param $tz
     *
     * @return int
     */
    private function getGmtOffsetForTimezone($tz): int
    {
        /** @var DateTime $dateTime */
        $dateTime = ObjectManager::getInstance()->create(DateTime::class);
        $result = $dateTime->getGmtOffset($tz);

        return $result;
    }


    public function testGmtDate()
    {
        srand(1);
        $format = $this->generateGmtDateFormat();
        $input = time();

        /**
         * @var DateTime $dateTime
         */
        $dateTime = ObjectManager::getInstance()->create(DateTime::class);
        $result = $dateTime->gmtDate($format, $input);

        $this->assertNotEmpty($result);


    }

    public static function generateGmtDateFormat()
    {
        $formatChars = str_split('dDjlNSWZWFmMntLoYy');
        $separatorChars = array_merge(array_map(function ($c) {
            return '\\' . $c;
        }, range('a', 'z'), [':', '', '"', '\\z', '-']));

        $allChars = array_merge($formatChars, $separatorChars);

        $str = '';
        for ($length = rand(0,100); $length >= 0; $length--)
        {
            $str .= $allChars[array_rand($allChars)];
        }

        return $str;
    }
}
