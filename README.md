Liip Load Fixture Files Test
============================

[![Build Status](https://api.travis-ci.org/mathieu-ducrot/liip-load-fixture-files-test.png?branch=master)](https://travis-ci.org/mathieu-ducrot/liip-load-fixture-files-test)

Testing the loadFixtureFiles from the [LiipFunctionalTestBundle](https://github.com/liip/LiipFunctionalTestBundle) on
database functional test.

## Installation

You need to have docker and docker-compose. Then open the terminal on the path you clone this repository and run the 
command `make install` (Keep typing Enter when you are on the 'Creating the "app/config/parameters.yml" file' step).

## Test

**CASE 1 : Alice loading and the dummy EntityTestCommand**

```sh
# Connect to the php container
make ssh-php
# Load the fixture with alice from AppBundle\DataFixtures\Tests\Loader.php
make orm.load-test 
# Launch the test from the dummy EntityTestCommand (php app/console entity:test)
make orm.dummy-test 
```

It will prompt you this :

```
Test entity association

3 conditions loaded

 - condition cond_without_criteria with 0 criteria

 - condition cond_with_one_criteria with 1 criteria
 -- criteria Criteria A

 - condition cond_with_two_criteria with 2 criteria
 -- criteria Criteria B
 -- criteria Criteria B
```

We can see that entities has been correctly loaded with alice and the mapping/association is good because we did
find our 3 conditions and there respectives criteria describe in the fixture from the directory    
src/AppBundle/Tests/fixtures/condition/

_This case is only here for demo purpose to show how it should behave with the correct testing environment._


**CASE 2 : Real Functionnal Test with loadind fixtures by loadFixtureFiles from the LiipFunctionalTestBundle**

```sh
# Connect to the php container
make ssh-php
# Run the real ConditionTest with LiipFunctionalTestBundle and PHPUnit
make phpunit
## Same as bin/phpunit -c app/ src/AppBundle/Tests/Entity/ConditionTest.php
```

It will prompt you this :

```
PHPUnit 5.7.27 by Sebastian Bergmann and contributors.

F                                                                   1 / 1 (100%)
 - condition cond_without_criteria with 0 criteria
 - condition cond_with_one_criteria with 0 criteria

Time: 270 ms, Memory: 10.00MB

There was 1 failure:

1) AppBundle\Tests\Entity\ConditionsTest::testGetCriteriaInCondition
Failed asserting that 0 matches expected 1.

/var/www/src/AppBundle/Tests/Entity/ConditionTest.php:57

FAILURES!
Tests: 1, Assertions: 3, Failures: 1.
```

_Look at the content of the src/AppBundle/Tests/Entity/ConditionTest.php file while reading the text below_ 

On this case, we can clearly see that the first Assertion did work for number of condition loaded which is 3.

The second assertion did work too because $expectedNbCriteria start with 0 and the first condition loaded by the fixture
don't have any criteria so that right.

But the issue comes on the third assertion, where $expectedNbCriteria is now equal to one due to the increment from the 
loop and we know at this point that the second condition on the assert is cond_with_one_criteria from the fixture that
have one criteria.

When debugging the content of getCriteriaInCondition i can see that the return from the getter is always empty, like hydration did not work or something.  
Also when looking at the database after the `make phpunit` command i can see that all tables are well loaded.

That the part that i don't understand and so the origin for my issue https://github.com/liip/LiipFunctionalTestBundle/issues/553

So I will keep listen to your feeback, if you could help me to understand what am i doing wrong ? Thanks for your time !

## Annexe - Dependancies

- PHP 7.1 from the Dockerfile
- symfony/symfony 3.4.26
- doctrine/orm 2.7.0
- doctrine/dbal 2.9.3
- doctrine/doctrine-fixtures-bundle 2.4.1
- nelmio/alice 2.3.5
- liip/functional-test-bundle 1.11.0
- phpunit/phpunit 5.7.27