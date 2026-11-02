<?php
// Handler Interface
interface Handler {
    public function setNext(Handler $handler): Handler;
    public function handle(string $request): ?string;
}

// Abstract Handler
abstract class AbstractHandler implements Handler {
    private ?Handler $nextHandler = null;
    
    public function setNext(Handler $handler): Handler {
        $this->nextHandler = $handler;
        return $handler;
    }
    
    public function handle(string $request): ?string {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }
        return null;
    }
}

// Concrete Handlers
class StudentAffairsHandler extends AbstractHandler {
    public function handle(string $request): ?string {
        if (str_contains($request, "Good Moral") || str_contains($request, "Concern")) {
            return "Student Affairs: Processing $request...";
        }
        return parent::handle($request);
    }
}

class RegistrarHandler extends AbstractHandler {
    public function handle(string $request): ?string {
        if (str_contains($request, "Transcript") || str_contains($request, "Enrollment")) {
            return "Registrar: Processing $request...";
        }
        return parent::handle($request);
    }
}

class FinanceHandler extends AbstractHandler {
    public function handle(string $request): ?string {
        if (str_contains($request, "Fee") || str_contains($request, "Payment")) {
            return "Finance: Processing $request...";
        }
        return parent::handle($request);
    }
}

class ICTHandler extends AbstractHandler {
    public function handle(string $request): ?string {
        if (str_contains($request, "ID") || str_contains($request, "Account")) {
            return "ICT: Processing $request...";
        }
        return parent::handle($request);
    }
}

// DEMO
$studentAffairs = new StudentAffairsHandler();
$registrar = new RegistrarHandler();
$finance = new FinanceHandler();
$ict = new ICTHandler();

// Build chain
$studentAffairs->setNext($registrar)
               ->setNext($finance)
               ->setNext($ict);

echo "=== Chain of Responsibility Demo ===\n";
$requests = [
    "Transcript of Records",
    "Good Moral Certificate",
    "Student ID Concern"
];

foreach ($requests as $req) {
    echo "\nRequest: $req\n";
    $result = $studentAffairs->handle($req);
    if ($result) echo $result . "\n";
    else echo "No handler found.\n";
}