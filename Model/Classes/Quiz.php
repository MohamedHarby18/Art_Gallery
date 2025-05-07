<?php

class Quiz
{
    public int $customerId;
    private string $answers;

    public function __construct(int $customerId, string $answers = '') {
        $this->customerId = $customerId;
        $this->answers = $answers;
    }

   
    public function setInfo(string $answers): void {
        $this->answers = $answers;
    }

   
    public function giveQuizResult(): string {
        // Logic to calculate and return the result can be added later
        return "Quiz result for customer ID: " . $this->customerId;
    }

    
    public function getAnswers(): string {
        return $this->answers;
    }

    public function setAnswers(string $answers): void {
        $this->answers = $answers;
    }
}
?>
