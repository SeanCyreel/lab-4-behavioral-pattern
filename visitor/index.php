<?php
// Visitor Interface
interface Visitor {
    public function visitStudent(Student $student): void;
    public function visitFaculty(Faculty $faculty): void;
    public function visitAlumni(Alumni $alumni): void;
}

// Element Interface
interface Element {
    public function accept(Visitor $visitor): void;
}

// Concrete Elements
class Student implements Element {
    public function __construct(
        public string $id,
        public string $name,
        public string $program
    ) {}
    public function accept(Visitor $visitor): void {
        $visitor->visitStudent($this);
    }
}

class Faculty implements Element {
    public function __construct(
        public string $id,
        public string $name,
        public string $department
    ) {}
    public function accept(Visitor $visitor): void {
        $visitor->visitFaculty($this);
    }
}

class Alumni implements Element {
    public function __construct(
        public string $id,
        public string $name,
        public string $gradYear
    ) {}
    public function accept(Visitor $visitor): void {
        $visitor->visitAlumni($this);
    }
}

// Concrete Visitors
class CSVExportVisitor implements Visitor {
    public function visitStudent(Student $student): void {
        echo "CSV Export: {$student->id},{$student->name},{$student->program}\n";
    }
    public function visitFaculty(Faculty $faculty): void {
        echo "CSV Export: {$faculty->id},{$faculty->name},{$faculty->department}\n";
    }
    public function visitAlumni(Alumni $alumni): void {
        echo "CSV Export: {$alumni->id},{$alumni->name},{$alumni->gradYear}\n";
    }
}

class ReportVisitor implements Visitor {
    public function visitStudent(Student $student): void {
        echo "Report → Student: {$student->name} (ID: {$student->id}) — Program: {$student->program}\n";
    }
    public function visitFaculty(Faculty $faculty): void {
        echo "Report → Faculty: {$faculty->name} — Dept: {$faculty->department}\n";
    }
    public function visitAlumni(Alumni $alumni): void {
        echo "Report → Alumni: {$alumni->name} — Grad: {$alumni->gradYear}\n";
    }
}

class StatisticsVisitor implements Visitor {
    private int $students = 0;
    private int $faculty = 0;
    private int $alumni = 0;
    
    public function visitStudent(Student $student): void { $this->students++; }
    public function visitFaculty(Faculty $faculty): void { $this->faculty++; }
    public function visitAlumni(Alumni $alumni): void { $this->alumni++; }
    
    public function showStats(): void {
        echo "Statistics:\n";
        echo "Students: {$this->students}\n";
        echo "Faculty: {$this->faculty}\n";
        echo "Alumni: {$this->alumni}\n";
        echo "Total: " . ($this->students + $this->faculty + $this->alumni) . "\n";
    }
}

// Challenge: New visitor added WITHOUT modifying element classes
class PDFReportVisitor implements Visitor {
    public function visitStudent(Student $student): void {
        echo "[PDF] Student Record: {$student->name} | Program: {$student->program}\n";
    }
    public function visitFaculty(Faculty $faculty): void {
        echo "[PDF] Faculty Record: {$faculty->name} | Dept: {$faculty->department}\n";
    }
    public function visitAlumni(Alumni $alumni): void {
        echo "[PDF] Alumni Record: {$alumni->name} | Class of: {$alumni->gradYear}\n";
    }
}

// === DEMO ===
echo "=== Visitor Pattern Demo ===\n\n";

$records = [
    new Student("S001", "Juan Dela Cruz", "BSIT"),
    new Faculty("F001", "Prof. Reyes", "IT Department"),
    new Alumni("A001", "Maria Santos", "2025")
];

echo "--- CSV Export ---\n";
$csvVisitor = new CSVExportVisitor();
foreach ($records as $rec) $rec->accept($csvVisitor);

echo "\n--- Text Report ---\n";
$reportVisitor = new ReportVisitor();
foreach ($records as $rec) $rec->accept($reportVisitor);

echo "\n--- Statistics ---\n";
$statsVisitor = new StatisticsVisitor();
foreach ($records as $rec) $rec->accept($statsVisitor);
$statsVisitor->showStats();

echo "\n--- PDF Report (New Visitor, No Element Changes) ---\n";
$pdfVisitor = new PDFReportVisitor();
foreach ($records as $rec) $rec->accept($pdfVisitor);