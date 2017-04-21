<?php 

const SIMULATIONS = 1000000;

/**
 * @return array
 */
function getHand($highest_card = 100) {
	$cards = range(1, $highest_card);
	shuffle($cards);

	return array_slice($cards, 0, 10);
};

echo "Simulations: " . SIMULATIONS . "\n==========================\n\n";

echo "thrsh.\twins\tlosses\tpercentage\n";

for ($threshold = 0; $threshold <= 100; $threshold++) {
	$score = ['wins' => 0, 'losses' => 0];

	for ($simluations = 0; $simluations < SIMULATIONS; $simluations++) {
		$hand = getHand(100);
		$original_hand = $hand;

		$sizeof_hand = count($hand);

		for ($i = 0; $i < $sizeof_hand; $i++) {
			$current_card = array_pop($hand);

			if (count($hand) > 0) {
				$choice = ($current_card > $threshold);

				if ($choice) {
					break;
				}
			} else {
				// Last card in the deck!
			}
		}

		$cards_that_beat_yours = array_filter($original_hand, function($a) use ($current_card) { return $a > $current_card; });
		if ($cards_that_beat_yours) {
			// You lost!
			$score['losses'] += 1;
		} else {
			// You won!
			$score['wins'] += 1;
		}
	}

	$percentage = $score['wins'] / ($score['wins'] + $score['losses']);

	echo "Threshold: $threshold\t| {$score['wins']} - {$score['losses']} ({$percentage}%)\n";
	// echo "$threshold\t{$score['wins']}\t{$score['losses']}\t{$percentage}\n";
}

echo "\nThanks for playing!\n";
