<?php
abstract class Report {
    // Template Method — defines fixed workflow
    final public function generateReport(): void {
        $this->generateHeader();
        $data = $this->retrieveData();
        $formatted = $this->formatData($data);
        $this->displayData($formatted);
        $this->generateFooter();
    }
    
    abstract protected function generateHeader(): void;
    abstract protected function retrieveData(): array;
    abstract protected function formatData(array $data): string;
    abstract protected function displayData(string $formatted): void;
    abstract protected function generateFooter(): void;
}

class StudentReport extends Report {
    protected function generateHeader(): void {
        echo "==========================\n";
        echo "        STUDENT REPORT\n";
        echo "==========================\n";
    }
    
    protected function retrieveData(): array {
        return [
            'id' => '2026-001',
            'name' => 'Juan Dela Cruz',
            'program' => 'BSIT'
        ];
    }
    
    protected function formatData(array $data): string {
        return sprintf(
            "Student ID: %s\nName: %s\nProgram: %s\n",
            $data['id'],
            $data['name'],
            $data['program']
        );
    }
    
    protected function displayData(string $formatted): void {
        echo $formatted;
    }
    
    protected function generateFooter(): void {
        echo "==========================\n";
        echo "       END OF REPORT\n";
        echo "==========================\n";
    }
}

class GradeReport extends Report {
    protected function generateHeader(): void {
        echo "--------------------------\n";
        echo "         GRADE REPORT\n";
        echo "--------------------------\n";
    }
    
    protected function retrieveData(): array {
        return [
            ['subject' => 'IT101', 'grade' => 1.75],
            ['subject' => 'IT102', 'grade' => 2.00],
            ['subject' => 'IT103', 'grade' => 1.50]
        ];
    }
    
    protected function formatData(array $data): string {
        $out = "";
        foreach ($data as $row) {
            $out .= sprintf("%-10s | %.2f\n", $row['subject'], $row['grade']);
        }
        return $out;
    }
    
    protected function displayData(string $formatted): void {
        echo $formatted;
    }
    
    protected function generateFooter(): void {
        echo "--------------------------\n";
        echo "  Average: 1.75\n";
        echo "--------------------------\n";
    }
}

class EnrollmentReport extends Report {
    protected function generateHeader(): void {
        echo "<<<<<<<<<<<<<<<<<<<<<<<<<<\n";
        echo "     ENROLLMENT REPORT\n";
        echo "<<<<<<<<<<<<<<<<<<<<<<<<<<\n";
    }
    
    protected function retrieveData(): array {
        return [
            'status' => 'Enrolled',
            'semester' => '1st Semester',
            'schoolYear' => '2026-2027'
        ];
    }
    
    protected function formatData(array $data): string {
        return sprintf(
            "Status: %s\nSemester: %s\nSchool Year: %s\n",
            $data['status'],
            $data['semester'],
            $data['schoolYear']
        );
    }
    
    protected function displayData(string $formatted): void {
        echo $formatted;
    }
    
    protected function generateFooter(): void {
        echo "<<<<<<<<<<<<<<<<<<<<<<<<<<\n";
        echo "   Enrollment Verified\n";
        echo "<<<<<<<<<<<<<<<<<<<<<<<<<<\n";
    }
}

// === DEMO ===
echo "=== Template Method Pattern Demo ===\n\n";

echo "--- Student Report ---\n";
(new StudentReport())->generateReport();

echo "\n--- Grade Report ---\n";
(new GradeReport())->generateReport();

echo "\n--- Enrollment Report ---\n";
(new EnrollmentReport())->generateReport();