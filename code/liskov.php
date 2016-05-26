<?php

class Vehicle {

    function startEngine() {
        // Default engine start functionality
    }

    function accelerate() {
        // Default acceleration functionality
	}
}


class Car extends Vehicle {

    function startEngine() {
        $this->engageIgnition();
        parent::startEngine();
    }

    private function engageIgnition() {
        // Ignition procedure
    }

}

class ElectricBus extends Vehicle {

    function accelerate() {
        $this->increaseVoltage();
        $this->connectIndividualEngines();
    }

    private function increaseVoltage() {
        // Electric logic
    }

    private function connectIndividualEngines() {
        // Connection logic
    }

}

// A client class should be able to use either of them, if it can use Vehicle.
class Driver {
    function go(Vehicle $v) {
        $v->startEngine();
        $v->accelerate();
    }
}


/*Based on our previous experience with the Open/Closed Principle, we can conclude that Liskov's Substitution Principle is in strong relation with OCP.
In fact, "a violation of LSP is a latent violation of OCP" (Robert C. Martin),
and the Template Method Design Pattern is a classic example of respecting and implementing LSP, which in turn is one of the solutions to respect OCP also. */



// The Classic Example of LSP violation
class Rectangle {

    private $topLeft;
    private $width;
    private $height;

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getWidth() {
        return $this->width;
    }
}

/* We start with a basic geometrical shape, a Rectangle. It is just a simple data object with setters and getters for width and height. Imagine that our application is working and it is already deployed to several clients. Now they need a new feature. They need to be able to manipulate squares.

In real life, in geometry, a square is a particular form of rectangle. So we could try to implement a Square class that extends a Rectangle class. It is frequently said that a child class is a parent class, and this expression also conforms to LSP, at least at first sight. */
class Square extends Rectangle {

	/* SMEEEELLLYYY */
    public function setHeight($value) {
        $this->width = $value;
        $this->height = $value;
    }

	/* ALSO SMELY */
    public function setWidth($value) {
        $this->width = $value;
        $this->height = $value;
    }

	function area() {
    	return $this->width * $this->height;
	}
}
/* But is a Square really a Rectangle in programming? */



class Client {

    function areaVerifier(Rectangle $r) {
        $r->setWidth(5);
        $r->setHeight(4);

        if($r->area() != 20) {
            throw new Exception('Bad area!');
        }

        return true;
    }

}


class LspTest extends PHPUnit_Framework_TestCase {

    function testRectangleArea() {
        $r = new Rectangle();
        $c = new Client();
        $this->assertTrue($c->areaVerifier($r));
    }

}
/*
Exception : Bad area!
#0 /paht/: /.../.../LspTest.php(18): Client->areaVerifier(Object(Square))
#1 [internal function]: LspTest->testSquareArea()
*/



