<?php
interface GradeStrategy {
    public function calculate(array $scores): float;
}

class SimpleAverageStrategy implements GradeStrategy {
    public function calculate(array $scores): float {
        $total = array_sum($scores);
        $count = count($scores);
        return round($total / $count, 2);
    }
}

class WeightedAverageStrategy implements GradeStrategy {
    public function calculate(array $scores): float {
        // Equal weights by default; adjust as needed
        $weights = [0.25, 0.25, 0.25, 0.25];
        $sum = 0;
        foreach ($scores as $i => $score) {
            $sum += $score * ($weights[$i] ?? 1 / count($scores));
        }
        return round($sum, 2);
    }
}

// Challenge: New strategy added WITHOUT modifying GradeCalculator
class TransmutedGradeStrategy implements GradeStrategy {
    public function calculate(array $scores): float {
        // Example transmutation: raw score → percentage
        $average = array_sum($scores) / count($scores);
        if ($average >= 90) return 1.00;
        if ($average >= 85) return 1.50;
        if ($average >= 80) return 2.00;
        if ($average >= 75) return 3.00;
        return 5.00;
    }
}

class GradeCalculator {
    private GradeStrategy $strategy;
    
    public function setStrategy(GradeStrategy $strategy): void {
        $this->strategy = $strategy;
    }
    
    public function compute(array $scores): float {
        return $this->strategy->calculate($scores);
    }
}

// === DEMO ===
echo "=== Strategy Pattern Demo ===\n";
$calculator = new GradeCalculator();
$scores = [85, 90, 88, 91];

echo "Strategy: Simple Average\n";
$calculator->setStrategy(new SimpleAverageStrategy());
echo "Result: " . $calculator->compute($scores) . "\n";

echo "\nStrategy: Weighted Average\n";
$calculator->setStrategy(new WeightedAverageStrategy());
echo "Result: " . $calculator->compute($scores) . "\n";

echo "\nStrategy: Transmuted Grade\n";
$calculator->setStrategy(new TransmutedGradeStrategy());
echo "Result: " . $calculator->compute($scores) . "\n";