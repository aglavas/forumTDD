<?php
// Our tests (yes, normally these would be in some other file)
class TestAverageCitizens extends \PHPUnit\Framework\TestCase {
    public function testSpyingLikeTheNSAShould() {
        $citizen = $this->createMock('App\AverageCitizen');
        $citizen->expects($spy = $this->any())
            ->method('spyOn');

        $citizen->spyOn("foo");

        dd($spy);

        $invocations = $spy->getInvocations();

        $this->assertEquals(1, count($invocations));

        // we can easily check specific arguments too

        $last = end($invocations);

        $this->assertEquals("foo", $last->getParameters()[0]);
    }

    public function testSpyingLikeTheNSADoes() {
        $citizen = $this->createMock('App\AverageCitizen');
        $citizen->expects($spy = $this->any())
            ->method('spyOn');


        $citizen->spyOn("foo");
        $citizen->spyOn("bar");

        $invocations = $spy->getInvocations();

        $this->assertEquals(2, count($invocations));
    }
}
