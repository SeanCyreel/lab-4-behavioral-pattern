<?php
class ProfileMemento {
    public function __construct(
        private string $name,
        private string $program,
        private int $year
    ) {}
    public function getState(): array {
        return [$this->name, $this->program, $this->year];
    }
}
class StudentProfile {
    public function __construct(
        private string $name,
        private string $program,
        private int $year
    ) {}
    public function save(): ProfileMemento {
        return new ProfileMemento($this->name, $this->program, $this->year);
    }
    public function restore(ProfileMemento $m): void {
        [$this->name, $this->program, $this->year] = $m->getState();
    }
    public function setProgramYear(string $p, int $y): void {
        $this->program = $p;
        $this->year = $y;
    }
    public function show(): void {
        echo "Name: $this->name | Program: $this->program | Year: $this->year\n";
    }
}
class ProfileHistory {
    private array $snapshots = [];
    public function push(ProfileMemento $m): void { $this->snapshots[] = $m; }
    public function pop(): ?ProfileMemento { return array_pop($this->snapshots); }
}

// DEMO
echo "=== Memento ===\n";
$profile = new StudentProfile("Juan Dela Cruz", "BSIT", 3);
$history = new ProfileHistory();
$history->push($profile->save());
echo "Original: "; $profile->show();

$profile->setProgramYear("BSCS", 4);
echo "Updated: "; $profile->show();

echo "\nUndo...\n";
$profile->restore($history->pop());
echo "Restored: "; $profile->show();