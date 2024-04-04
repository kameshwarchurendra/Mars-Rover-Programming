<?php

// Interface for commands
interface Commands {
    public function execute(Rover $rover);
}

// Move forward command
class MoveCommand implements Commands {
    public function execute(Rover $rover) {
        $rover->move();
    }
}

// Turn left command
class TurnLeftCommand implements Commands {
    public function execute(Rover $rover) {
        $rover->turnLeft();
    }
}

// Turn right command
class TurnRightCommand implements Commands {
    public function execute(Rover $rover) {
        $rover->turnRight();
    }
}

// Receiver class (Rover)
class Rover {
    private $x;
    private $y;
    private $direction;

    public function __construct($x, $y, $direction) {
        $this->x = $x;
        $this->y = $y;
        $this->direction = $direction;
    }

    public function move() {
        switch ($this->direction) {
            case 'N':
                $this->y++;
                break;
            case 'S':
                $this->y--;
                break;
            case 'E':
                $this->x++;
                break;
            case 'W':
                $this->x--;
                break;
        }
    }

    public function turnLeft() {
        switch ($this->direction) {
            case 'N':
                $this->direction = 'W';
                break;
            case 'S':
                $this->direction = 'E';
                break;
            case 'E':
                $this->direction = 'N';
                break;
            case 'W':
                $this->direction = 'S';
                break;
        }
    }

    public function turnRight() {
        switch ($this->direction) {
            case 'N':
                $this->direction = 'E';
                break;
            case 'S':
                $this->direction = 'W';
                break;
            case 'E':
                $this->direction = 'S';
                break;
            case 'W':
                $this->direction = 'N';
                break;
        }
    }

    public function getPosition() {
        return array($this->x, $this->y);
    }

    public function getDirection() {
        return $this->direction;
    }
}

// Invoker class
class RemoteControl {
    private $commands = [];

    public function setCommand(Commands $command) {
        $this->commands[] = $command;
    }

    public function runCommands(Rover $rover) {
        foreach ($this->commands as $command) {
            $command->execute($rover);
        }
    }
}

// Obstacle class
class Obstacle {
    private $x;
    private $y;

    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }

    public function getPosition() {
        return array($this->x, $this->y);
    }
}

// Simulation
$rover = new Rover(0, 0, 'N');
$remoteControl = new RemoteControl();

// Add commands to the remote control
$remoteControl->setCommand(new MoveCommand());
$remoteControl->setCommand(new TurnRightCommand());
$remoteControl->setCommand(new MoveCommand());
$remoteControl->setCommand(new TurnLeftCommand());
$remoteControl->setCommand(new MoveCommand());

// Run commands
$remoteControl->runCommands($rover);

// Output current position and direction
echo "Current position: (" . implode(',', $rover->getPosition()) . ") Facing " . $rover->getDirection() . "\n";
?>