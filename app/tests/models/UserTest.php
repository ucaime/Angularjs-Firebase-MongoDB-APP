<?php

class UserTest extends TestCase {
	public function testThatTrueIsTrue() {
  		$this->assertTrue(true);
	}

 public function testIndex()
  {
      $this->get('account');
  }

}