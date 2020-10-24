https://jtreminio.com/blog/unit-testing-tutorial-part-ii-assertions-writing-a-useful-test-and-dataprovider/
https://medium.com/@MustafaMagdi

{
    "require": {
    },
    "require-dev": {
        "phpunit/phpunit": "3.7.14"
    },
    "autoload": {
        "psr-0": {
            "phpUnitTutorial": ""
        }
    }
}

./composer.phar update

./vendor/bin/phpunit

phpunit.xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit colors="true">
    <testsuites>
        <testsuite name="Application Test Suite">
            <directory>./phpUnitTutorial/Test/</directory>
        </testsuite>
    </testsuites>
</phpunit>

/////
composer.json
composer.phar
phpUnitTutorial/
phpUnitTutorial/Test/
vendor/
//////


Writing test with data provider

<?php

namespace phpUnitTutorial\Test;

use phpUnitTutorial\URL;

class URLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $originalString String to be sluggified
     * @param string $expectedResult What we expect our slug result to be
     *
     * @dataProvider providerTestSluggifyReturnsSluggifiedString
     */
    public function testSluggifyReturnsSluggifiedString($originalString, $expectedResult)
    {
        $url = new URL();

        $result = $url->sluggify($originalString);

        $this->assertEquals($expectedResult, $result);
    }

    public function providerTestSluggifyReturnsSluggifiedString()
    {
        return array(
            array('This string will be sluggified', 'this-string-will-be-sluggified'),
            array('THIS STRING WILL BE SLUGGIFIED', 'this-string-will-be-sluggified'),
            array('This1 string2 will3 be 44 sluggified10', 'this1-string2-will3-be-44-sluggified10'),
            array('This! @string#$ %$will ()be "sluggified', 'this-string-will-be-sluggified'),
            array("Tänk efter nu – förr'n vi föser dig bort", 'tank-efter-nu-forrn-vi-foser-dig-bort'),
            array('', ''),
        );
    }
}

//
// Using invokeMethod


/**
 * Call protected/private method of a class.
 *
 * @param object &$object    Instantiated object that we will run method on.
 * @param string $methodName Method name to call
 * @param array  $parameters Array of parameters to pass into method.
 *
 * @return mixed Method return.
 */
public function invokeMethod(&$object, $methodName, array $parameters = array())
{
    $reflection = new \ReflectionClass(get_class($object));
    $method = $reflection->getMethod($methodName);
    $method->setAccessible(true);

    return $method->invokeArgs($object, $parameters);
}

// COVERAGE REPORT
./vendor/bin/phpunit --coverage-html coverage

// Mocking Objects

<?php

namespace phpUnitTutorial\Test;

use phpUnitTutorial\Payment;

class PaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testProcessPaymentReturnsTrueOnSuccessfulPayment()
    {
        $paymentDetails = array(
            'amount'   => 123.99,
            'card_num' => '4111-1111-1111-1111',
            'exp_date' => '03/2013',
        );

        $payment = new Payment();

        $response = new \stdClass();
        $response->approved = true;
        $response->transaction_id = 123;

        $authorizeNet = $this->getMockBuilder('\AuthorizeNetAIM')
            ->setConstructorArgs(array($payment::API_ID, $payment::TRANS_KEY))
            ->getMock();

        $authorizeNet->expects($this->once())
            ->method('authorizeAndCapture')
            ->will($this->returnValue($response));

        $result = $payment->processPayment($authorizeNet, $paymentDetails);

        $this->assertTrue($result);
    }
}
