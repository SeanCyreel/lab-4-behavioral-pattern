<?php
class Student {
    public function __construct(
        private string $id,
        private string $name
    ) {}
    public function getId(): string { return $this->id; }
    public function getName(): string { return $this->name; }
}

// Collection + Iterator
class StudentCollection implements \IteratorAggregate {
    private array $students = [];
    
    public function add(Student $s): void {
        $this->students[] = $s;
    }
    
    public function getIterator(): \Traversable {
        return new class($this->students) implements \Iterator {
            private int $pos = 0;
            public function __construct(private array $data) {}
            public function current(): Student { return $this->data[$this->pos]; }
            public function key(): int { return $this->pos; }
            public function next(): void { $this->pos++; }
            public function rewind(): void { $this->pos = 0; }
            public function valid(): bool { return isset($this->data[$this->pos]); }
        };
    }
}

// DEMO
$students = new StudentCollection();
$students->add(new Student("2026-001", "Juan"));
$students->add(new Student("2026-002", "Maria"));
$students->add(new Student("2026-003", "Pedro"));

echo "=== Iterator Demo ===\nStudent List:\n";
foreach ($students as $s) {
    echo "{$s->getId()} - {$s->getName()}\n";
}