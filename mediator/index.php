<?php
interface ChatMediator {
    public function sendMessage(string $msg, Student $from): void;
    public function addUser(Student $u): void;
}
class Student {
    public function __construct(
        public string $name,
        private ChatMediator $mediator
    ) {}
    public function send(string $msg): void {
        echo "$this->name: Sending message...\n";
        $this->mediator->sendMessage($msg, $this);
    }
    public function receive(string $msg, string $from): void {
        echo "$this->name receives: $from: $msg\n";
    }
}
class ChatRoom implements ChatMediator {
    private array $users = [];
    public function addUser(Student $u): void { $this->users[] = $u; }
    public function sendMessage(string $msg, Student $from): void {
        foreach ($this->users as $u) {
            if ($u !== $from) $u->receive($msg, $from->name);
        }
    }
}

// DEMO
echo "=== Mediator ===\n";
$chat = new ChatRoom();
$juan = new Student("Juan", $chat);
$maria = new Student("Maria", $chat);
$pedro = new Student("Pedro", $chat);
$chat->addUser($juan);
$chat->addUser($maria);
$chat->addUser($pedro);
$juan->send("Hello everyone!");