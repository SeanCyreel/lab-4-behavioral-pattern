<?php
// Context
class StudentContext {
    public function __construct(public array $students) {}
    
    public function matches(array $criteria): array {
        return array_filter($this->students, fn($s) => $this->evaluate($s, $criteria));
    }
    
    private function evaluate($student, $criteria): bool {
        foreach ($criteria as $key => $val) {
            if ($student[$key] !== $val) return false;
        }
        return true;
    }
}

// Expression
interface Expression {
    public function interpret(array $student): bool;
}

class ProgramExp implements Expression {
    public function __construct(private string $val) {}
    public function interpret(array $s): bool { return $s['program'] === $this->val; }
}

class YearExp implements Expression {
    public function __construct(private int $val) {}
    public function interpret(array $s): bool { return $s['year'] === $this->val; }
}

class AndExp implements Expression {
    public function __construct(
        private Expression $a,
        private Expression $b
    ) {}
    public function interpret(array $s): bool {
        return $this->a->interpret($s) && $this->b->interpret($s);
    }
}

class OrExp implements Expression {
    public function __construct(
        private Expression $a,
        private Expression $b
    ) {}
    public function interpret(array $s): bool {
        return $this->a->interpret($s) || $this->b->interpret($s);
    }
}

// DEMO
$students = [
    ['id'=>'001','name'=>'Juan','program'=>'BSIT','year'=>4],
    ['id'=>'002','name'=>'Maria','program'=>'BSCS','year'=>3],
    ['id'=>'003','name'=>'Pedro','program'=>'BSIT','year'=>3]
];

echo "=== Interpreter Demo ===\n";
echo "Expression: PROGRAM = BSIT AND YEAR = 4\n";
$expr = new AndExp(new ProgramExp("BSIT"), new YearExp(4));

foreach ($students as $s) {
    $result = $expr->interpret($s) ? "TRUE" : "FALSE";
    echo "{$s['name']}: $result\n";
}

echo "\nExpression: PROGRAM = BSIT OR PROGRAM = BSCS\n";
$expr2 = new OrExp(new ProgramExp("BSIT"), new ProgramExp("BSCS"));
foreach ($students as $s) {
    echo "{$s['name']}: " . ($expr2->interpret($s) ? "MATCH" : "NO") . "\n";
}