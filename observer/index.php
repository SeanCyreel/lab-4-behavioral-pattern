<?php
interface Subject {
    public function attach(Observer $o): void;
    public function detach(Observer $o): void;
    public function notify(): void;
}
interface Observer {
    public function update(float $grade): void;
}

class GradeSystem implements Subject {
    private array $observers = [];
    public float $grade;
    public function attach(Observer $o): void { $this->observers[] = $o; }
    public function detach(Observer $o): void {
        $idx = array_search($o, $this->observers);
        if ($idx !== false) array_splice($this->observers, $idx, 1);
    }
    public function notify(): void {
        foreach ($this->observers as $o) $o->update($this->grade);
    }
    public function setGrade(float $g): void {
        $this->grade = $g;
        echo "Grade updated: $g\n";
        $this->notify();
    }
}

class StudentPortal implements Observer {
    public function update(float $grade): void { echo "Student Portal: New grade posted: $grade\n"; }
}
class EmailNotification implements Observer {
    public function update(float $grade): void { echo "Email Notification: Your grade has been updated to $grade\n"; }
}
class ParentNotification implements Observer {
    public function update(float $grade): void { echo "Parent Notification: Student grade is now $grade\n"; }
}
// Challenge: New observer — no change to GradeSystem
class SMSNotification implements Observer {
    public function update(float $grade): void { echo "SMS: Grade updated to $grade\n"; }
}

// DEMO
echo "=== Observer ===\n";
$sys = new GradeSystem();
$sys->attach(new StudentPortal());
$sys->attach(new EmailNotification());
$sys->attach(new ParentNotification());
$sys->attach(new SMSNotification()); // added without modifying GradeSystem
$sys->setGrade(1.75);