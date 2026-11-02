<?php
interface EnrollState {
    public function enroll(Student $ctx): string;
}
class Student {
    private EnrollState $state;
    public function __construct(EnrollState $s) { $this->state = $s; }
    public function setState(EnrollState $s): void { $this->state = $s; }
    public function getState(): EnrollState { return $this->state; }
    public function tryEnroll(): string { return $this->state->enroll($this); }
}

class ApplicantState implements EnrollState {
    public function enroll(Student $ctx): string {
        return "Current: Applicant → Action: Enroll → Result: Complete pre-assessment first.";
    }
}
class PreAssessedState implements EnrollState {
    public function enroll(Student $ctx): string {
        $ctx->setState(new EnrolledState());
        return "Current: Pre-Assessed → Action: Enroll → Result: Successfully enrolled!";
    }
}
class EnrolledState implements EnrollState {
    public function enroll(Student $ctx): string {
        return "Current: Enrolled → Already enrolled.";
    }
}
class DroppedState implements EnrollState {
    public function enroll(Student $ctx): string {
        return "Current: Dropped → Cannot re-enroll automatically.";
    }
}
class GraduatedState implements EnrollState {
    public function enroll(Student $ctx): string {
        return "Current: Graduated → Graduation completed.";
    }
}

// DEMO
echo "=== State ===\n";
$student = new Student(new ApplicantState());
echo $student->tryEnroll() . "\n";

$student->setState(new PreAssessedState());
echo $student->tryEnroll() . "\n";

echo $student->tryEnroll() . "\n"; // now Enrolled