<?php
// Command Interface
interface Command {
    public function execute(): void;
    public function undo(): void;
}

// Receiver
class StudentSystem {
    private array $enrolled = [];
    private array $dropped = [];
    
    public function enroll(string $id): void {
        $this->enrolled[] = $id;
        echo "Student $id successfully enrolled.\n";
    }
    
    public function drop(string $subj): void {
        $this->dropped[] = $subj;
        echo "Subject $subj successfully dropped.\n";
    }
    
    public function getEnrolled(): array { return $this->enrolled; }
}

// Concrete Commands
class EnrollCommand implements Command {
    public function __construct(
        private StudentSystem $system,
        private string $studentId
    ) {}
    
    public function execute(): void {
        echo "Executing: Enroll Student\n";
        $this->system->enroll($this->studentId);
    }
    
    public function undo(): void {
        echo "Undo: Withdrawing enrollment for {$this->studentId}\n";
    }
}

class DropSubjectCommand implements Command {
    public function __construct(
        private StudentSystem $system,
        private string $subject
    ) {}
    
    public function execute(): void {
        echo "Executing: Drop Subject\n";
        $this->system->drop($this->subject);
    }
    
    public function undo(): void {
        echo "Undo: Restoring subject {$this->subject}\n";
    }
}

// Invoker
class Invoker {
    private array $history = [];
    
    public function execute(Command $cmd): void {
        $cmd->execute();
        $this->history[] = $cmd;
    }
    
    public function undoLast(): void {
        if (!empty($this->history)) {
            $cmd = array_pop($this->history);
            $cmd->undo();
        }
    }
}

// DEMO
$system = new StudentSystem();
$invoker = new Invoker();

echo "=== Command Pattern Demo ===\n";
$invoker->execute(new EnrollCommand($system, "2026-001"));
$invoker->execute(new DropSubjectCommand($system, "IT101"));
echo "\n--- Undo ---\n";
$invoker->undoLast();